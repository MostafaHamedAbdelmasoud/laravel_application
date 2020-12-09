<?php

namespace App\Http\Filters;

class OffersFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'description',
        'type',
        'sub_category_id',
    ];

    /**
     * Filter the query by a given description.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function description($value)
    {
        if ($value) {
            return $this->builder->where('description', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query by a given type.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($value)
    {
        if ($value) {
            return $this->builder->whereHas('category', function ($q) use ($value) {
                $q->where('name', 'like', "%$value%");
            });
        }

        return $this->builder;
    }
    /**
     * Filter the query by a given type.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function sub_category_id($value)
    {
        if ($value) {
            return $this->builder->where('sub_category_id', "$value");
        }

        return $this->builder;
    }
}
