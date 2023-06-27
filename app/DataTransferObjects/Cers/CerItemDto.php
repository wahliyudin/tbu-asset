<?php

namespace App\DataTransferObjects\Cers;

use App\Helpers\Helper;
use App\Http\Requests\Cers\CerRequest;
use Illuminate\Support\Collection;

class CerItemDto
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $model = null,
        public readonly ?string $est_umur = null,
        public readonly ?string $qty = null,
        public readonly ?int $price = null,
        public readonly ?string $uom = null,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromArray(array $data): Collection
    {
        $results = [];
        foreach (isset($data['items']) ? $data['items'] : [] as $key => $value) {
            $results = array_merge($results, [new self(
                isset($value['description']) ? $value['description'] : null,
                isset($value['model']) ? $value['model'] : null,
                isset($value['est_umur']) ? $value['est_umur'] : null,
                isset($value['qty']) ? $value['qty'] : null,
                isset($value['price']) ? $value['price'] : null,
                isset($value['uom']) ? $value['uom'] : null,
                isset($value['key']) ? $value['key'] : null,
            )]);
        }
        return collect($results);
    }

    public static function fromArrayToAttach(array $data): array
    {
        $results = [];
        foreach ($data as $key => $value) {
            array_push($results, [
                'description' => isset($value['description']) ? $value['description'] : null,
                'model' => isset($value['model']) ? $value['model'] : null,
                'est_umur' => isset($value['est_umur']) ? $value['est_umur'] : null,
                'qty' => isset($value['qty']) ? $value['qty'] : null,
                'price' => isset($value['price']) ? Helper::resetRupiah($value['price']) : null,
                'uom' => isset($value['uom']) ? $value['uom'] : null,
                'key' => isset($value['key']) ? $value['key'] : null,
            ]);
        }
        return $results;
    }

    public static function fromCollection(Collection $items)
    {
        $results = [];
        foreach ($items as $key => $value) {
            $results = array_merge($results, [new self(
                isset($value->description) ? $value->description : null,
                isset($value->model) ? $value->model : null,
                isset($value->est_umur) ? $value->est_umur : null,
                isset($value->qty) ? $value->qty : null,
                isset($value->price) ? $value->price : null,
                isset($value->uom) ? $value->uom : null,
                $value->getKey(),
            )]);
        }
        return collect($results);
    }
}
