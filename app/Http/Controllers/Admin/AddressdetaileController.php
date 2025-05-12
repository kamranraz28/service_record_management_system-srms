<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAddressdetaileRequest;
use App\Http\Requests\StoreAddressdetaileRequest;
use App\Http\Requests\UpdateAddressdetaileRequest;
use App\Models\Addressdetaile;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\Upazila;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AddressdetaileController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('addressdetaile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

				$query = Addressdetaile::with(['employee', 'thana_upazila'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new Addressdetaile)->table));

			}elseif ($circles == null && $divisions !== null) {

				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');

				$query = Addressdetaile::with(['employee', 'thana_upazila'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new Addressdetaile)->table));

			}else{
				$query = Addressdetaile::with(['employee', 'thana_upazila'])
				->select(sprintf('%s.*', (new Addressdetaile)->table));
			}
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'addressdetaile_show';
                $editGate      = 'addressdetaile_edit';
                $deleteGate    = 'addressdetaile_delete';
                $crudRoutePart = 'addressdetailes';

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
            $table->editColumn('address_type', function ($row) {
                return $row->address_type ? $row->address_type : '';
            });
            $table->editColumn('flat_house', function ($row) {
                return $row->flat_house ? $row->flat_house : '';
            });
            $table->editColumn('post_office', function ($row) {
                return $row->post_office ? $row->post_office : '';
            });
            $table->editColumn('post_code', function ($row) {
                return $row->post_code ? $row->post_code : '';
            });
            $table->addColumn('thana_upazila_name_bn', function ($row) {
                return $row->thana_upazila ? $row->thana_upazila->name_bn : '';
            });

            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Addressdetaile::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'thana_upazila']);

            return $table->make(true);
        }

        return view('admin.addressdetailes.index');
    }

    public function create(Request $request)
    {
        $locale = App::getLocale();
$columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        abort_if(Gate::denies('addressdetaile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
 $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $thana_upazilas = Upazila::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.addressdetailes.create', compact('employees', 'thana_upazilas','employee'));
    }

    public function store(StoreAddressdetaileRequest $request)
    {
        $addressdetaile = Addressdetaile::create($request->all());
         return redirect()->back()->with('status', __('global.saveactions'));

        //return redirect()->route('admin.addressdetailes.index');
    }

    public function edit(Addressdetaile $addressdetaile)
    {
        abort_if(Gate::denies('addressdetaile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $thana_upazilas = Upazila::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $addressdetaile->load('employee', 'thana_upazila');

        return view('admin.addressdetailes.edit', compact('addressdetaile', 'employees', 'thana_upazilas'));
    }

    // public function update(UpdateAddressdetaileRequest $request, Addressdetaile $addressdetaile)
    // {
    //     $addressdetaile->update($request->all());


	// 	return redirect()->back()->with('status', __('global.updateAction'));

    // }

    //With Upload

    public function update(Request $request)
    {

        $fieldLabels = [
            'flat_house' => 'ফ্ল্যাট/বাড়ি, রাস্তা, গ্রাম/শহর',
            'post_office' => 'ডাকঘর',
            'post_code' => 'পোস্ট কোড',
            'thana_upazila_id' => 'থানা/উপজেলা',
            'phone_number' => 'টেলিফোন/মোবাইল নম্বর',
            'status' => 'সরকারী কোয়ার্টার',
        ];
        $addressdetaile = Addressdetaile::findOrFail($request->id);

        // Exclude 'nid_upload' from fill since it's handled manually
        $addressdetaile->fill($request->all());

        // Check for changed attributes
        foreach ($addressdetaile->getDirty() as $field => $newValue) {
            $dropdownFields = ['thana_upazila_id'];
            $type = in_array($field, $dropdownFields) ? 2 : 1;

            // Log field change
            Editlog::create([
                'type' => $type,
                'form' => 4,
                'data_id' => $addressdetaile->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $newValue,
                'edit_by' => auth()->id(),
                'employee_id' => $addressdetaile->employee->id,
            ]);
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }


    public function show(Addressdetaile $addressdetaile)
    {
        abort_if(Gate::denies('addressdetaile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addressdetaile->load('employee', 'thana_upazila');

        return view('admin.addressdetailes.show', compact('addressdetaile'));
    }

    public function destroy(Addressdetaile $addressdetaile)
    {
        abort_if(Gate::denies('addressdetaile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addressdetaile->delete();

        return back();
    }

    public function massDestroy(MassDestroyAddressdetaileRequest $request)
    {
        $addressdetailes = Addressdetaile::find(request('ids'));

        foreach ($addressdetailes as $addressdetaile) {
            $addressdetaile->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

	public function presentAddress(Request $request)
    {
		$id = $request->query('id');
        // dd('hi');
        $thana = Upazila::all();
		//dd($thana);
        $employee = EmployeeList::where('id',$id)->first();
        // dd($employee);

        return view('admin.update.presentAddress_create',compact('thana','employee'));
    }

    public function presentAddressStore(Request $request)
    {
        //dd($request->all());
        if ($request->input('same') ==2) {

            $employee = new Addressdetaile();

            $employee->address_type = 'present';
            $employee->flat_house = $request->input('flat_house');
            $employee->post_office = $request->input('post_office');
            $employee->post_code = $request->input('post_code');
            $employee->phone_number = $request->input('phone_number');
            $employee->status = $request->input('status');
            $employee->employee_id = $request->input('employee_id');
            $employee->thana_upazila_id = $request->input('thana_upazila_id');

            $employee->save();

            return redirect()->back()->with('success', 'Present Address Created Successfully.');


        }elseif ($request->input('same') == 1) {

            $presentAddress = new Addressdetaile();

            $presentAddress->address_type = 'present';
            $presentAddress->flat_house = $request->input('flat_house');
            $presentAddress->post_office = $request->input('post_office');
            $presentAddress->post_code = $request->input('post_code');
            $presentAddress->phone_number = $request->input('phone_number');
            $presentAddress->status = $request->input('status');
            $presentAddress->employee_id = $request->input('employee_id');
            $presentAddress->thana_upazila_id = $request->input('thana_upazila_id');

            $presentAddress->save();

            $permanentAddress = new Addressdetaile();

            $permanentAddress->address_type = 'permanent';
            $permanentAddress->flat_house = $request->input('flat_house');
            $permanentAddress->post_office = $request->input('post_office');
            $permanentAddress->post_code = $request->input('post_code');
            $permanentAddress->phone_number = $request->input('phone_number');
            $permanentAddress->status = $request->input('status');
            $permanentAddress->employee_id = $request->input('employee_id');
            $permanentAddress->thana_upazila_id = $request->input('thana_upazila_id');

            $permanentAddress->save();
            return redirect()->back()->with('success', 'Present and Permanent Address Created Successfully.');

        }

        return redirect()->back()->with('success', 'Present Address Created Successfully.');
    }



    public function permanentAddress(Request $request)
    {
        // dd('hi');
		$id = $request->query('id');
        $thana = Upazila::all();
        $employee = EmployeeList::where('id',$id)->first();
        // dd($employee);

        return view('admin.update.permanent_address_create',compact('thana','employee'));
    }

    public function permanentAddressStore(Request $request)
    {
        // dd($request->all());

            $employee = new Addressdetaile();

            $employee->address_type = 'permanent';
            $employee->flat_house = $request->input('flat_house');
            $employee->post_office = $request->input('post_office');
            $employee->post_code = $request->input('post_code');
            $employee->phone_number = $request->input('phone_number');
            $employee->status = $request->input('status');
            $employee->employee_id = $request->input('employee_id');
            $employee->thana_upazila_id = $request->input('thana_upazila_id');

            $employee->save();

            return redirect()->back()->with('success', 'Permanent Address Created Successfully.');
    }

}
