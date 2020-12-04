<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainProductServiceType extends Model
{
//    use SoftDeletes;

    public $table = 'main_product_service_types';

    protected $dates = [
        'created_at',
        'updated_at',

    ];


    protected $fillable = [
        'name',
        'created_at',
        'updated_at',

    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SubProductServiceTypes()
    {
        return $this->hasMany(SubProductServiceType::class);
    }
}
