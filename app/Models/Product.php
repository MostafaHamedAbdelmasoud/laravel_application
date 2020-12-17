<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Filterable;

    public $table = 'products';

    protected $appends = [
        'image',
    ];


    protected $with = [
         'variants',
     ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'show_trader_name',
        'city_id',
        'department_id',
        'details',
        'detailed_title',
        'price_after_discount',
        'product_code',
        'brand',
        'show_in_trader_page',
        'show_in_main_page',
        'price',
        'trader_id',
        'main_product_type_id',
        'main_product_service_type_id',
        'sub_product_type_id',
        'sub_product_service_type_id',
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
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function showInTraderPage()
    {
        return $this->show_in_trader_page?'نعم':'لا';
    }


    public function showInMainPage()
    {
        return $this->show_in_main_page?'نعم':'لا';
    }

    public function MainProductType()
    {
        return $this->belongsTo(MainProductType::class);
    }

    public function SubProductType()
    {
        return $this->belongsTo(SubProductType::class);
    }


    public function MainProductServiceType()
    {
        return $this->belongsTo(MainProductServiceType::class);
    }

    public function SubProductServiceType()
    {
        return $this->belongsTo(SubProductServiceType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->belongsToMany(\App\Models\Variant::class);
    }
}
