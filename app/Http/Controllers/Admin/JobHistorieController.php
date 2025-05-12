<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJobHistoryRequest;
use App\Http\Requests\StoreJobHistoryRequest;
use App\Http\Requests\UpdateJobHistoryRequest;
use App\Models\Designation;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\ForestBeat;
use App\Models\ForestDivision;
use App\Models\ForestRange;
use App\Models\ForestState;
use App\Models\Grade;
use App\Models\JobHistory;
use App\Models\JobType;
use App\Models\OfficeUnit;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class JobHistorieController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('job_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userId = Auth::id();
        //dd($userId);

        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();
        $divisions = $userInfo->forest_division_id;
        // dd($divisions);
        $circles = $userInfo->forest_circle_id;
        //dd($circles);

        if ($request->ajax()) {

            if ($circles !== null && $divisions == null) {

                $sameOfficeIds = User::select('id')
                    ->where('forest_circle_id', $circles)
                    ->pluck('id');

                $query = JobHistory::with(['designation', 'employee', 'grade', 'circle_list', 'division_list', 'range_list', 'beat_list', 'office_unit'])
                    ->whereHas('employee', function ($query) use ($sameOfficeIds) {
                        $query->whereIn('created_by', $sameOfficeIds);
                    })
                    ->select(sprintf('%s.*', (new JobHistory)->table));

            } elseif ($circles == null && $divisions !== null) {

                $sameOfficeIds = User::select('id')
                    ->where('forest_division_id', $divisions)
                    ->pluck('id');

                $query = JobHistory::with(['designation', 'employee', 'grade', 'circle_list', 'division_list', 'range_list', 'beat_list', 'office_unit'])
                    ->whereHas('employee', function ($query) use ($sameOfficeIds) {
                        $query->whereIn('created_by', $sameOfficeIds);
                    })
                    ->select(sprintf('%s.*', (new JobHistory)->table));

            } else {
                $query = JobHistory::with(['designation', 'employee', 'grade', 'circle_list', 'division_list', 'range_list', 'beat_list', 'office_unit'])
                    ->select(sprintf('%s.*', (new JobHistory)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'job_history_show';
                $editGate = 'job_history_edit';
                $deleteGate = 'job_history_delete';
                $crudRoutePart = 'job-histories';

                return view(
                    'partials.datatablesActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            $table->addColumn('designation_name_bn', function ($row) {
                $locale = App::getLocale();
                $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
                return $row->designation ? $row->designation->{$columname} : 'N/A';
            });

            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? englishToBanglaNumber($row->employee->employeeid) : 'N/A';
            });

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : '';
            });

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : 'N/A';
            });
            $table->addColumn('grade_name_bn', function ($row) {
                return $row->grade ? $row->grade->name_bn : 'N/A';
            });
            $table->addColumn('office_unit', function ($row) {
                return $row->office_unit ? $row->office_unit->name_bn : 'N/A';
            });
            $table->editColumn('level_2', function ($row) {
                return $row->level_2 ? $row->level_2 : 'N/A';
            });
            $table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : 'N/A';
            });
            $table->editColumn('joining_date', function ($row) {
                return $row->joining_date ? englishToBanglaNumber($row->joining_date) : 'N/A';
            });
            $table->editColumn('release_date', function ($row) {
                return $row->release_date ? englishToBanglaNumber($row->release_date) : 'N/A';
            });
            $table->addColumn('forest_circle', function ($row) {
                return $row->circle_list ? $row->circle_list->name_bn : 'N/A';
            });

            $table->addColumn('forest_division', function ($row) {
                return $row->division_list ? $row->division_list->name_bn : 'N/A';
            });
            $table->addColumn('forest_range', function ($row) {
                return $row->range_list ? $row->range_list->name_bn : 'N/A';
            });
            $table->addColumn('forest_beat', function ($row) {
                return $row->beat_list ? $row->beat_list->name_bn : 'N/A';
            });
            $table->editColumn('institutename', function ($row) {
                return $row->institutename ? $row->institutename : 'N/A';
            });



            $table->rawColumns(['actions', 'placeholder', 'designation', 'employee', 'grade', 'circle_list', 'division_list']);

            return $table->make(true);
        }

        return view('admin.jobHistories.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('job_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);


        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        $designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $circle_lists = ForestState::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $division_lists = ForestDivision::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $range_lists = ForestRange::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $beat_lists = ForestBeat::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $office_units = OfficeUnit::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.jobHistories.create', compact('employee', 'beat_lists', 'circle_lists', 'designations', 'division_lists', 'employees', 'grades', 'office_units', 'range_lists'));
    }

    public function store(StoreJobHistoryRequest $request)
    {

        //dd($request->all());
        $jobHistory = JobHistory::create($request->all());

        if ($request->input('go_upload', false)) {
            $jobHistory->addMedia(storage_path('tmp/uploads/' . basename($request->input('go_upload'))))->toMediaCollection('go_upload');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $jobHistory->id]);
        }
        return redirect()->back()->with('status', __('global.saveactions'));
        //return redirect()->route('admin.job-histories.index');
    }

    public function edit(JobHistory $jobHistory)
    {
        abort_if(Gate::denies('job_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $circle_lists = ForestState::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $division_lists = ForestDivision::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $range_lists = ForestRange::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $beat_lists = ForestBeat::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $office_units = OfficeUnit::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $job_types = JobType::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $jobHistory->load('designation', 'employee', 'grade', 'circle_list', 'division_list', 'range_list', 'beat_list', 'office_unit');

        return view('admin.jobHistories.edit', compact('beat_lists', 'job_types', 'circle_lists', 'designations', 'division_lists', 'employees', 'grades', 'jobHistory', 'office_units', 'range_lists'));
    }

    // public function update(UpdateJobHistoryRequest $request, JobHistory $jobHistory)
    // {
    //     $jobHistory->update($request->all());

    //     if ($request->input('go_upload', false)) {
    //         if (!$jobHistory->go_upload || $request->input('go_upload') !== $jobHistory->go_upload->file_name) {
    //             if ($jobHistory->go_upload) {
    //                 $jobHistory->go_upload->delete();
    //             }
    //             $jobHistory->addMedia(storage_path('tmp/uploads/' . basename($request->input('go_upload'))))->toMediaCollection('go_upload');
    //         }
    //     } elseif ($jobHistory->go_upload) {
    //         $jobHistory->go_upload->delete();
    //     }
    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    //With Upload

    public function update(Request $request)
    {

        $fieldLabels = [
            'office_unit_id' => 'অফিস',
            'level_2' => 'অফিসের নাম (হেড অফিসে পোস্টিং হলে)',
            'circle_list_id' => 'সার্কেল',
            'division_list_id' => 'ডিভিশন',
            'range_list_id' => 'রেঞ্জ/এসএফএনটিসি',
            'beat_list_id' => 'বিট/এসএফপিসি',
            'designation_id' => 'পদবি',
            'joining_date' => 'যোগদানের তারিখ',
            'release_date' => 'প্রস্থানের তারিখ',
            'grade_id' => 'গ্রেড',
            'go_upload' => 'পদায়ন পত্রের কপি',
            'comment' => 'মন্তব্য',
        ];
        $jobHistory = JobHistory::findOrFail($request->id);

        // Exclude 'go_upload' from fill since it's handled manually
        $jobHistory->fill($request->except('go_upload'));

        // Check for changed attributes
        foreach ($jobHistory->getDirty() as $field => $newValue) {
            $dropdownFields = ['office_unit_id', 'circle_list_id', 'division_list_id', 'range_list_id', 'beat_list_id', 'designation_id', 'grade_id'];
            $type = in_array($field, $dropdownFields) ? 2 : 1;

            // Log field change
            Editlog::create([
                'type' => $type,
                'form' => 8,
                'data_id' => $jobHistory->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $newValue,
                'edit_by' => auth()->id(),
                'employee_id' => $jobHistory->employee->id,
            ]);
        }

        // Handle 'go_upload' file logic manually (not via isDirty())
        if ($request->has('go_upload')) {
            $filename = basename($request->input('go_upload'));
            $tmpPath = storage_path('tmp/uploads/' . $filename);

            if (file_exists($tmpPath)) {
                // Store the new file without deleting old
                $jobHistory
                    ->addMedia($tmpPath)
                    ->toMediaCollection('go_upload');

                // Log upload
                Editlog::create([
                    'type' => 3,
                    'form' => 8,
                    'data_id' => $jobHistory->id,
                    'field' => 'go_upload',
                    'level' => $fieldLabels['go_upload'] ?? 'go_upload',
                    'content' => $filename,
                    'edit_by' => auth()->id(),
                    'employee_id' => $jobHistory->employee->id,
                ]);
            }
        } else {
            // No file in request, assume clearing go_upload
            $jobHistory->clearMediaCollection('go_upload');

            Editlog::create([
                'type' => 3,
                'form' => 8,
                'data_id' => $jobHistory->id,
                'field' => 'go_upload',
                'level' => $fieldLabels['go_upload'] ?? 'go_upload',
                'content' => 'null',
                'edit_by' => auth()->id(),
                'employee_id' => $jobHistory->employee->id,
            ]);
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }


    public function show(JobHistory $jobHistory)
    {
        abort_if(Gate::denies('job_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobHistory->load('designation', 'employee', 'grade', 'circle_list', 'division_list', 'range_list', 'beat_list', 'office_unit');

        return view('admin.jobHistories.show', compact('jobHistory'));
    }

    public function destroy(JobHistory $jobHistory)
    {
        abort_if(Gate::denies('job_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobHistoryRequest $request)
    {
        $jobHistories = JobHistory::find(request('ids'));

        foreach ($jobHistories as $jobHistory) {
            $jobHistory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('job_history_create') && Gate::denies('job_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new JobHistory();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
