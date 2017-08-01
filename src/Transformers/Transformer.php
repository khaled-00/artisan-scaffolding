<?php

namespace Laraeast\Artisan\Scaffolding\Transformers;

use Illuminate\Pagination\LengthAwarePaginator;

abstract class Transformer
{
    /**
     * Transform a collection of items.
     *
     * @param \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator $items
     * @param string $method
     * @return array|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function collection($items, $method = 'model')
    {
        $map = $items->map(function ($item) use ($method) {
            return $this->{$method}($item);
        })->toArray();

        // Determine if items is a paginator instance.
        if ($items instanceof LengthAwarePaginator) {
            $map = paginate($map, $items->perPage());
        }

        return $map;
    }

    /**
     * Transform a model instance.
     *
     * @param $item
     * @return array
     */
    abstract public function model($model);
}
