<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCityRequest;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Repositories\CityRepository;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CitiesController extends Controller
{
    /**
     * @var CityRepository
     */
    private $repository;

    public function __construct(CityRepository $repository)
    {

        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        //abort_if(Gate::denies('city_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = City::query()->select(sprintf('%s.*', (new City)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'city_show';
                $editGate = 'city_edit';
                $deleteGate = 'city_delete';
                $crudRoutePart = 'cities';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.cities.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('city_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cities.create');
    }

    public function store(StoreCityRequest $request)
    {
        $city = City::create($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function edit(City $city)
    {
        //abort_if(Gate::denies('city_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cities.edit', compact('city'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function show(City $city)
    {
        //abort_if(Gate::denies('city_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city->load('cityDepartments', 'cityNews', 'cityJobOffers');

        return view('admin.cities.show', compact('city'));
    }

    public function destroy(City $city)
    {
        //abort_if(Gate::denies('city_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($this->repository->checkForExistenceInOtherModel($city)) {
            return back()->withErrors('
                لا نستطيع حذف هذه المدينة،
                لإنها مُرتبطه بقسم بالفعل!
                ' . $city->name);
        }
        $city->delete();

        return back();
    }

    public function massDestroy(MassDestroyCityRequest $request)
    {
        $cities = City::whereIn('id', request('ids'));
        foreach ($cities->get() as $city) {
            if ($this->repository->checkForExistenceInOtherModel($city)) {
                return back()->withErrors($city->name . '
                لا نستطيع حذف هذه المدينة،
                لإنها مُرتبطه بقسم بالفعل!
                ');
            }
        }

        $cities->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
