<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $builder, string $term = '')
    {
        if (!$this->searchable) {
            throw new Exception('Please define the searchable property.');
        }
        foreach ($this->searchable as $searchable) {
            if (str_contains($searchable, '.')) {
                $searchable = str($searchable);
                $relation = $searchable->beforeLast('.')->value();
                $column = $searchable->afterLast('.')->value();
                $builder->orWhereRelation($relation, $column, 'like', "%$term%");
                continue;
            }
            $builder->orWhere($searchable, 'like', "%$term%");
        }
        return $builder;
    }
}
