<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class CouponProduct extends Model
{
    use Filterable;

    /**
     * @var string
     */
    public $table = 'coupon_products';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'model_id',
        'model_type',
        'type',
        'coupon_id',
    ];


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    public $with = [
        'product',
        'coupon'
    ];

    /**
     * it defines foreign key in relations.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'coupon_product_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
