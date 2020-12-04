<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_RADIO = [
        'service'    => 'خدمي',
        'commercial' => 'تجاري',
    ];

    protected $fillable = [
        'name',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function categoryDepartments()
    {
        return $this->hasMany(Department::class, 'category_id', 'id');
    }

    public function categoryOffers()
    {
        return $this->hasMany(Offer::class, 'category_id', 'id');
    }

    public function categoryNews()
    {
        return $this->hasMany(News::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SubCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
