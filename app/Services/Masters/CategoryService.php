<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\CategoryData;
use App\Http\Requests\Masters\CategoryStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\Category\BulkJob;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Category;
use App\Repositories\Masters\CategoryRepository;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected static CategoryRepository $categoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        self::$categoryRepository = $categoryRepository;
    }

    public function all()
    {
        return self::$categoryRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return self::$categoryRepository->selectByAttributes($others);
    }

    public function updateOrCreate(CategoryStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $category = self::$categoryRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($category, $request->key);
            return $category;
        });
    }

    public static function store(array $data)
    {
        if (!isset($data['id']) || !isset($data['name'])) {
            return null;
        }
        if ($category = self::$categoryRepository->check($data['name'])) {
            return $category;
        }
        return Category::query()->create([
            'id' => $data['id'],
            'name' => $data['name']
        ]);
    }

    public function delete(Category $category)
    {
        return DB::transaction(function () use ($category) {
            Message::deleted(Topic::CATEGORY, 'id', $category->getKey(), Nested::CATEGORY);
            return self::$categoryRepository->destroy($category);
        });
    }

    public function getDataForEdit($id): array
    {
        return self::$categoryRepository->findOrFail($id)?->toArray();
    }

    private function sendToElasticsearch(Category $category, $key)
    {
        if ($key) {
            Message::updated(
                Topic::CATEGORY,
                'id',
                $category->getKey(),
                Nested::CATEGORY,
                $category->toArray()
            );
        }
    }

    public function bulk(array $categories = [])
    {
        return Elasticsearch::setModel(Category::class)
            ->bulk(CategoryData::collection($categories));
    }

    public function instanceBulk(Batch $batch)
    {
        $categories = self::$categoryRepository->getAllDataWithRelations()->toArray();
        foreach (array_chunk($categories, 10) as $categories) {
            $batch->add(new BulkJob($categories));
        }
        return $batch;
    }
}
