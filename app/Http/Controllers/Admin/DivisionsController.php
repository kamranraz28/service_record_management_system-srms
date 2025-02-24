<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDivisionRequest;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Models\Country;
use App\Models\Division;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DivisionsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('division_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Division::with(['country'])->select(sprintf('%s.*', (new Division)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'division_show';
                $editGate      = 'division_edit';
                $deleteGate    = 'division_delete';
                $crudRoutePart = 'divisions';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('country_name_bn', function ($row) {
                return $row->country ? $row->country->name_bn : '';
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

            $table->rawColumns(['actions', 'placeholder', 'country']);

            return $table->make(true);
        }

        return view('admin.divisions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('division_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.divisions.create', compact('countries'));
    }

    public function store(StoreDivisionRequest $request)
    {
        $division = Division::create($request->all());

        return redirect()->route('admin.divisions.index');
    }

    public function edit(Division $division)
    {
        abort_if(Gate::denies('division_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $division->load('country');

        return view('admin.divisions.edit', compact('countries', 'division'));
    }

    public function update(UpdateDivisionRequest $request, Division $division)
    {
        $division->update($request->all());

        return redirect()->route('admin.divisions.index');
    }

    public function show(Division $division)
    {
        abort_if(Gate::denies('division_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $division->load('country');

        return view('admin.divisions.show', compact('division'));
    }

    public function destroy(Division $division)
    {
        abort_if(Gate::denies('division_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $division->delete();

        return back();
    }

    public function massDestroy(MassDestroyDivisionRequest $request)
    {
        $divisions = Division::find(request('ids'));

        foreach ($divisions as $division) {
            $division->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
