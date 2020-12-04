<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class CustomField extends Model
{
    use Filterable;

    /**
     * @var string
     */
    public $table = 'custom_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'type',
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
        return 'custom_field_id';
    }
}
