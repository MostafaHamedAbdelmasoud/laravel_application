<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;

class NewsFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'details',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function details($value)
    {
        if ($value) {
            return $this->builder->where('details', 'like', "%$value%");
        }

        return $this->builder;
    }
}
