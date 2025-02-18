<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPoliceVerificationRequest;
use App\Http\Requests\StorePoliceVerificationRequest;
use App\Http\Requests\UpdatePoliceVerificationRequest;
use App\Models\EmployeeList;
use App\Models\PoliceVerification;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;


class PoliceVerificationController extends Controller
{
    //

    public function create(Request $request)
    {
        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.policeVerification.create', compact('employees','employee'));
    }

    public function store(StorePoliceVerificationRequest $request)
    {
        //dd($request->all());
        $policeVerification = PoliceVerification::create($request->all());

        if ($request->input('applicant_form', false)) {
            $policeVerification->addMedia(storage_path('tmp/uploads/' . basename($request->input('applicant_form'))))->toMediaCollection('applicant_form');
        }
        if ($request->input('verified_form', false)) {
            $policeVerification->addMedia(storage_path('tmp/uploads/' . basename($request->input('verified_form'))))->toMediaCollection('verified_form');
        }


         return redirect()->back()->with('status', __('global.saveactions'));
    }



    public function edit(PoliceVerification $policeVerification)
    {
        
        return view('admin.policeVerification.edit', compact('policeVerification'));
    }


    public function update(UpdatePoliceVerificationRequest $request, PoliceVerification $policeVerification)
    {
        //dd($request->all());
        $policeVerification->update($request->all());

        if ($request->input('applicant_form', false)) {
            if (! $policeVerification->applicant_form || $request->input('applicant_form') !== $policeVerification->applicant_form->file_name) {
                if ($policeVerification->applicant_form) {
                    $policeVerification->applicant_form->delete();
                }
                $policeVerification->addMedia(storage_path('tmp/uploads/' . basename($request->input('applicant_form'))))->toMediaCollection('applicant_form');
            }
        } elseif ($policeVerification->applicant_form) {
            $policeVerification->applicant_form->delete();
        }

        if ($request->input('verified_form', false)) {
            if (! $policeVerification->verified_form || $request->input('verified_form') !== $policeVerification->verified_form->file_name) {
                if ($policeVerification->verified_form) {
                    $policeVerification->verified_form->delete();
                }
                $policeVerification->addMedia(storage_path('tmp/uploads/' . basename($request->input('verified_form'))))->toMediaCollection('verified_form');
            }
        } elseif ($policeVerification->verified_form) {
            $policeVerification->verified_form->delete();
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

    public function destroy(PoliceVerification $policeVerification)
    {

        $policeVerification->delete();

        return back();
    }




}
