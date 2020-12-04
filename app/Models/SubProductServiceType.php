<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProductServiceType extends Model
{
//    use SoftDeletes;

    public $table = 'sub_product_service_types';

    protected $dates = [
        'created_at',
        'updated_at',

    ];


    protected $fillable = [
        'name',
        'main_product_service_type_id',
        'created_at',
        'updated_at',

    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function MainProductServiceType()
    {
        return $this->belongsTo(MainProductServiceType::class);
    }
}
