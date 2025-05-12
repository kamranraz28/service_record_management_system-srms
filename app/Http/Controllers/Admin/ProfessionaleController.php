<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProfessionaleRequest;
use App\Http\Requests\StoreProfessionaleRequest;
use App\Http\Requests\UpdateProfessionaleRequest;
use App\Models\Editlog;
use App\Models\EmployeeList;
use App\Models\Professionale;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfessionaleController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('professionale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

				$query = Professionale::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new Professionale)->table));

			}elseif ($circles == null && $divisions !== null) {

				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');

				$query = Professionale::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new Professionale)->table));

			}else{
				$query = Professionale::with(['employee'])
				->select(sprintf('%s.*', (new Professionale)->table));
			}



            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'professionale_show';
                $editGate = 'professionale_edit';
                $deleteGate = 'professionale_delete';
                $crudRoutePart = 'professionales';

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

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : '';
            });
            $table->editColumn('qualification_title', function ($row) {
                return $row->qualification_title ? $row->qualification_title : '';
            });
            $table->editColumn('institution', function ($row) {
                return $row->institution ? $row->institution : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.professionales.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('professionale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.professionales.create', compact('employees', 'employee'));
    }

    public function store(StoreProfessionaleRequest $request)
    {
        $professionale = Professionale::create($request->all());
        return redirect()->back()->with('status', __('global.saveactions'));
    }

    public function edit(Professionale $professionale)
    {
        abort_if(Gate::denies('professionale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professionale->load('employee');

        return view('admin.professionales.edit', compact('employees', 'professionale'));
    }

    // public function update(UpdateProfessionaleRequest $request, Professionale $professionale)
    // {
    //     $professionale->update($request->all());

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }
    public function update(Request $request)
    {
        //dd($request->all());
        $professionale = Professionale::find($request->id);

        // Fill new data from request
        $professionale->fill($request->all());

        $fieldLabels = [
            'qualification_title' => 'যোগ্যতার নাম',
            'institution' => 'প্রতিষ্ঠানের নাম',
            'from_date' => 'শুরুর তারিখ',
            'to_date' => 'শেষ তারিখ',
        ];

        if ($professionale->isDirty()) {
            foreach ($professionale->getDirty() as $field => $newValue) {
                Editlog::create([
                    'form' => 3,
                    'data_id' => $professionale->id,
                    'field' => $field,
                    'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                    'content' => $newValue,
                    'edit_by' => auth()->id(),
                    'employee_id' => $professionale->employee->id,
                ]);
            }
        }
        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(Professionale $professionale)
    {
        abort_if(Gate::denies('professionale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professionale->load('employee');

        return view('admin.professionales.show', compact('professionale'));
    }

    public function destroy(Professionale $professionale)
    {
        abort_if(Gate::denies('professionale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $professionale->delete();

        return back();
    }

    public function massDestroy(MassDestroyProfessionaleRequest $request)
    {
        $professionales = Professionale::find(request('ids'));

        foreach ($professionales as $professionale) {
            $professionale->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
