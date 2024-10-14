<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExtracurriculamRequest;
use App\Http\Requests\StoreExtracurriculamRequest;
use App\Http\Requests\UpdateExtracurriculamRequest;
use App\Models\EmployeeList;
use App\Models\Extracurriculam;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ExtracurriculamController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('extracurriculam_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
					
				$query = Extracurriculam::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new Extracurriculam)->table));

			}elseif ($circles == null && $divisions !== null) {
				
				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');
					
				$query = Extracurriculam::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new Extracurriculam)->table));

			}else{
				$query = Extracurriculam::with(['employee'])
				->select(sprintf('%s.*', (new Extracurriculam)->table));
			}
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'extracurriculam_show';
                $editGate      = 'extracurriculam_edit';
                $deleteGate    = 'extracurriculam_delete';
                $crudRoutePart = 'extracurriculams';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? englishToBanglaNumber($row->employee->employeeid) : '';
            });
            $table->addColumn('name', function ($row) {
                return $row->employee ? $row->employee->fullname_bn : '';
            });

            $table->editColumn('activity_name', function ($row) {
                return $row->activity_name ? $row->activity_name : '';
            });
			$table->editColumn('start_date', function ($row) {
                return $row->start_date ? englishToBanglaNumber($row->start_date) : '';
            });
			$table->editColumn('end_date', function ($row) {
                return $row->end_date ? englishToBanglaNumber($row->end_date) : '';
            });
            $table->editColumn('organization', function ($row) {
                return $row->organization ? $row->organization : '';
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : '';
            });

            $table->editColumn('attatchment', function ($row) {
                return $row->attatchment ? '<a href="' . $row->attatchment->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'attatchment']);

            return $table->make(true);
        }

        return view('admin.extracurriculams.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('extracurriculam_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.extracurriculams.create', compact('employees','employee'));
    }

    public function store(StoreExtracurriculamRequest $request)
    {
        $extracurriculam = Extracurriculam::create($request->all());

        if ($request->input('attatchment', false)) {
            $extracurriculam->addMedia(storage_path('tmp/uploads/' . basename($request->input('attatchment'))))->toMediaCollection('attatchment');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $extracurriculam->id]);
        }
         return redirect()->back()->with('status', __('global.saveactions'));
        //return redirect()->route('admin.extracurriculams.index');
    }

    public function edit(Extracurriculam $extracurriculam)
    {
        abort_if(Gate::denies('extracurriculam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $extracurriculam->load('employee');

        return view('admin.extracurriculams.edit', compact('employees', 'extracurriculam'));
    }

    public function update(UpdateExtracurriculamRequest $request, Extracurriculam $extracurriculam)
    {
        $extracurriculam->update($request->all());

        if ($request->input('attatchment', false)) {
            if (! $extracurriculam->attatchment || $request->input('attatchment') !== $extracurriculam->attatchment->file_name) {
                if ($extracurriculam->attatchment) {
                    $extracurriculam->attatchment->delete();
                }
                $extracurriculam->addMedia(storage_path('tmp/uploads/' . basename($request->input('attatchment'))))->toMediaCollection('attatchment');
            }
        } elseif ($extracurriculam->attatchment) {
            $extracurriculam->attatchment->delete();
        }

        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(Extracurriculam $extracurriculam)
    {
        abort_if(Gate::denies('extracurriculam_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extracurriculam->load('employee');

        return view('admin.extracurriculams.show', compact('extracurriculam'));
    }

    public function destroy(Extracurriculam $extracurriculam)
    {
        abort_if(Gate::denies('extracurriculam_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extracurriculam->delete();

        return back();
    }

    public function massDestroy(MassDestroyExtracurriculamRequest $request)
    {
        $extracurriculams = Extracurriculam::find(request('ids'));

        foreach ($extracurriculams as $extracurriculam) {
            $extracurriculam->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('extracurriculam_create') && Gate::denies('extracurriculam_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Extracurriculam();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
