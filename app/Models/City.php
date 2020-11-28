<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class City extends Model
{
    use SoftDeletes,Filterable;

    public $table = 'cities';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function cityDepartments()
    {
        return $this->hasMany(Department::class, 'city_id', 'id');
    }

    public function cityNews()
    {
        return $this->hasMany(News::class, 'city_id', 'id');
    }

    public function cityJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'city_id', 'id');
    }
}
