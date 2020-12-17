<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class News extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Filterable;

    public $table = 'news';

    protected $appends = [
        'image',
    ];


    protected $dates = [
        'add_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'details',
        'added_by_admin',
        'price',
        'detailed_title',
        'news_category_id',
        'news_sub_category_id',
        'city_id',
        'add_date',
        'phone_number',
        'approved',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();

        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getAddDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setAddDateAttribute($value)
    {
        $this->attributes['add_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getIsApprovedAttribute()
    {
        return $this->approved ? 'نعم' : 'لا';
    }


    public function news_category()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function news_sub_category()
    {
        return $this->belongsTo(NewsSubCategory::class);
    }


    public function getPriceValueAttribute()
    {
        return $this->price?  ' جنية '. $this->price :'';
    }
}
