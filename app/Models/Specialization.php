<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Specialization extends Model
{
    use SoftDeletes;

    public $table = 'specializations';

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

    public function specializationJobs()
    {
        return $this->hasMany(Job::class, 'specialization_id', 'id');
    }

    public function specializationJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'specialization_id', 'id');
    }
}
