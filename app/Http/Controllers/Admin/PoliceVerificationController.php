<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPoliceVerificationRequest;
use App\Http\Requests\StorePoliceVerificationRequest;
use App\Http\Requests\UpdatePoliceVerificationRequest;
use App\Models\Editlog;
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


    // public function update(UpdatePoliceVerificationRequest $request, PoliceVerification $policeVerification)
    // {
    //     //dd($request->all());
    //     $policeVerification->update($request->all());

    //     if ($request->input('applicant_form', false)) {
    //         if (! $policeVerification->applicant_form || $request->input('applicant_form') !== $policeVerification->applicant_form->file_name) {
    //             if ($policeVerification->applicant_form) {
    //                 $policeVerification->applicant_form->delete();
    //             }
    //             $policeVerification->addMedia(storage_path('tmp/uploads/' . basename($request->input('applicant_form'))))->toMediaCollection('applicant_form');
    //         }
    //     } elseif ($policeVerification->applicant_form) {
    //         $policeVerification->applicant_form->delete();
    //     }

    //     if ($request->input('verified_form', false)) {
    //         if (! $policeVerification->verified_form || $request->input('verified_form') !== $policeVerification->verified_form->file_name) {
    //             if ($policeVerification->verified_form) {
    //                 $policeVerification->verified_form->delete();
    //             }
    //             $policeVerification->addMedia(storage_path('tmp/uploads/' . basename($request->input('verified_form'))))->toMediaCollection('verified_form');
    //         }
    //     } elseif ($policeVerification->verified_form) {
    //         $policeVerification->verified_form->delete();
    //     }

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }

    public function update(Request $request)
    {
        //dd($request->all());
        $fieldLabels = [
            'verification_type' => 'পুলিশ ভেরিফিকেশন হয়েছে কিনা?',
            'applicant_form' => 'প্রার্থী কর্তৃক পূরণীয় ফরম আপলোড',
            'verified_form' => 'ভেরিফাইড তথ্যাদি আপলোড (যা পুলিশ প্রেরণ করেছে)',
        ];

        $policeVerification = PoliceVerification::findOrFail($request->id);

        $fileFields = ['applicant_form', 'verified_form'];
        $policeVerification->fill($request->except($fileFields));

        foreach ($policeVerification->getDirty() as $field => $newValue) {
            $content = $newValue;

            // If the changed field is 'type', map value to Bangla label
            if ($field === 'verification_type') {
                switch ($newValue) {
                    case 1:
                        $content = 'হ্যাঁ';
                        break;
                    case 2:
                        $content = 'না';
                        break;
                    default:
                        $content = $newValue;
                }
            }
            Editlog::create([
                'type' => 1,
                'form' => 20,
                'data_id' => $policeVerification->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $content,
                'edit_by' => auth()->id(),
                'employee_id' => $policeVerification->employee->id,
            ]);
        }

        foreach ($fileFields as $field) {
            $newFilename = $request->input($field);

            if ($newFilename) {
                $newFilename = basename($newFilename);
                $tmpPath = storage_path('tmp/uploads/' . $newFilename);

                if (file_exists($tmpPath)) {
                    $existingMedia = $policeVerification->getFirstMedia($field);
                    $existingFilename = $existingMedia ? $existingMedia->file_name : null;

                    if ($newFilename !== $existingFilename) {
                        // Upload and log only if the file name is different
                        $policeVerification->clearMediaCollection($field); // optional, if only 1 file per field
                        $policeVerification->addMedia($tmpPath)->toMediaCollection($field);

                        Editlog::create([
                            'type' => 3,
                            'form' => 20,
                            'data_id' => $policeVerification->id,
                            'field' => $field,
                            'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                            'content' => $newFilename,
                            'edit_by' => auth()->id(),
                            'employee_id' => $policeVerification->employee->id,
                        ]);
                    }
                }
            } elseif ($policeVerification->getMedia($field)->isNotEmpty()) {
                // If user intentionally cleared the file
                $policeVerification->clearMediaCollection($field);

                Editlog::create([
                    'type' => 3,
                    'form' => 20,
                    'data_id' => $policeVerification->id,
                    'field' => $field,
                    'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                    'content' => '',
                    'edit_by' => auth()->id(),
                    'employee_id' => $policeVerification->employee->id,
                ]);
            }
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
