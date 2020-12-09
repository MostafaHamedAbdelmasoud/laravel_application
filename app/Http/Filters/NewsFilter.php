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
        'news_sub_category_id',
        'news_category_id',
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

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function news_sub_category_id($value)
    {
        if ($value) {
            return $this->builder->where('news_sub_category_id', "$value");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function news_category_id($value)
    {
        if ($value) {
            return $this->builder->where('news_category_id', "$value");
        }

        return $this->builder;
    }
}
