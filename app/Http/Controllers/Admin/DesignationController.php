<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDesignationRequest;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Designation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Designation::query()->select(sprintf('%s.*', (new Designation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'designation_show';
                $editGate      = 'designation_edit';
                $deleteGate    = 'designation_delete';
                $crudRoutePart = 'designations';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('name_bn', function ($row) {
                return $row->name_bn ? $row->name_bn : '';
            });
            $table->editColumn('name_en', function ($row) {
                return $row->name_en ? $row->name_en : '';
            });
            $table->editColumn('value', function ($row) {
                return $row->value ? $row->value : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.designations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designations.create');
    }

    public function store(StoreDesignationRequest $request)
    {
        $designation = Designation::create($request->all());

        return redirect()->route('admin.designations.index');
    }

    public function edit(Designation $designation)
    {
        abort_if(Gate::denies('designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designations.edit', compact('designation'));
    }

    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $designation->update($request->all());

        return redirect()->route('admin.designations.index');
    }

    public function show(Designation $designation)
    {
        abort_if(Gate::denies('designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designations.show', compact('designation'));
    }

    public function destroy(Designation $designation)
    {
        abort_if(Gate::denies('designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationRequest $request)
    {
        $designations = Designation::find(request('ids'));

        foreach ($designations as $designation) {
            $designation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function parseCsvImport(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
			$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
			$data = array_map('str_getcsv', file($path));
			$csv_data = array_slice($data, 1, count($row_index));

			foreach ($csv_data as $key => $value) {
                $bname = $value[0];
				$ename = $value[1];
 
                $data['name_bn']= $bname;
                $data['name_en']= $ename;
                
                Designation::create($data);

            }
    }
}
