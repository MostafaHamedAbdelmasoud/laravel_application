<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Coupon extends Model
{
    use Filterable;

    const TYPE_RADIO = [
        'percentage_discount' => 'نسبة مئوية',
        'fixed_discount' => 'قيمة ثايتة',
    ];

    /**
     * @var string
     */
    protected $table = 'coupons';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'percentage_discount',
        'fixed_discount',
        'max_usage_per_user',
        'min_total',
    ];

    /**
     * it defines foreign key in relations.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'coupon_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
