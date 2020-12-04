<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProductType extends Model
{
//    use SoftDeletes;

    public $table = 'sub_product_types';

    protected $dates = [
        'created_at',
        'updated_at',

    ];


    protected $fillable = [
        'name',
        'main_product_type_id',
        'created_at',
        'updated_at',

    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getForeignKey()
    {
        return 'sub_product_type_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function MainProductType()
    {
        return $this->belongsTo(MainProductType::class);
    }
}
