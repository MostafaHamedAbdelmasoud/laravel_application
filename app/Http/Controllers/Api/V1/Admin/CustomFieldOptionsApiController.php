<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomFieldOptionRequest;
use App\Http\Requests\UpdateCustomFieldOptionRequest ;
use App\Http\Resources\Admin\CustomFieldOptionResource;
use App\Http\Resources\Admin\CustomFieldResource;
use App\Models\CustomFieldOption ;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomFieldOptionsApiController extends Controller
{
    public function index(Request $request)
    {
        return new CustomFieldOptionResource(CustomFieldOption::all());
    }

    public function store(StoreCustomFieldOptionRequest  $request)
    {
        $custom_field_option = CustomFieldOption ::create($request->all());

        return (new CustomFieldResource($custom_field_option))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomFieldOption $custom_field_option)
    {
        //abort_if(Gate::denies('custom_field_option_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomFieldResource($custom_field_option);
    }

    public function update(UpdateCustomFieldOptionRequest  $request, CustomFieldOption $custom_field_option)
    {
        $custom_field_option->update($request->all());

        return (new CustomFieldResource($custom_field_option))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomFieldOption $custom_field_option)
    {
        //abort_if(Gate::denies('custom_field_option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $custom_field_option->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
