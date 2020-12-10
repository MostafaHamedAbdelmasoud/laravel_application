<?php

namespace App\Http\Filters;

class DepartmentsFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'about',
        'type',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function about($value)
    {
        if ($value) {
            return $this->builder->where('about', 'like', "%$value%");
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

}
