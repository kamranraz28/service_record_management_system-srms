<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPoliceVerificationRequest;
use App\Http\Requests\StorePoliceVerificationRequest;
use App\Http\Requests\UpdatePoliceVerificationRequest;
use App\Models\EmployeeList;
use App\Models\PoliceVerification;
use App\Models\TimeScale;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;


class TimeScaleController extends Controller
{
    //

    public function create(Request $request)
    {
        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.timeScale.create', compact('employees','employee'));
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $timeScale = TimeScale::create($request->all());

        if ($request->input('office_order', false)) {
            $timeScale->addMedia(storage_path('tmp/uploads/' . basename($request->input('office_order'))))->toMediaCollection('office_order');
        }

         return redirect()->back()->with('status', __('global.saveactions'));
    }



    public function edit(TimeScale $timeScale)
    {
        
        return view('admin.timeScale.edit', compact('timeScale'));
    }


    public function update(Request $request, TimeScale $timeScale)
    {
        //dd($request->all());
        $timeScale->update($request->all());

        if ($request->input('office_order', false)) {
            if (! $timeScale->office_order || $request->input('office_order') !== $timeScale->office_order->file_name) {
                if ($timeScale->office_order) {
                    $timeScale->office_order->delete();
                }
                $timeScale->addMedia(storage_path('tmp/uploads/' . basename($request->input('office_order'))))->toMediaCollection('office_order');
            }
        } elseif ($timeScale->office_order) {
            $timeScale->office_order->delete();
        }
        
        return redirect()->back()->with('status', __('global.updateAction'));
    }



    public function massDestroy(MassDestroyPoliceVerificationRequest $request)
    {
        $policeVerifications = PoliceVerification::find(request('ids'));

        foreach ($policeVerifications as $policeVerification) {
            $policeVerification->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(TimeScale $timeScale)
    {

        $timeScale->delete();

        return back();
    }




}
