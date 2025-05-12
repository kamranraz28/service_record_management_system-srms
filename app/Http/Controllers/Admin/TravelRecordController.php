<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTravelRecordRequest;
use App\Http\Requests\StoreTravelRecordRequest;
use App\Http\Requests\UpdateTravelRecordRequest;
use App\Models\Country;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\TravelPurpose;
use App\Models\TravelRecord;
use App\Models\TravelTitle;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TravelRecordController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('travel_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

				$query = TravelRecord::with(['employee', 'title', 'country', 'purpose'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new TravelRecord)->table));

			}elseif ($circles == null && $divisions !== null) {

				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');

				$query = TravelRecord::with(['employee', 'title', 'country', 'purpose'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new TravelRecord)->table));

			}else{
				$query = TravelRecord::with(['employee', 'title', 'country', 'purpose'])
				->select(sprintf('%s.*', (new TravelRecord)->table));
			}
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'travel_record_show';
                $editGate      = 'travel_record_edit';
                $deleteGate    = 'travel_record_delete';
                $crudRoutePart = 'travel-records';

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

			$table->addColumn('name_bn', function ($row) {
                return $row->employee ? $row->employee->fullname_bn : '';
            });

            $table->addColumn('title_name_bn', function ($row) {
                return $row->title ? $row->title->name_bn : '';
            });

            $table->addColumn('country_name_bn', function ($row) {
                return $row->country ? $row->country->name_bn : '';
            });

            $table->addColumn('purpose_name_bn', function ($row) {
                return $row->purpose ? $row->purpose->name_bn : '';
            });

			$table->editColumn('title', function ($row) {
                return $row->new_title ? $row->new_title : '';
            });
			$table->editColumn('start_date', function ($row) {
                return $row->start_date ? englishToBanglaNumber($row->start_date) : '';
            });
			$table->editColumn('end_date', function ($row) {
                return $row->end_date ? englishToBanglaNumber($row->end_date) : '';
            });
            $table->rawColumns(['actions', 'placeholder', 'employee', 'title', 'country', 'purpose']);

            return $table->make(true);
        }

        return view('admin.travelRecords.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('travel_record_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $titles = TravelTitle::pluck( $columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck( $columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $purposes = TravelPurpose::pluck( $columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.travelRecords.create', compact('countries', 'employees', 'purposes', 'titles','employee'));
    }

    public function store(StoreTravelRecordRequest $request)
    {

		//dd(1);

        $data = $request->all();
        if ($data['title_id'] == 'Other') {
            $travelTitle = new TravelTitle();
            $travelTitle->name_bn = $data['name_bn'];
            $travelTitle->name_en = $data['name_en'];
            $travelTitle->save();
            $data['title_id'] = $travelTitle->id;
        }

        $travelRecord = TravelRecord::create($data);

        return redirect()->back()->with('status', __('global.saveactions'));
    }

    public function edit(TravelRecord $travelRecord)
    {
        abort_if(Gate::denies('travel_record_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $titles = TravelTitle::pluck( $columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck( $columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $purposes = TravelPurpose::pluck( $columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $travelRecord->load('employee', 'title', 'country', 'purpose');

        return view('admin.travelRecords.edit', compact('countries', 'employees', 'purposes', 'titles', 'travelRecord'));
    }

    // public function update(UpdateTravelRecordRequest $request, TravelRecord $travelRecord)
    // {
    //     $travelRecord->update($request->all());

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    public function update(Request $request)
    {
        //dd($request->all());
        $travelRecord = TravelRecord::find($request->id);

        // Fill new data from request
        $travelRecord->fill($request->all());

        $fieldLabels = [
            'country_id' => 'দেশ',
            'title_id' => 'উদ্দেশ্য',
            'start_date' => 'শুরুর তারিখ',
            'end_date' => 'শেষ তারিখ',
        ];

        if ($travelRecord->isDirty()) {
            foreach ($travelRecord->getDirty() as $field => $newValue) {
                Editlog::create([
                    'form' => 12,
                    'data_id' => $travelRecord->id,
                    'field' => $field,
                    'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                    'content' => $newValue,
                    'edit_by' => auth()->id(),
                    'employee_id' => $travelRecord->employee->id,
                ]);
            }
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(TravelRecord $travelRecord)
    {
        abort_if(Gate::denies('travel_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $travelRecord->load('employee', 'title', 'country', 'purpose');

        return view('admin.travelRecords.show', compact('travelRecord'));
    }

    public function destroy(TravelRecord $travelRecord)
    {
        abort_if(Gate::denies('travel_record_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $travelRecord->delete();

        return back();
    }

    public function massDestroy(MassDestroyTravelRecordRequest $request)
    {
        $travelRecords = TravelRecord::find(request('ids'));

        foreach ($travelRecords as $travelRecord) {
            $travelRecord->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
