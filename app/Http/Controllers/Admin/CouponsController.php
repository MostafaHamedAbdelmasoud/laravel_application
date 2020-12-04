<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCouponRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CouponsController extends Controller
{
    protected $repo;

    public function __construct(CouponRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        //abort_if(Gate::denies('coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Coupon::query()->select(sprintf('%s.*', (new Coupon)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'coupon_show';
                $editGate      = 'coupon_edit';
                $deleteGate    = 'coupon_delete';
                $crudRoutePart = 'coupons';

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
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : "";
            });
            $table->editColumn('fixed_discount', function ($row) {
                return $row->fixed_discount ? $row->fixed_discount : '';
            });
            $table->editColumn('percentage_discount', function ($row) {
                return $row->percentage_discount ? $row->percentage_discount : '';
            });

            $table->editColumn('max_usage_per_user', function ($row) {
                return $row->max_usage_per_user ? $row->max_usage_per_user : '';
            });

            $table->editColumn('min_total', function ($row) {
                return $row->min_total ? $row->min_total : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.coupons.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('coupon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        $this->repo->create($request->all());

        return redirect()->route('admin.coupons.index');
    }

    public function edit(Coupon $coupon)
    {
        //abort_if(Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->repo->update($coupon, $request->all());

        return redirect()->route('admin.coupons.index');
    }

    public function show(Coupon $coupon)
    {
        //abort_if(Gate::denies('coupon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Coupon::find($coupon)->first();

        return view('admin.coupons.show', compact('coupon'));
    }

    public function destroy(Coupon $coupon)
    {
        //abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupon->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponRequest $request)
    {
        Coupon::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
