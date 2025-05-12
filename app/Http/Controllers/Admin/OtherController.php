<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPoliceVerificationRequest;
use App\Http\Requests\StorePoliceVerificationRequest;
use App\Http\Requests\UpdatePoliceVerificationRequest;
use App\Models\Editlog;
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


    // public function update(Request $request, Other $other)
    // {
    //     //dd($request->all());
    //     $other->update($request->all());

    //     if ($request->input('health_paper', false)) {
    //         if (! $other->health_paper || $request->input('health_paper') !== $other->health_paper->file_name) {
    //             if ($other->health_paper) {
    //                 $other->health_paper->delete();
    //             }
    //             $other->addMedia(storage_path('tmp/uploads/' . basename($request->input('health_paper'))))->toMediaCollection('health_paper');
    //         }
    //     } elseif ($other->health_paper) {
    //         $other->health_paper->delete();
    //     }


    //     return redirect()->back()->with('status', __('global.updateAction'));
    // }


    public function update(Request $request)
    {

        $fieldLabels = [
            'health_paper' => 'স্বাস্থ্য পরীক্ষার জন্য কাগজপত্র আপলোড',
            'possible_date' => 'পরবর্তী শ্রান্তি বিনোদনে যাওয়ার সম্ভাব্য তারিখ',
            'office' => 'কর্মকর্তা/কর্মচারী সংযুক্তি হলে বর্তমান কর্মস্থল',
        ];
        $other = Other::findOrFail($request->id);

        // Exclude 'health_paper' from fill since it's handled manually
        $other->fill($request->except('health_paper'));

        // Check for changed attributes
        foreach ($other->getDirty() as $field => $newValue) {

            // Log field change
            Editlog::create([
                'type' => 1,
                'form' => 21,
                'data_id' => $other->id,
                'field' => $field,
                'level' => $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                'content' => $newValue,
                'edit_by' => auth()->id(),
                'employee_id' => $other->employee->id,
            ]);
        }

        // Handle 'health_paper' file logic manually (not via isDirty())
        if ($request->has('health_paper')) {
            $filename = basename($request->input('health_paper'));
            $tmpPath = storage_path('tmp/uploads/' . $filename);

            if (file_exists($tmpPath)) {
                $existingMedia = $other->getFirstMedia('health_paper');
                $existingFilename = $existingMedia ? $existingMedia->file_name : null;

                // Only add media and log if it's actually a different file
                if ($filename !== $existingFilename) {
                    $other
                        ->addMedia($tmpPath)
                        ->toMediaCollection('health_paper');

                    // Log upload
                    Editlog::create([
                        'type' => 3,
                        'form' => 21,
                        'data_id' => $other->id,
                        'field' => 'health_paper',
                        'level' => $fieldLabels['health_paper'] ?? 'health_paper',
                        'content' => $filename,
                        'edit_by' => auth()->id(),
                        'employee_id' => $other->employee->id,
                    ]);
                }
            }
        } elseif ($other->getFirstMedia('health_paper')) {
            // Only clear if media exists
            $other->clearMediaCollection('health_paper');

            Editlog::create([
                'type' => 3,
                'form' => 21,
                'data_id' => $other->id,
                'field' => 'health_paper',
                'level' => $fieldLabels['health_paper'] ?? 'health_paper',
                'content' => '',
                'edit_by' => auth()->id(),
                'employee_id' => $other->employee->id,
            ]);
        }

        return redirect()->back()->with('status', __('global.updateAction'));
    }





    public function destroy(Other $other)
    {

        $other->delete();

        return back();
    }




}
