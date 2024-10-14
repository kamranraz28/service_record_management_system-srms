<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOtherServiceJobRequest;
use App\Http\Requests\StoreOtherServiceJobRequest;
use App\Http\Requests\UpdateOtherServiceJobRequest;
use App\Models\EmployeeList;
use App\Models\OtherServiceJob;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtherServiceJobController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('other_service_job_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$userId = Auth::id(); 
		//dd($userId);
		
		$userInfo = User::select('forest_circle_id', 'forest_division_id')
					->where('id', $userId)
					->first();
		$divisions= $userInfo->forest_division_id;
		// dd($divisions);
		$circles= $userInfo->forest_circle_id;
		//dd($circles);
		
		if ($circles !== null && $divisions == null) {
				
			$sameOfficeIds = User::select('id')
				->where('forest_circle_id', $circles)
				->pluck('id');
				
			$otherServiceJobs = OtherServiceJob::with(['employee'])
				->whereHas('employee', function ($query) use ($sameOfficeIds) {
					$query->whereIn('created_by', $sameOfficeIds);
				})
				->get();

		}elseif ($circles == null && $divisions !== null) {
			
			$sameOfficeIds = User::select('id')
				->where('forest_division_id', $divisions)
				->pluck('id');
				
			$otherServiceJobs = OtherServiceJob::with(['employee'])
				->whereHas('employee', function ($query) use ($sameOfficeIds) {
					$query->whereIn('created_by', $sameOfficeIds);
				})
				->get();

		}else{
			$otherServiceJobs = OtherServiceJob::with(['employee'])
			->get();
		}
		
        //$otherServiceJobs = OtherServiceJob::with(['employee'])->get();

        return view('admin.otherServiceJobs.index', compact('otherServiceJobs'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('other_service_job_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.otherServiceJobs.create', compact('employees','employee'));
    }

    public function store(StoreOtherServiceJobRequest $request)
    {
        $otherServiceJob = OtherServiceJob::create($request->all());
         return redirect()->back()->with('status', __('global.saveactions'));
       /// return redirect()->route('admin.other-service-jobs.index');
    }

    public function edit(OtherServiceJob $otherServiceJob)
    {
        abort_if(Gate::denies('other_service_job_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $otherServiceJob->load('employee');

        return view('admin.otherServiceJobs.edit', compact('employees', 'otherServiceJob'));
    }

    public function update(UpdateOtherServiceJobRequest $request, OtherServiceJob $otherServiceJob)
    {
        $otherServiceJob->update($request->all());

        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(OtherServiceJob $otherServiceJob)
    {
        abort_if(Gate::denies('other_service_job_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherServiceJob->load('employee');

        return view('admin.otherServiceJobs.show', compact('otherServiceJob'));
    }

    public function destroy(OtherServiceJob $otherServiceJob)
    {
        abort_if(Gate::denies('other_service_job_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherServiceJob->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtherServiceJobRequest $request)
    {
        $otherServiceJobs = OtherServiceJob::find(request('ids'));

        foreach ($otherServiceJobs as $otherServiceJob) {
            $otherServiceJob->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
