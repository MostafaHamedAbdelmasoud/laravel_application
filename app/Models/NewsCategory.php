<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class NewsCategory extends Model
{
    use SoftDeletes;

    public $table = 'news_categories';

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

    protected $with =[
        'NewsSubCategories'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function categoryDepartments()
    {
        return $this->hasMany(news::class, 'news_category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function NewsSubCategories()
    {
        return $this->hasMany(NewsSubCategory::class);
    }
}
