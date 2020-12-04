<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class ProductVariant extends Model
{
//    use SoftDeletes;

    public $table = 'product_variant';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $with=[
        'variant',
    ];

    protected $fillable = [
        'product_id',
        'variant_id',
    ];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
