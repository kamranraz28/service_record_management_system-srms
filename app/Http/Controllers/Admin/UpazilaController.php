<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUpazilaRequest;
use App\Http\Requests\StoreUpazilaRequest;
use App\Http\Requests\UpdateUpazilaRequest;
use App\Models\District;
use App\Models\Upazila;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UpazilaController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('upazila_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Upazila::with(['district'])->select(sprintf('%s.*', (new Upazila)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'upazila_show';
                $editGate      = 'upazila_edit';
                $deleteGate    = 'upazila_delete';
                $crudRoutePart = 'upazilas';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('district_name_bn', function ($row) {
                return $row->district ? $row->district->name_bn : '';
            });

            $table->editColumn('name_bn', function ($row) {
                return $row->name_bn ? $row->name_bn : '';
            });
            $table->editColumn('name_en', function ($row) {
                return $row->name_en ? $row->name_en : '';
            });
            $table->editColumn('grocode', function ($row) {
                return $row->grocode ? $row->grocode : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'district']);

            return $table->make(true);
        }

        return view('admin.upazilas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('upazila_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $districts = District::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.upazilas.create', compact('districts'));
    }

    public function store(StoreUpazilaRequest $request)
    {
        $upazila = Upazila::create($request->all());

        return redirect()->route('admin.upazilas.index');
    }

    public function edit(Upazila $upazila)
    {
        abort_if(Gate::denies('upazila_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $districts = District::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $upazila->load('district');

        return view('admin.upazilas.edit', compact('districts', 'upazila'));
    }

    public function update(UpdateUpazilaRequest $request, Upazila $upazila)
    {
        $upazila->update($request->all());

        return redirect()->route('admin.upazilas.index');
    }

    public function show(Upazila $upazila)
    {
        abort_if(Gate::denies('upazila_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upazila->load('district');

        return view('admin.upazilas.show', compact('upazila'));
    }

    public function destroy(Upazila $upazila)
    {
        abort_if(Gate::denies('upazila_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upazila->delete();

        return back();
    }

    public function massDestroy(MassDestroyUpazilaRequest $request)
    {
        $upazilas = Upazila::find(request('ids'));

        foreach ($upazilas as $upazila) {
            $upazila->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
