<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class OrderProductFieldValue extends Model
{
    use Filterable;

    /**
     * @var string
     */
    public $table = 'order_product_field_values';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'order__product_id',
        'custom_field_id',
        'value',
        'option_id',
        'additional_price',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'customField',
        'customFieldOption',
    ];

    /**
     * it defines foreign key in relations.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'order_product_field_value_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customFieldOption()
    {
        return $this->belongsTo(CustomFieldOption::class, 'option_id');
    }
}
