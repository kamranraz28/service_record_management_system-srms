<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLeaveRecordRequest;
use App\Http\Requests\StoreLeaveRecordRequest;
use App\Http\Requests\UpdateLeaveRecordRequest;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\LeaveCategory;
use App\Models\LeaveRecord;
use App\Models\LeaveType;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LeaveRecordController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('leave_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

				$query = LeaveRecord::with(['employee', 'type_of_leave', 'leave_category'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new LeaveRecord)->table));

			}elseif ($circles == null && $divisions !== null) {

				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');

				$query = LeaveRecord::with(['employee', 'type_of_leave', 'leave_category'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new LeaveRecord)->table));

			}else{
				$query = LeaveRecord::with(['employee', 'type_of_leave', 'leave_category'])
				->select(sprintf('%s.*', (new LeaveRecord)->table));
			}

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'leave_record_show';
                $editGate      = 'leave_record_edit';
                $deleteGate    = 'leave_record_delete';
                $crudRoutePart = 'leave-records';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? englishToBanglaNumber($row->employee->employeeid) : '';
            });

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : '';
            });

            $table->editColumn('start_date', function ($row) {
                return $row->start_date ? englishToBanglaNumber($row->start_date) : '';
            });
			$table->editColumn('end_date', function ($row) {
                return $row->end_date ? englishToBanglaNumber($row->end_date) : '';
            });
			$table->editColumn('order_number', function ($row) {
                return $row->leave_orderumber ? englishToBanglaNumber($row->leave_orderumber) : '';
            });
			$table->editColumn('order_date', function ($row) {
                return $row->leave_order_date ? englishToBanglaNumber($row->leave_order_date) : '';
            });
			$table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : '';
            });
			$table->addColumn('type_of_leave_name_bn', function ($row) {
                return $row->type_of_leave ? $row->type_of_leave->name_bn : '';
            });

            $table->addColumn('leave_category_name_bn', function ($row) {
                return $row->leave_category ? $row->leave_category->name_bn : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'type_of_leave', 'leave_category']);

            return $table->make(true);
        }

        return view('admin.leaveRecords.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('leave_record_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $type_of_leaves = LeaveType::pluck($columname , 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_categories = LeaveCategory::pluck($columname , 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.leaveRecords.create', compact('employees', 'leave_categories', 'type_of_leaves','employee'));
    }

    public function store(StoreLeaveRecordRequest $request)
    {
        $leaveRecord = LeaveRecord::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $leaveRecord->id]);
        }

        if ($request->input('leave_order', false)) {
            if (! $leaveRecord->leave_order || $request->input('leave_order') !== $leaveRecord->leave_order->file_name) {
                if ($leaveRecord->leave_order) {
                    $leaveRecord->leave_order->delete();
                }
                $leaveRecord->addMedia(storage_path('tmp/uploads/' . basename($request->input('leave_order'))))->toMediaCollection('leave_order');
            }
        } elseif ($leaveRecord->leave_order) {
            $leaveRecord->leave_order->delete();
        }

         return redirect()->back()->with('status', __('global.saveactions'));
       // return redirect()->route('admin.leave-records.index');
    }

    public function edit(LeaveRecord $leaveRecord)
    {
        abort_if(Gate::denies('leave_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $type_of_leaves = LeaveType::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leave_categories = LeaveCategory::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaveRecord->load('employee', 'type_of_leave', 'leave_category');

        return view('admin.leaveRecords.edit', compact('employees', 'leaveRecord', 'leave_categories', 'type_of_leaves'));
    }

    // public function update(UpdateLeaveRecordRequest $request, LeaveRecord $leaveRecord)
    // {
    //     $leaveRecord->update($request->all());

    //     if ($request->input('leave_order', false)) {
    //         if (! $leaveRecord->leave_order || $request->input('leave_order') !== $leaveRecord->leave_order->file_name) {
    //             if ($leaveRecord->leave_order) {
    //                 $leaveRecord->leave_order->delete();
    //             }
    //             $leaveRecord->addMedia(storage_path('tmp/uploads/' . basename($request->input('leave_order'))))->toMediaCollection('leave_order');
    //         }
    //     } elseif ($leaveRecord->leave_order) {
    //         $leaveRecord->leave_order->delete();
    //     }

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    public function update(Request $request)
    {

        $fieldLabels = [
            'leave_category_id' => 'ছুটির শ্রেণী',
            'type_of_leave_id' => 'ছুটির ধরণ',
            'start_date' => 'ছুটির শুরু তারিখ',
            'end_date' => 'ছুটির শেষ তারিখ',
            'leave_orderumber' => 'ছুটির আদেশ/প্রজ্ঞাপন/স্মারক নাম্বার',
            'leave_order_date' => 'ছুটির আদেশ/প্রজ্ঞাপন/স্মারক তারিখ',
            'leave_order' => 'ছুটির আদেশ/প্রজ্ঞাপন/স্মারক সংযোজন',
            'reason' => 'কারন',
        ];
        $leaveRecord = LeaveRecord::findOrFail($request->id);

        // Exclude 'leave_order' from fill since it's handled manually
        $leaveRecord->fill($request->except('leave_order'));

        // Check for changed attributes
        foreach ($leaveRecord->getDirty() as $field => $newValue) {
            $dropdownFields = ['leave_category_id','type_of_leave_id'];
            $type = in_array($field, $dropdownFields) ? 2 : 1;

            // Log field change
            Editlog::create([
                'type' => $type,
                'form' => 10,
                'data_id' => $leaveRecord->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $newValue,
                'edit_by' => auth()->id(),
                'employee_id' => $leaveRecord->employee->id,
            ]);
        }

        // Handle 'leave_order' file logic manually (not via isDirty())
        if ($request->has('leave_order')) {
            $filename = basename($request->input('leave_order'));
            $tmpPath = storage_path('tmp/uploads/' . $filename);

            if (file_exists($tmpPath)) {
                // Store the new file without deleting old
                $leaveRecord
                    ->addMedia($tmpPath)
                    ->toMediaCollection('leave_order');

                // Log upload
                Editlog::create([
                    'type' => 3,
                    'form' => 10,
                    'data_id' => $leaveRecord->id,
                    'field' => 'leave_order',
                    'level' => $fieldLabels['leave_order'] ?? 'leave_order',
                    'content' => $filename,
                    'edit_by' => auth()->id(),
                    'employee_id' => $leaveRecord->employee->id,
                ]);
            }
        } else {
            // No file in request, assume clearing leave_order
            $leaveRecord->clearMediaCollection('leave_order');

            Editlog::create([
                'type' => 3,
                'form' => 10,
                'data_id' => $leaveRecord->id,
                'field' => 'leave_order',
                'level' => $fieldLabels['leave_order'] ?? 'leave_order',
                'content' => '',
                'edit_by' => auth()->id(),
                'employee_id' => $leaveRecord->employee->id,
            ]);
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(LeaveRecord $leaveRecord)
    {
        abort_if(Gate::denies('leave_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRecord->load('employee', 'type_of_leave', 'leave_category');

        return view('admin.leaveRecords.show', compact('leaveRecord'));
    }

    public function destroy(LeaveRecord $leaveRecord)
    {
        abort_if(Gate::denies('leave_record_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRecord->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeaveRecordRequest $request)
    {
        $leaveRecords = LeaveRecord::find(request('ids'));

        foreach ($leaveRecords as $leaveRecord) {
            $leaveRecord->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('leave_record_create') && Gate::denies('leave_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LeaveRecord();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
