<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\CitySelectFilter;
use App\Http\Resources\Admin\CitySelectResource;
use App\Models\City;
use Gate;

class CitiesSelectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select_city(CitySelectFilter $filter)
    {
        $city= City::filter($filter)->paginate();

        return CitySelectResource::collection($city);
    }
}
