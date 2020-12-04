<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class CustomFieldOption extends Model
{
    use Filterable;

    /**
     * @var string
     */
    public $table = 'custom_field_options';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'product',
        'customField',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'product_id',
        'custom_field_id',
        'additional_price',
        'value',
    ];

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }

    /**
     * it defines foreign key in relations.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'custom_field_option_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getCustomFieldTypeAttribute()
    {
        return $this->customField?$this->customField->type:'لا يوجد ';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getProductNameAttribute()
    {
        return $this->product?$this->product->name:'لا يوجد ';
    }
}
