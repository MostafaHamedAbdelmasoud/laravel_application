<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class NewsSubCategory extends Model
{
    use SoftDeletes;

    public $table = 'news_sub_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'name',
        'news_category_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function news_category()
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
