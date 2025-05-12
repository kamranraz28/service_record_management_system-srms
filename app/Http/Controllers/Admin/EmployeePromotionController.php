<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeePromotionRequest;
use App\Http\Requests\StoreEmployeePromotionRequest;
use App\Http\Requests\UpdateEmployeePromotionRequest;
use App\Models\Designation;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\EmployeePromotion;
use App\Models\Grade;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EmployeePromotionController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('employee_promotion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

				$query = EmployeePromotion::with(['employee', 'new_designation'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new EmployeePromotion)->table));

			}elseif ($circles == null && $divisions !== null) {

				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');

				$query = EmployeePromotion::with(['employee', 'new_designation'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new EmployeePromotion)->table));

			}else{
				$query = EmployeePromotion::with(['employee', 'new_designation'])
				->select(sprintf('%s.*', (new EmployeePromotion)->table));
			}

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_promotion_show';
                $editGate = 'employee_promotion_edit';
                $deleteGate = 'employee_promotion_delete';
                $crudRoutePart = 'employee-promotions';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                )
                );
            });

            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? englishToBanglaNumber($row->employee->employeeid) : '';
            });

            $table->addColumn('name', function ($row) {
                return $row->employee ? $row->employee->fullname_bn : '';
            });

            $table->addColumn('new_designation_name_bn', function ($row) {
                return $row->new_designation ? $row->new_designation->name_bn : '';
            });

			$table->addColumn('grade_bn', function ($row) {
                return $row->grade ? $row->grade->name_bn : '';
            });

			$table->editColumn('memo_date', function ($row) {
                return $row->go_issue_date ? englishToBanglaNumber($row->go_issue_date) : '';
            });

			$table->editColumn('memo_number', function ($row) {
                return $row->office_order_date ? $row->go_issue_date : '';
            });

            $table->editColumn('office_order', function ($row) {
                return $row->office_order ? '<a href="' . $row->office_order->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'new_designation', 'office_order']);

            return $table->make(true);
        }

        return view('admin.employeePromotions.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('employee_promotion_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

		$grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');


        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $new_designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeePromotions.create', compact('grades','employees', 'new_designations', 'employee'));
    }

    public function store(StoreEmployeePromotionRequest $request)
    {
        $employeePromotion = EmployeePromotion::create($request->all());

        if ($request->input('office_order', false)) {
            $employeePromotion->addMedia(storage_path('tmp/uploads/' . basename($request->input('office_order'))))->toMediaCollection('office_order');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employeePromotion->id]);
        }
        return redirect()->back()->with('status', __('global.saveactions'));
        // return redirect()->route('admin.employee-promotions.index');
    }

    public function edit(EmployeePromotion $employeePromotion)
    {
        abort_if(Gate::denies('employee_promotion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
                $locale = App::getLocale();

		$columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $new_designations = Designation::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeePromotion->load('employee', 'new_designation');
        $grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('admin.employeePromotions.edit', compact('grades','employeePromotion', 'employees', 'new_designations'));
    }

    // public function update(UpdateEmployeePromotionRequest $request, EmployeePromotion $employeePromotion)
    // {
    //     $employeePromotion->update($request->all());

    //     if ($request->input('office_order', false)) {
    //         if (!$employeePromotion->office_order || $request->input('office_order') !== $employeePromotion->office_order->file_name) {
    //             if ($employeePromotion->office_order) {
    //                 $employeePromotion->office_order->delete();
    //             }
    //             $employeePromotion->addMedia(storage_path('tmp/uploads/' . basename($request->input('office_order'))))->toMediaCollection('office_order');
    //         }
    //     } elseif ($employeePromotion->office_order) {
    //         $employeePromotion->office_order->delete();
    //     }

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }


    public function update(Request $request)
    {

        $fieldLabels = [
            'new_designation_id' => 'পদবি',
            'grade_id' => 'গ্রেড',
            'office_order_date' => 'অফিস আদেশ/প্রজ্ঞাপন/স্মারক তারিখ',
            'go_issue_date' => 'অফিস আদেশ/প্রজ্ঞাপন/স্মারক নাম্বার',
            'office_order' => 'অফিস আদেশ/প্রজ্ঞাপন/স্মারক সংযোজন',
        ];
        $employeePromotion = EmployeePromotion::findOrFail($request->id);

        // Exclude 'office_order' from fill since it's handled manually
        $employeePromotion->fill($request->except('office_order'));

        // Check for changed attributes
        foreach ($employeePromotion->getDirty() as $field => $newValue) {
            $dropdownFields = ['new_designation_id','grade_id'];
            $type = in_array($field, $dropdownFields) ? 2 : 1;

            // Log field change
            Editlog::create([
                'type' => $type,
                'form' => 9,
                'data_id' => $employeePromotion->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $newValue,
                'edit_by' => auth()->id(),
                'employee_id' => $employeePromotion->employee->id,
            ]);
        }

        // Handle 'office_order' file logic manually (not via isDirty())
        if ($request->has('office_order')) {
            $filename = basename($request->input('office_order'));
            $tmpPath = storage_path('tmp/uploads/' . $filename);

            if (file_exists($tmpPath)) {
                // Store the new file without deleting old
                $employeePromotion
                    ->addMedia($tmpPath)
                    ->toMediaCollection('office_order');

                // Log upload
                Editlog::create([
                    'type' => 3,
                    'form' => 9,
                    'data_id' => $employeePromotion->id,
                    'field' => 'office_order',
                    'level' => $fieldLabels['office_order'] ?? 'office_order',
                    'content' => $filename,
                    'edit_by' => auth()->id(),
                    'employee_id' => $employeePromotion->employee->id,
                ]);
            }
        } else {
            // No file in request, assume clearing office_order
            $employeePromotion->clearMediaCollection('office_order');

            Editlog::create([
                'type' => 3,
                'form' => 9,
                'data_id' => $employeePromotion->id,
                'field' => 'office_order',
                'level' => $fieldLabels['office_order'] ?? 'office_order',
                'content' => '',
                'edit_by' => auth()->id(),
                'employee_id' => $employeePromotion->employee->id,
            ]);
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }


    public function show(EmployeePromotion $employeePromotion)
    {
        abort_if(Gate::denies('employee_promotion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeePromotion->load('employee', 'new_designation');

        return view('admin.employeePromotions.show', compact('employeePromotion'));
    }

    public function destroy(EmployeePromotion $employeePromotion)
    {
        abort_if(Gate::denies('employee_promotion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeePromotion->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeePromotionRequest $request)
    {
        $employeePromotions = EmployeePromotion::find(request('ids'));

        foreach ($employeePromotions as $employeePromotion) {
            $employeePromotion->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_promotion_create') && Gate::denies('employee_promotion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new EmployeePromotion();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
