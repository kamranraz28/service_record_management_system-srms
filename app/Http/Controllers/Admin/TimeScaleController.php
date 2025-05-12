<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPoliceVerificationRequest;
use App\Http\Requests\StorePoliceVerificationRequest;
use App\Http\Requests\UpdatePoliceVerificationRequest;
use App\Models\Editlog;
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


    // public function update(Request $request, TimeScale $timeScale)
    // {
    //     //dd($request->all());
    //     $timeScale->update($request->all());

    //     if ($request->input('office_order', false)) {
    //         if (! $timeScale->office_order || $request->input('office_order') !== $timeScale->office_order->file_name) {
    //             if ($timeScale->office_order) {
    //                 $timeScale->office_order->delete();
    //             }
    //             $timeScale->addMedia(storage_path('tmp/uploads/' . basename($request->input('office_order'))))->toMediaCollection('office_order');
    //         }
    //     } elseif ($timeScale->office_order) {
    //         $timeScale->office_order->delete();
    //     }

    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }


    public function update(Request $request)
    {

        $fieldLabels = [
            'type' => 'ধরণ',
            'receipt_date' => 'প্রাপ্তির তারিখ',
            'order_date' => 'অফিস আদেশ নম্বর ও তারিখ',
            'office_order' => 'অফিস আদেশ আপলোড',
        ];
        $timeScale = TimeScale::findOrFail($request->id);

        // Exclude 'office_order' from fill since it's handled manually
        $timeScale->fill($request->except('office_order'));

        // Check for changed attributes
        foreach ($timeScale->getDirty() as $field => $newValue) {
            $content = $newValue;

            // If the changed field is 'type', map value to Bangla label
            if ($field === 'type') {
                switch ($newValue) {
                    case 1:
                        $content = 'টাইম স্কেল';
                        break;
                    case 2:
                        $content = 'উচ্চতর গ্রেড';
                        break;
                    case 3:
                        $content = 'বেতন সংরক্ষণ';
                        break;
                    default:
                        $content = $newValue;
                }
            }

            // Log field change
            Editlog::create([
                'type' => 1,
                'form' => 19,
                'data_id' => $timeScale->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $content,
                'edit_by' => auth()->id(),
                'employee_id' => $timeScale->employee->id,
            ]);
        }

        // Handle 'office_order' file logic manually (not via isDirty())
        if ($request->has('office_order')) {
            $filename = basename($request->input('office_order'));
            $tmpPath = storage_path('tmp/uploads/' . $filename);

            if (file_exists($tmpPath)) {
                $existingMedia = $timeScale->getFirstMedia('office_order');
                $existingFilename = $existingMedia ? $existingMedia->file_name : null;

                // Only add media and log if it's actually a different file
                if ($filename !== $existingFilename) {
                    $timeScale
                        ->addMedia($tmpPath)
                        ->toMediaCollection('office_order');

                    // Log upload
                    Editlog::create([
                        'type' => 3,
                        'form' => 19,
                        'data_id' => $timeScale->id,
                        'field' => 'office_order',
                        'level' => $fieldLabels['office_order'] ?? 'office_order',
                        'content' => $filename,
                        'edit_by' => auth()->id(),
                        'employee_id' => $timeScale->employee->id,
                    ]);
                }
            }
        } elseif ($timeScale->getFirstMedia('office_order')) {
            // Only clear if media exists
            $timeScale->clearMediaCollection('office_order');

            Editlog::create([
                'type' => 3,
                'form' => 19,
                'data_id' => $timeScale->id,
                'field' => 'office_order',
                'level' => $fieldLabels['office_order'] ?? 'office_order',
                'content' => '',
                'edit_by' => auth()->id(),
                'employee_id' => $timeScale->employee->id,
            ]);
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
