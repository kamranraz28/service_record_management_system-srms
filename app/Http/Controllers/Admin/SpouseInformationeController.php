<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySpouseInformationeRequest;
use App\Http\Requests\StoreSpouseInformationeRequest;
use App\Http\Requests\UpdateSpouseInformationeRequest;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\SpouseInformatione;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SpouseInformationeController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('spouse_informatione_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

                $query = SpouseInformatione::with(['employee'])
                    ->whereHas('employee', function ($query) use ($sameOfficeIds) {
                        $query->whereIn('created_by', $sameOfficeIds);
                    })
                    ->select(sprintf('%s.*', (new SpouseInformatione)->table));

            } elseif ($circles == null && $divisions !== null) {

                $sameOfficeIds = User::select('id')
                    ->where('forest_division_id', $divisions)
                    ->pluck('id');

                $query = SpouseInformatione::with(['employee'])
                    ->whereHas('employee', function ($query) use ($sameOfficeIds) {
                        $query->whereIn('created_by', $sameOfficeIds);
                    })
                    ->select(sprintf('%s.*', (new SpouseInformatione)->table));

            } else {
                $query = SpouseInformatione::with(['employee'])
                    ->select(sprintf('%s.*', (new SpouseInformatione)->table));
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'spouse_informatione_show';
                $editGate = 'spouse_informatione_edit';
                $deleteGate = 'spouse_informatione_delete';
                $crudRoutePart = 'spouse-informationes';

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

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : '';
            });

            $table->editColumn('name_bn', function ($row) {
                return $row->name_bn ? $row->name_bn : '';
            });
            $table->editColumn('name_en', function ($row) {
                return $row->name_en ? $row->name_en : '';
            });
            $table->editColumn('nid_number', function ($row) {
                return $row->nid_number ? $row->nid_number : '';
            });
            $table->editColumn('nid_upload', function ($row) {
                return $row->nid_upload ? '<a href="' . $row->nid_upload->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('present_address', function ($row) {
                return $row->present_addess ? $row->present_addess : '';
            });
            $table->editColumn('permanent_address', function ($row) {
                return $row->permanent_addess ? $row->permanent_addess : '';
            });
            $table->editColumn('occupation', function ($row) {
                return $row->occupation ? $row->occupation : '';
            });
            $table->editColumn('office_address', function ($row) {
                return $row->office_address ? $row->office_address : '';
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'nid_upload']);

            return $table->make(true);
        }

        return view('admin.spouseInformationes.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('spouse_informatione_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.spouseInformationes.create', compact('employees', 'employee'));
    }

    public function store(StoreSpouseInformationeRequest $request)
    {
        //dd($request->all());
        $spouseInformatione = SpouseInformatione::create($request->all());

        if ($request->input('nid_upload', false)) {
            $spouseInformatione->addMedia(storage_path('tmp/uploads/' . basename($request->input('nid_upload'))))->toMediaCollection('nid_upload');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $spouseInformatione->id]);
        }

        return redirect()->back()->with('status', __('global.saveactions'));
    }

    public function edit(SpouseInformatione $spouseInformatione)
    {
        abort_if(Gate::denies('spouse_informatione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $spouseInformatione->load('employee');

        return view('admin.spouseInformationes.edit', compact('employees', 'spouseInformatione'));
    }

    // public function update(UpdateSpouseInformationeRequest $request, SpouseInformatione $spouseInformatione)
    // {
    //     $spouseInformatione->update($request->all());

    //     if ($request->input('nid_upload', false)) {
    //         if (! $spouseInformatione->nid_upload || $request->input('nid_upload') !== $spouseInformatione->nid_upload->file_name) {
    //             if ($spouseInformatione->nid_upload) {
    //                 $spouseInformatione->nid_upload->delete();
    //             }
    //             $spouseInformatione->addMedia(storage_path('tmp/uploads/' . basename($request->input('nid_upload'))))->toMediaCollection('nid_upload');
    //         }
    //     } elseif ($spouseInformatione->nid_upload) {
    //         $spouseInformatione->nid_upload->delete();
    //     }

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    // public function update(Request $request)
    // {

    //     $fieldLabels = [
    //         'name_bn' => 'নাম (বাংলা)',
    //         'name_en' => 'নাম (ইংরেজি)',
    //         'nid_number' => 'এনআইডি নম্বর',
    //         'nid_upload' => 'এনআইডি সংযোজন',
    //         'phone_number' => 'শিক্ষা-প্রতিষ্ঠানের নাম',
    //         'present_addess' => 'বর্তমান ঠিকানা',
    //         'permanent_addess' => 'স্থায়ী ঠিকানা',
    //         'occupation' => 'পেশা',
    //     ];
    //     $spouseInformatione = SpouseInformatione::findOrFail($request->id);

    //     // Exclude 'nid_upload' from fill since it's handled manually
    //     $spouseInformatione->fill($request->except('nid_upload'));

    //     // Check for changed attributes
    //     foreach ($spouseInformatione->getDirty() as $field => $newValue) {
    //         $dropdownFields = [];
    //         $uploadFileds = ['nid_upload'];
    //         $type = in_array($field, $dropdownFields) ? 2 : 1;

    //         // Log field change
    //         Editlog::create([
    //             'type' => $type,
    //             'form' => 6,
    //             'data_id' => $spouseInformatione->id,
    //             'field' => $field,
    //             'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
    //             'content' => $newValue,
    //             'edit_by' => auth()->id(),
    //             'employee_id' => $spouseInformatione->employee->id,
    //         ]);
    //     }

    //     // Handle file upload
    //     if ($request->input('nid_upload', false)) {
    //         if (! $spouseInformatione->nid_upload || $request->input('nid_upload') !== $spouseInformatione->nid_upload->file_name) {
    //             if ($spouseInformatione->nid_upload) {
    //                 $spouseInformatione->nid_upload->delete();
    //             }
    //             $spouseInformatione->addMedia(storage_path('tmp/uploads/' . basename($request->input('nid_upload'))))->toMediaCollection('nid_upload');
    //         }
    //     } elseif ($spouseInformatione->nid_upload) {
    //         $spouseInformatione->nid_upload->delete();
    //     }

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    public function update(Request $request)
    {

        $fieldLabels = [
            'name_bn' => 'নাম (বাংলা)',
            'name_en' => 'নাম (ইংরেজি)',
            'nid_number' => 'এনআইডি নম্বর',
            'nid_upload' => 'এনআইডি সংযোজন',
            'phone_number' => 'শিক্ষা-প্রতিষ্ঠানের নাম',
            'present_addess' => 'বর্তমান ঠিকানা',
            'permanent_addess' => 'স্থায়ী ঠিকানা',
            'occupation' => 'পেশা',
        ];
        $spouseInformatione = SpouseInformatione::findOrFail($request->id);

        // Exclude 'nid_upload' from fill since it's handled manually
        $spouseInformatione->fill($request->except('nid_upload'));

        // Check for changed attributes
        foreach ($spouseInformatione->getDirty() as $field => $newValue) {
            $dropdownFields = [];
            $type = in_array($field, $dropdownFields) ? 2 : 1;

            // Log field change
            Editlog::create([
                'type' => $type,
                'form' => 6,
                'data_id' => $spouseInformatione->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $newValue,
                'edit_by' => auth()->id(),
                'employee_id' => $spouseInformatione->employee->id,
            ]);
        }

        // Handle 'nid_upload' file logic manually (not via isDirty())
        if ($request->has('nid_upload')) {
            $filename = basename($request->input('nid_upload'));
            $tmpPath = storage_path('tmp/uploads/' . $filename);

            if (file_exists($tmpPath)) {
                // Store the new file without deleting old
                $spouseInformatione
                    ->addMedia($tmpPath)
                    ->toMediaCollection('nid_upload');

                // Log upload
                Editlog::create([
                    'type' => 3,
                    'form' => 6,
                    'data_id' => $spouseInformatione->id,
                    'field' => 'nid_upload',
                    'level' => $fieldLabels['nid_upload'] ?? 'nid_upload',
                    'content' => $filename,
                    'edit_by' => auth()->id(),
                    'employee_id' => $spouseInformatione->employee->id,
                ]);
            }
        } else {
            // No file in request, assume clearing nid_upload
            $spouseInformatione->clearMediaCollection('nid_upload');

            Editlog::create([
                'type' => 3,
                'form' => 6,
                'data_id' => $spouseInformatione->id,
                'field' => 'nid_upload',
                'level' => $fieldLabels['nid_upload'] ?? 'nid_upload',
                'content' => 'null',
                'edit_by' => auth()->id(),
                'employee_id' => $spouseInformatione->employee->id,
            ]);
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(SpouseInformatione $spouseInformatione)
    {
        abort_if(Gate::denies('spouse_informatione_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $spouseInformatione->load('employee');

        return view('admin.spouseInformationes.show', compact('spouseInformatione'));
    }

    public function destroy(SpouseInformatione $spouseInformatione)
    {
        abort_if(Gate::denies('spouse_informatione_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $spouseInformatione->delete();

        return back();
    }

    public function massDestroy(MassDestroySpouseInformationeRequest $request)
    {
        $spouseInformationes = SpouseInformatione::find(request('ids'));

        foreach ($spouseInformationes as $spouseInformatione) {
            $spouseInformatione->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('spouse_informatione_create') && Gate::denies('spouse_informatione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new SpouseInformatione();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
