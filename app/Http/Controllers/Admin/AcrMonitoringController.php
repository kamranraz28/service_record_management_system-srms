<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAcrMonitoringRequest;
use App\Http\Requests\StoreAcrMonitoringRequest;
use App\Http\Requests\UpdateAcrMonitoringRequest;
use App\Models\AcrMonitoring;
use App\Models\Editlog;
use App\Models\EmployeeList;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AcrMonitoringController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('acr_monitoring_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$userId = Auth::id();
		//dd($userId);

		$userInfo = User::select('forest_circle_id', 'forest_division_id')
					->where('id', $userId)
					->first();
		$divisions= $userInfo->forest_division_id;
		// dd($divisions);
		$circles= $userInfo->forest_circle_id;
		//dd($circles);
        if ($request->ajax()) {

			if ($circles !== null && $divisions == null) {

				$sameOfficeIds = User::select('id')
					->where('forest_circle_id', $circles)
					->pluck('id');

				$query = AcrMonitoring::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new AcrMonitoring)->table));

			}elseif ($circles == null && $divisions !== null) {

				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');

				$query = AcrMonitoring::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new AcrMonitoring)->table));

			}else{
				$query = AcrMonitoring::with(['employee'])
				->select(sprintf('%s.*', (new AcrMonitoring)->table));
			}

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'acr_monitoring_show';
                $editGate      = 'acr_monitoring_edit';
                $deleteGate    = 'acr_monitoring_delete';
                $crudRoutePart = 'acr-monitorings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? $row->employee->employeeid : '';
            });

            $table->addColumn('employee_fullname_en', function ($row) {
                return $row->employee ? $row->employee->fullname_en : '';
            });

            $table->editColumn('year', function ($row) {
                return $row->year ? $row->year : '';
            });
            $table->editColumn('reviewer', function ($row) {
                return $row->reviewer ? $row->reviewer : '';
            });
            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.acrMonitorings.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('acr_monitoring_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.acrMonitorings.create', compact('employees','employee'));
    }

    public function store(StoreAcrMonitoringRequest $request)
    {
        $acrMonitoring = AcrMonitoring::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $acrMonitoring->id]);
        }
        return redirect()->back()->with('status', __('global.saveactions'));
      //  return redirect()->route('admin.acr-monitorings.index');
    }

    public function edit(AcrMonitoring $acrMonitoring)
    {
        abort_if(Gate::denies('acr_monitoring_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $acrMonitoring->load('employee');

        return view('admin.acrMonitorings.edit', compact('acrMonitoring', 'employees'));
    }

    // public function update(UpdateAcrMonitoringRequest $request, AcrMonitoring $acrMonitoring)
    // {
    //     $acrMonitoring->update($request->all());

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    //Single Upload

    public function update(Request $request)
    {

        $fieldLabels = [
            'year' => 'সাল',
            'remarks' => 'মন্তব্য',
            'fromdate' => 'তারিখ হতে',
            'todate' => 'তারিখ পর্যন্ত',
            'issubmitted' => 'জমা দেওয়া হয়েছে?',
        ];
        $acrMonitoring = AcrMonitoring::findOrFail($request->id);

        $acrMonitoring->fill($request->all());

        // Check for changed attributes
        foreach ($acrMonitoring->getDirty() as $field => $newValue) {
            $content = $newValue;

            // If the changed field is 'type', map value to Bangla label
        if ($field === 'type') {
            switch ($newValue) {
                case 1:
                    $content = 'হ্যাঁ';
                    break;
                case 2:
                    $content = 'না';
                    break;
                default:
                    $content = $newValue;
            }
        }


            // Log field change
            Editlog::create([
                'type' => 1,
                'form' => 18,
                'data_id' => $acrMonitoring->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $content,
                'edit_by' => auth()->id(),
                'employee_id' => $acrMonitoring->employee->id,
            ]);
        }

        return redirect()->back()->with('status', __('global.updateAction'));
    }



    public function show(AcrMonitoring $acrMonitoring)
    {
        abort_if(Gate::denies('acr_monitoring_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acrMonitoring->load('employee');

        return view('admin.acrMonitorings.show', compact('acrMonitoring'));
    }

    public function destroy(AcrMonitoring $acrMonitoring)
    {
        abort_if(Gate::denies('acr_monitoring_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $acrMonitoring->delete();

        return back();
    }

    public function massDestroy(MassDestroyAcrMonitoringRequest $request)
    {
        $acrMonitorings = AcrMonitoring::find(request('ids'));

        foreach ($acrMonitorings as $acrMonitoring) {
            $acrMonitoring->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('acr_monitoring_create') && Gate::denies('acr_monitoring_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AcrMonitoring();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
