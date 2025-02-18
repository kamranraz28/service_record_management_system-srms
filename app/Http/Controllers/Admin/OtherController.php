<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPoliceVerificationRequest;
use App\Http\Requests\StorePoliceVerificationRequest;
use App\Http\Requests\UpdatePoliceVerificationRequest;
use App\Models\EmployeeList;
use App\Models\Other;
use App\Models\PoliceVerification;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;


class OtherController extends Controller
{
    //

    public function create(Request $request)
    {
        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.other.create', compact('employees','employee'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $other = Other::create($request->all());

        if ($request->input('health_paper', false)) {
            $other->addMedia(storage_path('tmp/uploads/' . basename($request->input('health_paper'))))->toMediaCollection('health_paper');
        }


         return redirect()->back()->with('status', __('global.saveactions'));
    }



    public function edit(Other $other)
    {
        
        return view('admin.other.edit', compact('other'));
    }


    public function update(Request $request, Other $other)
    {
        //dd($request->all());
        $other->update($request->all());

        if ($request->input('health_paper', false)) {
            if (! $other->health_paper || $request->input('health_paper') !== $other->health_paper->file_name) {
                if ($other->health_paper) {
                    $other->health_paper->delete();
                }
                $other->addMedia(storage_path('tmp/uploads/' . basename($request->input('health_paper'))))->toMediaCollection('health_paper');
            }
        } elseif ($other->health_paper) {
            $other->health_paper->delete();
        }


        return redirect()->back()->with('status', __('global.updateAction'));
    }



    public function destroy(Other $other)
    {

        $other->delete();

        return back();
    }




}
