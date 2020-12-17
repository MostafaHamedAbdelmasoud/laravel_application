<?php

namespace App\Http\Filters;

class ProductsFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'SortByLowerPrice',
        'RecentlyAdded',
        'PriceAfterDiscount',
        'HigherPrice',
        'LowerPrice',
        'Brand',
        'Color',
        'Size',
    ];

    /**
     * Filter the query by a price.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function SortByLowerPrice($value)
    {
        if ($value == 0) {
            return $this->builder->orderBy('price_after_discount', 'DESC');
        } elseif ($value == 1) {
            return $this->builder->orderBy('price_after_discount', 'ASC');
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given recently.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function RecentlyAdded($value)
    {
        if ($value) {
            return $this->builder->orderBy('updated_at', 'DESC');
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given Brand.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function Brand($value)
    {
        if ($value) {
            return $this->builder->where('brand', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given PriceAfterDiscount.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function PriceAfterDiscount($value)
    {
        if ($value) {
            return $this->builder->whereNotNull('price_after_discount')->Where('price_after_discount', '!=', 0)->WhereColumn('price_after_discount', '!=', 'price');
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given range with higher price_after_discount.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function HigherPrice($value)
    {
        if ($value) {
            return $this->builder->Where('price_after_discount', '<=', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given range with higher price_after_discount.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function LowerPrice($value)
    {
        if ($value) {
            return $this->builder->Where('price_after_discount', '>=', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given color.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function Color($value)
    {
        if ($value) {
            return $this->builder->WhereHas('variants', function ($q) use ($value) {
                $q->where('color', 'like', "%$value%");
            });
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given size.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function Size($value)
    {
        if ($value) {
            return $this->builder->WhereHas('variants', function ($q) use ($value) {
                $q->where('size', 'like', "%$value%");
            });
        }

        return $this->builder;
    }
}
