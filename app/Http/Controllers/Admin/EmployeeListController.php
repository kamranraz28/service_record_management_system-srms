<?php

namespace App\Http\Controllers\Admin;

use App\Models\Editlog;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeListRequest;
use App\Http\Requests\StoreEmployeeListRequest;
use App\Http\Requests\UpdateEmployeeListRequest;
use App\Models\Batch;
use App\Models\BloodGroup;
use App\Models\Designation;
use App\Models\District;
use App\Models\EmployeeList;
use App\Models\ExamBoard;
use App\Models\ExamDegree;
use App\Models\Examination;
use App\Models\FreedomFighteRelation;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\JobType;
use App\Models\Joininginfo;
use App\Models\LicenseType;
use App\Models\Maritalstatus;
use App\Models\Project;
use App\Models\ProjectRevenueExam;
use App\Models\ProjectRevenuelone;
use App\Models\Quotum;
use App\Models\Religion;
use App\Models\Upazila;
use App\Models\User;
use App\Models\ForestDivision;
use App\Models\ForestState;
use App\Models\TransferLog;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;


use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Carbon\Carbon;



class EmployeeListController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $userId = Auth::id();
        //dd($userId);

        $id = Session::get('id');
        // dd($id);

        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();
        $divisions = $userInfo->forest_division_id;
        // dd($divisions);
        $circles = $userInfo->forest_circle_id;
        //dd($circles);



        if ($circles !== null && $divisions == null) {
            //dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            //dd($sameOfficeIds);

            if ($id === null) {
                $data = EmployeeList::with('designation')
                    ->whereIn('created_by', $sameOfficeIds)
                    ->where('approve', 'Approved')
                    ->paginate(10);
            } else {
                $data = EmployeeList::with('designation')
                    ->where('employeeid', $id)
                    ->whereIn('created_by', $sameOfficeIds)
                    ->where('approve', 'Approved')
                    ->paginate(10);
            }


            $total = $data->total(); // `total()` gives the total number of results for the pagination

            return view('admin.employeeLists.index', compact('data', 'total'));
        } elseif ($circles == null && $divisions !== null) {
            //dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            //dd($sameOfficeIds);

            if ($id === null) {
                $data = EmployeeList::with('designation')
                    ->whereIn('created_by', $sameOfficeIds)
                    ->where('approve', 'Approved')
                    ->paginate(10);
            } else {
                $data = EmployeeList::with('designation')
                    ->where('employeeid', $id)
                    ->whereIn('created_by', $sameOfficeIds)
                    ->where('approve', 'Approved')
                    ->paginate(10);
            }

            $total = $data->total(); // `total()` gives the total number of results for the pagination

            return view('admin.employeeLists.index', compact('data', 'total'));
        } else {
            //dd('Admin');


            if ($id !== null) {
                $data = EmployeeList::with('designation')
                    ->where('employeeid', $id)
                    ->where('approve', 'Approved')
                    ->paginate(10);
            } else {
                $data = EmployeeList::with('designation')
                    ->where('approve', 'Approved')
                    ->paginate(10);
            }

            $total = $data->count();

            return view('admin.employeeLists.index', compact('data', 'total'));
        }
    }


    public function searchEmployee(Request $request)
    {
        $id = $request->input('id');


        Session::put('id', $id);


        return redirect()->route('admin.employee-lists.index');
    }



    public function waitingList()
    {

        $userId = Auth::id();

        $data = EmployeeList::with('designation')
            ->where('created_by', $userId)
            ->whereNull('approve')
            ->paginate(10);

        $total = count($data);
        //dd($total);

        return view('admin.employeeLists.waiting-list', compact('data', 'total'));
    }

    public function dfo()
    {
        $userId = Auth::id();

        $division = User::where('id', $userId)
            ->pluck('forest_division_id')
            ->first();
        $circle = User::where('id', $userId)
            ->pluck('forest_circle_id')
            ->first();

        if ($division !== null && $circle == null) {
            $user_ids = User::where('forest_division_id', $division)
                ->pluck('id');
            // dd($user_ids);
        } elseif ($division == null && $circle !== null) {
            $user_ids = User::where('forest_circle_id', $circle)
                ->pluck('id');
            // dd($user_ids);

        } else {
            $user_ids = User::pluck('id');
            // dd($user_ids);
        }

        $data = EmployeeList::with('jobhistories.designation')
            ->where('approve', 'pending')
            ->whereIn('created_by', $user_ids)
            ->paginate(10);
        // dd($data);

        $total = $data->total();
        // dd($total);

        return view('admin.employeeLists.dfo-review-list', compact('data', 'total'));




    }

    public function transfer()
    {
        $userId = Auth::id();
        //dd($userId);

        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();
        $divisions = $userInfo->forest_division_id;
        // dd($divisions);
        $circles = $userInfo->forest_circle_id;
        //dd($circles);
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';




        if ($circles !== null && $divisions == null) {
            // dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            //dd($sameOfficeIds);

            // Now use whereIn to filter employees created by those IDs
            $data = EmployeeList::with('designation')
                ->whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved')
                ->paginate(10);

            $total = $data->total(); // `total()` gives the total number of results for the pagination

            $divisionList = ForestDivision::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

            $circleList = ForestState::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

            return view('admin.employeeLists.transfer', compact('divisionList', 'circleList', 'data', 'total'));
        } elseif ($circles == null && $divisions !== null) {
            // dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            //dd($sameOfficeIds);

            // Now use whereIn to filter employees created by those IDs
            $data = EmployeeList::with('designation')
                ->whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved')
                ->paginate(10);

            $total = $data->total(); // `total()` gives the total number of results for the pagination

            $divisionList = ForestDivision::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

            $circleList = ForestState::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
            return view('admin.employeeLists.transfer', compact('divisionList', 'circleList', 'data', 'total'));
        } else {
            // dd('Admin');
            $data = EmployeeList::with('designation')
                ->where('approve', 'Approved')
                ->paginate(10);

            $total = $data->count();

            $divisionList = ForestDivision::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

            $circleList = ForestState::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

            return view('admin.employeeLists.transfer', compact('divisionList', 'circleList', 'data', 'total'));
        }
    }

    public function transferConfirm(Request $request, $id)
    {
        //dd($id);
        //dd($request->all());

        $division_id = $request->division_id;
        //dd($division_id);
        $circle_id = $request->circle_id;
        //dd($circle_id);

        $old_user = EmployeeList::where('id', $id)->first();
        //dd($old_user);
        $old_user_id = $old_user->created_by;
        //dd($old_user_id);

        if ($division_id == null && $circle_id !== null) {
            $user = User::where('forest_circle_id', $circle_id)->first();
            //dd($user);

            $user_id = $user->id;

            $log = new TransferLog();

            $log->employee_id = $id;
            $log->previous_office_id = $old_user_id;
            $log->division_id = null;
            $log->circle_id = $user_id;
            $log->comment = $request->comment;

            $log->save();
        } elseif ($division_id !== null && $circle_id == null) {
            $user = User::where('forest_division_id', $division_id)->first();
            //dd($user);
            $user_id = $user->id;

            $log = new TransferLog();

            $log->employee_id = $id;
            $log->previous_office_id = $old_user_id;
            $log->division_id = $user_id;
            $log->circle_id = null;
            $log->comment = $request->comment;

            $log->save();
        } else {
            return redirect()->back()->with('error', 'সার্কেল অথবা ডিভিশন যেকোন একটি নির্বাচন করতে হবে।');
        }



        EmployeeList::where('id', $id)->update(['created_by' => $user_id]);



        return redirect()->back()->with('success', 'স্থানান্তরটি সফলভাবে সম্পন্ন হয়েছে।');

    }

    public function transferList()
    {
        $userId = Auth::id();
        //dd($userId);

        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();
        $divisions = $userInfo->forest_division_id;
        // dd($divisions);
        $circles = $userInfo->forest_circle_id;
        //dd($circles);



        if ($circles !== null && $divisions == null) {
            //dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            //dd($sameOfficeIds);

            // Now use whereIn to filter employees created by those IDs
            $data = TransferLog::whereIn('previous_office_id', $sameOfficeIds)
                ->paginate(10);

            $total = $data->total(); // `total()` gives the total number of results for the pagination

            return view('admin.employeeLists.transferList', compact('data', 'total'));
        } elseif ($circles == null && $divisions !== null) {
            //dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            //dd($sameOfficeIds);

            // Now use whereIn to filter employees created by those IDs
            $data = TransferLog::whereIn('previous_office_id', $sameOfficeIds)
                ->paginate(10);

            $total = $data->total(); // `total()` gives the total number of results for the pagination

            return view('admin.employeeLists.transferList', compact('data', 'total'));
        } else {
            //dd('Admin');
            $data = TransferLog::paginate(10);

            $total = $data->count();

            return view('admin.employeeLists.transferList', compact('data', 'total'));
        }
    }


    public function three_months_report()
    {
        $userId = Auth::id();
        //dd($userId);
        $threeMonthsReport = [];

        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();
        $divisions = $userInfo->forest_division_id;
        // dd($divisions);
        $circles = $userInfo->forest_circle_id;
        //dd($circles);
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';




        if ($circles !== null && $divisions == null) {
            // dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            //dd($sameOfficeIds);

            // Now use whereIn to filter employees created by those IDs
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved')
                ->paginate(10);
        } elseif ($circles == null && $divisions !== null) {
            // dd('User');
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            //dd($sameOfficeIds);

            // Now use whereIn to filter employees created by those IDs
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved')
                ->paginate(10);
        } else {
            $employeeList = EmployeeList::where('approve', 'approved')->get();
        }





        foreach ($employeeList as $employee) {

            $jobHistories = [];
            $trainingHistories = [];
            $educationHistories = [];
            $mamlaHistories = [];

            // Process job histories
            foreach ($employee->allJob as $job) {
                if ($job->circle_list_id !== null && $job->division_list_id == null) {
                    $workPlace_bn = $job->circle_list->name_bn ?? '';
                    $workPlace_en = $job->circle_list->name_en ?? '';
                } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                    $workPlace_bn = $job->division_list->name_bn ?? '';
                    $workPlace_en = $job->division_list->name_en ?? '';
                } elseif ($job->level_2 !== null) {
                    $workPlace_bn = $job->level_2 ?? '';
                    $workPlace_en = $job->level_2 ?? '';
                } elseif ($job->academy_type !== null) {
                    $workPlace_bn = $job->academy_type ?? '';
                    $workPlace_en = $job->academy_type ?? '';
                } else {
                    $workPlace_bn = $job->institutename ?? '';
                    $workPlace_en = $job->institutename ?? '';
                }

                $jobHistories[] = [
                    'work_place_bn' => $workPlace_bn,
                    'work_place_en' => $workPlace_en,
                    'start_date' => $job->joining_date ?? '',
                    'end_date' => $job->release_date ?? '',
                ];
            }

            // Process training histories
            foreach ($employee->training_list as $training) {
                $trainingHistories[] = [
                    'training_name' => $training->training_name ?? '',
                ];
            }

            // Process education histories
            foreach ($employee->educationHistory as $education) {
                $educationHistories[] = [
                    'education_name_bn' => $education->name_of_exam->name_bn ?? '',
                    'education_name_en' => $education->name_of_exam->name_en ?? '',
                ];
            }

            // Process mamla histories
            foreach ($employee->mamlaHistory as $mamla) {
                $mamlaHistories[] = [
                    'mamla_name_bn' => $mamla->name_bn ?? '',
                    'mamla_name_en' => $mamla->name_en ?? '',
                    'mamla_start' => $mamla->mamla_start ?? '',
                    'mamla_end' => $mamla->mamla_end ?? '',
                    'comment' => $mamla->remzrk ?? '',
                ];
            }

            // Calculate total job duration
            $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

            $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
            $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

            // Add all the details to the report
            $threeMonthsReport[] = [
                'employee_name_bn' => $employee->fullname_bn ?? '',
                'employee_name_en' => $employee->fullname_en ?? '',
                'designation_bn' => $employee->designation->name_bn ?? '',
                'designation_en' => $employee->designation->name_en ?? '',
                'grade_bn' => $employee->grade->name_bn ?? '',
                'grade_en' => $employee->grade->name_en ?? '',
                'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                'dob' => $employee->date_of_birth ?? '',
                'home_district_bn' => $employee->home_district->name_bn ?? '',
                'home_district_en' => $employee->home_district->name_en ?? '',
                'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                'fjoining_date' => $employee->fjoining_date ?? '',
                'promotion_date' => $employee->promotion->go_issue_date ?? '',
                'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                'office_name' => $employee->jobhistory->level_2 ?? '',
                'joining_date' => $employee->jobhistory->joining_date ?? '',
                'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                'revenue_id' => $employee->projectrevenue_id ?? '',
                'project_id' => $employee->project_id ?? '',
                'project_name_bn' => $employee->project->name_bn ?? '',
                'project_name_en' => $employee->project->name_en ?? '',
                'job_histories' => $jobHistories,
                'total_job_bn' => $total_job_bn,
                'total_job_en' => $total_job_en,
                'quota_bn' => $employee->quota->name_bn ?? '',
                'quota_en' => $employee->quota->name_en ?? '',
                'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                'relation_en' => $employee->freedomfighter->name_en ?? '',
                'fighter_name' => $employee->freedomfighter_name ?? '',
                'fighter_address' => $employee->freedomfighter_address ?? '',
                'fighter_number' => $employee->freedomfighter_go ?? '',
                'training_histories' => $trainingHistories,
                'education_histories' => $educationHistories,
                'mamla_histories' => $mamlaHistories,
                'prl_date' => $employee->prl_date ?? '',
            ];
        }

        return view('admin.employeeLists.threeMonthsReport', compact('userId', 'threeMonthsReport'));
    }



    public function three_months_report_designation()
    {

        $designations = Designation::all();
        $districts = District::all();
        $quotas = Quotum::all();
        $circles = ForestState::all();
        $divisions = ForestDivision::all();


        return view('admin.employeeLists.threeMonthsDesignation', compact('divisions', 'circles', 'quotas', 'districts', 'designations'));
    }

    public function downloadThreeMonthsDesignation(Request $request)
    {

        $designationId = $request->designation_id;


        $desig = Designation::find($designationId);

        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        // Fetch employee data based on circle/division and designation_id (No pagination)
        if ($circles !== null && $divisions == null) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved');
        } elseif ($circles == null && $divisions !== null) {
            // Fetch employees in the same division
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved');
        } else {
            // Fetch all employees approved
            $employeeList = EmployeeList::where('approve', 'Approved');
        }

        if ($designationId) {
            $employeeList = $employeeList->where('designation_id', $designationId);
        }

        // Retrieve the data
        $employeeList = $employeeList->get();  // Execute the query


        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);
        $chunkReport = [];

        foreach ($chunks as $index => $chunk) {


            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthDesignationDownload', compact('desig', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }


    public function downloadThreeMonthsDistrict(Request $request)
    {

        $district_id = $request->district_id;
        // dd($district_id);

        $desig = District::find($district_id);

        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        // Fetch employee data based on circle/division and designation_id (No pagination)
        if ($circles !== null && $divisions == null) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved');
        } elseif ($circles == null && $divisions !== null) {
            // Fetch employees in the same division
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved');
        } else {
            // Fetch all employees approved
            $employeeList = EmployeeList::where('approve', 'Approved');
        }

        if ($district_id) {
            $employeeList = $employeeList->where('home_district_id', $district_id);
        }

        // Retrieve the data
        $employeeList = $employeeList->get();  // Execute the query


        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);


        foreach ($chunks as $index => $chunk) {
            $chunkReport = [];

            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthsDistrictDownload', compact('desig', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }


    public function downloadThreeMonthsQuota(Request $request)
    {

        $quota_id = $request->quota_id;
        //dd($quota_id);

        $desig = Quotum::find($quota_id);

        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        // Fetch employee data based on circle/division and designation_id (No pagination)
        if ($circles !== null && $divisions == null) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved');
        } elseif ($circles == null && $divisions !== null) {
            // Fetch employees in the same division
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved');
        } else {
            // Fetch all employees approved
            $employeeList = EmployeeList::where('approve', 'Approved');
        }

        if ($quota_id) {
            $employeeList = $employeeList->where('quota_id', $quota_id);
        }

        // Retrieve the data
        $employeeList = $employeeList->get();  // Execute the query


        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);


        foreach ($chunks as $index => $chunk) {
            $chunkReport = [];

            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthsQuotaDownload', compact('desig', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }


    public function downloadThreeMonthsCircle(Request $request)
    {

        $circle_id = $request->circle_id;
        // dd($circle_id);

        $desig = ForestState::find($circle_id);
        // dd($desig);

        $division_ids = ForestDivision::select('id')
            ->where('forest_state_id', $circle_id)
            ->pluck('id');


        $same = User::select('id')
            ->where('forest_circle_id', $circle_id)
            ->orWhereIn('forest_division_id', $division_ids)
            ->pluck('id');
        //dd($same);

        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        $employeeQuery = EmployeeList::where('approve', 'Approved');


        // Determine filtering logic based on user's circle/division
        if ($circles && !$divisions) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::where('forest_circle_id', $circles)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        } elseif (!$circles && $divisions) {
            // Fetch employees in the same division
            $sameOfficeIds = User::where('forest_division_id', $divisions)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        }

        if ($circle_id) {
            $same = User::where('forest_circle_id', $circle_id)->pluck('id');
            $employeeQuery->whereIn('created_by', $same);
        }

        // Retrieve the data
        $employeeList = $employeeQuery->get();

        // Debug output (Remove or comment this in production)
        // dd($employeeList);


        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);
        $chunkReport = [];

        foreach ($chunks as $index => $chunk) {


            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthsCircleDownload', compact('desig', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }

    public function downloadThreeMonthsCirclOffice(Request $request)
    {

        $circle_id = $request->circle_id;
        // dd($circle_id);

        $desig = ForestState::find($circle_id);
        // dd($desig);

        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        $employeeQuery = EmployeeList::where('approve', 'Approved');


        // Determine filtering logic based on user's circle/division
        if ($circles && !$divisions) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::where('forest_circle_id', $circles)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        } elseif (!$circles && $divisions) {
            // Fetch employees in the same division
            $sameOfficeIds = User::where('forest_division_id', $divisions)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        }

        if ($circle_id) {
            $same = User::where('forest_circle_id', $circle_id)->pluck('id');
            $employeeQuery->whereIn('created_by', $same);
        }

        // Retrieve the data
        $employeeList = $employeeQuery->get();

        // Debug output (Remove or comment this in production)
        // dd($employeeList);


        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);


        foreach ($chunks as $index => $chunk) {
            $chunkReport = [];

            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthsCircleDownload', compact('desig', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }


    public function downloadThreeMonthsDivision(Request $request)
    {

        $division_id = $request->division_id;
        // dd($division_id);

        $desig = ForestDivision::find($division_id);
        // dd($desig);

        $same = User::select('id')
            ->where('forest_circle_id', $division_id)
            ->pluck('id');
        // dd($same);

        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        $employeeQuery = EmployeeList::where('approve', 'Approved');


        // Determine filtering logic based on user's circle/division
        if ($circles && !$divisions) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::where('forest_circle_id', $circles)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        } elseif (!$circles && $divisions) {
            // Fetch employees in the same division
            $sameOfficeIds = User::where('forest_division_id', $divisions)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        }

        if ($division_id) {
            $same = User::where('forest_division_id', $division_id)->pluck('id');
            $employeeQuery->whereIn('created_by', $same);
        }

        // Retrieve the data
        $employeeList = $employeeQuery->get();


        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);


        foreach ($chunks as $index => $chunk) {
            $chunkReport = [];

            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthsDivisionDownload', compact('desig', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }


    public function downloadThreeMonthsMultiple(Request $request)
    {

        $division_id = $request->division_id;
        $district_id = $request->district_id;
        $designation_id = $request->designation_id;

        $divisions = ForestDivision::find($division_id);
        $districts = District::find($district_id);
        $designations = Designation::find($designation_id);

        $userId = Auth::id();

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $userDivision = $userInfo->forest_division_id;
        $userCircle = $userInfo->forest_circle_id;

        $employeeQuery = EmployeeList::where('approve', 'Approved');


        // Determine filtering logic based on user's circle/division
        if ($userCircle && !$userDivision) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::where('forest_circle_id', $userCircle)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        } elseif (!$userCircle && $userDivision) {
            // Fetch employees in the same division
            $sameOfficeIds = User::where('forest_division_id', $userDivision)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        }


        if ($division_id) {
            // Retrieve user IDs as a collection
            $same = User::select('id')
                ->where('forest_division_id', $division_id)
                ->pluck('id'); // Returns a collection of IDs

            // Apply 'whereIn' instead of 'where' for multiple IDs
            $employeeQuery->whereIn('created_by', $same);

            // Debug the query
            //dd($employeeQuery);
        }


        if ($district_id) {
            $employeeQuery->where('home_district_id', $district_id);
        }

        if ($designation_id) {
            $employeeQuery->where('designation_id', $designation_id);
        }

        $threeMonthsReport = [];
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        $employeeList = $employeeQuery->get();

        $chunkReport = [];
        $chunks = $employeeList->chunk(100);


        foreach ($chunks as $index => $chunk) {
            $chunkReport = [];

            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->examdegree->name_bn ?? '',
                        'education_name_en' => $education->examdegree->name_en ?? '',
                        'passing_year' => $education->passing_year ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }
        }

        // Generate the PDF
        $pdf = PDF::loadView('admin.employeeLists.threeMonthsMultipleDownload', compact('divisions', 'districts', 'designations', 'userId', 'chunkReport'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        // Return the PDF for download
        return $pdf->download('three_month_report.pdf');
    }








    public function seniority_list_report()
    {
        $designations = Designation::all();

        return view('admin.employeeLists.seniorityListReport', compact('designations'));
    }


    public function downloadSeniorityListDesignation(Request $request)
    {
        $designation_ids = $request->input('designation_id', []); // Retrieve multiple designation IDs as an array

        $seniorityListReport = [];

        // Fetch the selected designations
        $designations = Designation::whereIn('id', $designation_ids)->get();

        // Check if designation IDs are provided
        $employeeQuery = EmployeeList::where('approve', 'approved');
        if (!empty($designation_ids)) {
            $employeeQuery->whereIn('designation_id', $designation_ids); // Filter employees by multiple designation IDs
        }

        $employeeList = $employeeQuery->get();

        foreach ($employeeList as $employee) {

            $trainingNames = $employee->training_list->pluck('training_name')->toArray();
            $institutions = $employee->training_list->pluck('institute_name')->toArray();

            $trainingInfo = [];
            for ($i = 0; $i < count($trainingNames); $i++) {
                $trainingInfo[] = [
                    'training_name' => $trainingNames[$i],
                    'institute' => $institutions[$i] ?? '',
                ];
            }

            $seniorityListReport[] = [
                'employee_name_bn' => $employee->fullname_bn ?? '',
                'employee_name_en' => $employee->fullname_en ?? '',
                'designation_bn' => $employee->designation->name_bn ?? '',
                'designation_en' => $employee->designation->name_en ?? '',
                'fjoining_date' => $employee->fjoining_date ?? '',
                'dob' => $employee->date_of_birth ?? '',
                'home_district_bn' => $employee->home_district->name_bn ?? '',
                'home_district_en' => $employee->home_district->name_en ?? '',
                'revenue_id' => $employee->projectrevenue_id ?? '',
                'project_id' => $employee->project_id ?? '',
                'promotion_date' => $employee->promotion->go_issue_date ?? '',
                'regularization_date' => $employee->date_of_regularization ?? '',
                'training_info' => $trainingInfo,
                'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                'office_name' => $employee->jobhistory->level_2 ?? '',
                'joining_date' => $employee->jobhistory->joining_date ?? '',
                'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                'joining_type_bn' => $employee->projectrevenue->project_revenue_bn ?? '',
                'joining_type_en' => $employee->projectrevenue->project_revenue_en ?? '',
                'project_name_bn' => $employee->project->name_bn ?? '',
                'project_name_en' => $employee->project->name_en ?? '',
            ];
        }

        // Load the view into a PDF
        $pdf = PDF::loadView('admin.employeeLists.seniorityReportDesignation', compact('seniorityListReport', 'designations'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'landscape',
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);

        $fileName = date('Y-m-d') . 'seniorityListReport.pdf';

        // Stream the PDF
        return $pdf->stream($fileName);
    }

    public function downloadSeniorityListDesignationExcel(Request $request)
{
    $designation_ids = $request->input('designation_id', []);
    $seniorityListReport = [];

    $employeeQuery = EmployeeList::where('approve', 'approved');
    if (!empty($designation_ids)) {
        $employeeQuery->whereIn('designation_id', $designation_ids);
    }

    $employeeList = $employeeQuery->get();

    foreach ($employeeList as $employee) {
        $trainingNames = $employee->training_list->pluck('training_name')->toArray();

        $seniorityListReport[] = [
            'Employee Name (BN)' => $employee->fullname_bn ?? '',
            'Employee Name (EN)' => $employee->fullname_en ?? '',
            'Designation (BN)' => $employee->designation->name_bn ?? '',
            'Designation (EN)' => $employee->designation->name_en ?? '',
            'Date of Birth' => $employee->date_of_birth ?? '',
            'First Joining Date' => $employee->fjoining_date ?? '',
            'Promotion Date' => $employee->promotion->go_issue_date ?? '',
            'Regularization Date' => $employee->date_of_regularization ?? '',
            'Home District (BN)' => $employee->home_district->name_bn ?? '',
            'Home District (EN)' => $employee->home_district->name_en ?? '',
            'Project/Revenue Type (BN)' => $employee->projectrevenue->project_revenue_bn ?? '',
            'Project/Revenue Type (EN)' => $employee->projectrevenue->project_revenue_en ?? '',
            'Project Name (BN)' => $employee->project->name_bn ?? '',
            'Project Name (EN)' => $employee->project->name_en ?? '',
            'Training Names' => implode(', ', $trainingNames),
            'Circle (EN)' => $employee->jobhistory->circle_list->name_en ?? '',
            'Division (EN)' => $employee->jobhistory->division_list->name_en ?? '',
            'Range (EN)' => $employee->jobhistory->range_list->name_en ?? '',
            'Beat (EN)' => $employee->jobhistory->beat_list->name_en ?? '',
            'Current Office' => $employee->jobhistory->level_2 ?? '',
        ];
    }

    // Create a spreadsheet and fill with data
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headings
    if (!empty($seniorityListReport)) {
        $sheet->fromArray(array_keys($seniorityListReport[0]), NULL, 'A1');
        $sheet->fromArray($seniorityListReport, NULL, 'A2');
    }

    // Output the file as a download
    $writer = new Xlsx($spreadsheet);
    $fileName = 'seniority_list_' . date('Y-m-d') . '.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $fileName, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}





    public function seniority_list_report_download()
    {
        ini_set('max_execution_time', 1800); // 30 minutes
    ini_set('memory_limit', '1024M');
    set_time_limit(1800);
    ini_set('pcre.backtrack_limit', '10000000');

        $seniorityListReport = [];
        $employeeList = EmployeeList::where('approve', 'approved')->get();

        // Split employee list into chunks of 100
        $chunks = $employeeList->chunk(500);
        $zipFileName = 'seniorityListReports_' . date('Y-m-d') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
        $pdfPaths = [];

        // Iterate through chunks
        foreach ($chunks as $chunkIndex => $chunk) {
            $seniorityListReport = [];

            foreach ($chunk as $employee) {
                $trainingNames = $employee->training_list->pluck('training_name')->toArray();
                $institutions = $employee->training_list->pluck('institute_name')->toArray();

                $trainingInfo = [];
                for ($i = 0; $i < count($trainingNames); $i++) {
                    $trainingInfo[] = [
                        'training_name' => $trainingNames[$i],
                        'institute' => $institutions[$i] ?? '',
                    ];
                }

                $seniorityListReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'regularization_date' => $employee->date_of_regularization ?? '',
                    'training_info' => $trainingInfo,
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'joining_type_bn' => $employee->projectrevenue->project_revenue_bn ?? '',
                    'joining_type_en' => $employee->projectrevenue->project_revenue_en ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                ];
            }

            $seniorityListReport = collect($seniorityListReport); // FIX HERE


            // Generate a PDF for the current chunk
            $pdf = PDF::loadView('admin.employeeLists.seniorityListReportDownload', compact('seniorityListReport'), [], [
                'margin_top' => 20,
                'margin_bottom' => 15,
                'margin_left' => 18,
                'margin_right' => 18,
                'format' => 'A4',
                'orientation' => 'landscape',
                'default_font_size' => '15',
                'default_font' => 'nsikosh',
            ]);

            $pdfFileName = 'seniorityListReport_' . ($chunkIndex + 1) . '.pdf';
            $pdfPath = storage_path('app/public/' . $pdfFileName);
            $pdf->save($pdfPath);
            $pdfPaths[] = $pdfPath;
        }

        // Create a ZIP file containing all PDFs
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            foreach ($pdfPaths as $pdfPath) {
                $zip->addFile($pdfPath, basename($pdfPath));
            }
            $zip->close();
        }

        // Cleanup individual PDF files
        foreach ($pdfPaths as $pdfPath) {
            unlink($pdfPath);
        }

        // Return the ZIP file for download
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }







    public function downloadThreeMonthsReport()
    {
        $userId = Auth::id();
        $threeMonthsReport = [];

        // Fetch the user's info (forest_circle_id, forest_division_id)
        $userInfo = User::select('forest_circle_id', 'forest_division_id')
            ->where('id', $userId)
            ->first();

        $divisions = $userInfo->forest_division_id;
        $circles = $userInfo->forest_circle_id;
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        // Fetch employee data based on circle/division (No pagination)
        if ($circles !== null && $divisions == null) {
            // Fetch employees in the same circle
            $sameOfficeIds = User::select('id')
                ->where('forest_circle_id', $circles)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved')
                ->get();  // Get all records, no pagination
        } elseif ($circles == null && $divisions !== null) {
            // Fetch employees in the same division
            $sameOfficeIds = User::select('id')
                ->where('forest_division_id', $divisions)
                ->pluck('id');
            $employeeList = EmployeeList::whereIn('created_by', $sameOfficeIds)
                ->where('approve', 'Approved')
                ->get();  // Get all records, no pagination
        } else {
            // Fetch all employees approved
            $employeeList = EmployeeList::where('approve', 'approved')->get();  // Get all records, no pagination
        }

        // Split the employee list into chunks of 100
        $chunks = $employeeList->chunk(100);

        // Process each chunk and generate a PDF
        $pdfs = [];

        foreach ($chunks as $index => $chunk) {
            $chunkReport = [];

            foreach ($chunk as $employee) {
                $jobHistories = [];
                $trainingHistories = [];
                $educationHistories = [];
                $mamlaHistories = [];

                // Process job histories
                foreach ($employee->allJob as $job) {
                    $workPlace_bn = '';
                    $workPlace_en = '';

                    if ($job->circle_list_id !== null && $job->division_list_id == null) {
                        $workPlace_bn = $job->circle_list->name_bn ?? '';
                        $workPlace_en = $job->circle_list->name_en ?? '';
                    } elseif ($job->division_list_id !== null && $job->circle_list_id !== null) {
                        $workPlace_bn = $job->division_list->name_bn ?? '';
                        $workPlace_en = $job->division_list->name_en ?? '';
                    } elseif ($job->level_2 !== null) {
                        $workPlace_bn = $job->level_2 ?? '';
                        $workPlace_en = $job->level_2 ?? '';
                    } elseif ($job->academy_type !== null) {
                        $workPlace_bn = $job->academy_type ?? '';
                        $workPlace_en = $job->academy_type ?? '';
                    } else {
                        $workPlace_bn = $job->institutename ?? '';
                        $workPlace_en = $job->institutename ?? '';
                    }

                    $jobHistories[] = [
                        'work_place_bn' => $workPlace_bn,
                        'work_place_en' => $workPlace_en,
                        'start_date' => $job->joining_date ?? '',
                        'end_date' => $job->release_date ?? '',
                    ];
                }

                // Process training histories
                foreach ($employee->training_list as $training) {
                    $trainingHistories[] = [
                        'training_name' => $training->training_name ?? '',
                    ];
                }

                // Process education histories
                foreach ($employee->educationHistory as $education) {
                    $educationHistories[] = [
                        'education_name_bn' => $education->name_of_exam->name_bn ?? '',
                        'education_name_en' => $education->name_of_exam->name_en ?? '',
                        'board_name_bn' => $education->exam_board->name_bn ?? '',
                        'board_name_en' => $education->exam_board->name_en ?? '',
                    ];
                }

                // Process mamla histories
                foreach ($employee->mamlaHistory as $mamla) {
                    $mamlaHistories[] = [
                        'mamla_name_bn' => $mamla->name_bn ?? '',
                        'mamla_name_en' => $mamla->name_en ?? '',
                        'mamla_start' => $mamla->mamla_start ?? '',
                        'mamla_end' => $mamla->mamla_end ?? '',
                        'comment' => $mamla->remzrk ?? '',
                    ];
                }

                // Calculate total job duration
                $totalDuration = Carbon::now()->diff(Carbon::createFromFormat('d/m/Y', $employee->fjoining_date));

                $total_job_bn = sprintf('%d বছর, %d মাস, %d দিন', $totalDuration->y, $totalDuration->m, $totalDuration->d);
                $total_job_en = sprintf('%d years, %d months, %d days', $totalDuration->y, $totalDuration->m, $totalDuration->d);

                // Add all the details to the chunk report
                $chunkReport[] = [
                    'employee_name_bn' => $employee->fullname_bn ?? '',
                    'employee_name_en' => $employee->fullname_en ?? '',
                    'designation_bn' => $employee->designation->name_bn ?? '',
                    'designation_en' => $employee->designation->name_en ?? '',
                    'grade_bn' => $employee->grade->name_bn ?? '',
                    'grade_en' => $employee->grade->name_en ?? '',
                    'promotion_grade_bn' => $employee->promotion->grade->name_bn ?? '',
                    'promotion_grade_en' => $employee->promotion->grade->name_en ?? '',
                    'dob' => $employee->date_of_birth ?? '',
                    'home_district_bn' => $employee->home_district->name_bn ?? '',
                    'home_district_en' => $employee->home_district->name_en ?? '',
                    'gender_bn' => $employee->gender->name_bn ?? '',
                    'gender_en' => $employee->gender->name_en ?? '',
                    'permanent_address_bn' => $employee->permanent->thana_upazila->name_bn ?? '',
                    'permanent_village' => $employee->permanent->flat_house ?? '',
                    'permanent_post' => $employee->permanent->post_office ?? '',
                    'permanent_district_bn' => $employee->permanent->thana_upazila->district->name_bn ?? '',
                    'permanent_district_en' => $employee->permanent->thana_upazila->district->name_en ?? '',
                    'permanent_address_en' => $employee->permanent->thana_upazila->name_en ?? '',
                    'present_address_bn' => $employee->present->thana_upazila->name_bn ?? '',
                    'present_village' => $employee->present->flat_house ?? '',
                    'present_post' => $employee->present->post_office ?? '',
                    'present_district_bn' => $employee->present->thana_upazila->district->name_bn ?? '',
                    'present_district_en' => $employee->present->thana_upazila->district->name_en ?? '',
                    'present_address_en' => $employee->present->thana_upazila->name_en ?? '',
                    'fjoining_date' => $employee->fjoining_date ?? '',
                    'promotion_date' => $employee->promotion->go_issue_date ?? '',
                    'circle_name_bn' => $employee->jobhistory->circle_list->name_bn ?? '',
                    'circle_name_en' => $employee->jobhistory->circle_list->name_en ?? '',
                    'office_name' => $employee->jobhistory->level_2 ?? '',
                    'joining_date' => $employee->jobhistory->joining_date ?? '',
                    'division_name_bn' => $employee->jobhistory->division_list->name_bn ?? '',
                    'division_name_en' => $employee->jobhistory->division_list->name_en ?? '',
                    'range_name_bn' => $employee->jobhistory->range_list->name_bn ?? '',
                    'range_name_en' => $employee->jobhistory->range_list->name_en ?? '',
                    'beat_name_bn' => $employee->jobhistory->beat_list->name_bn ?? '',
                    'beat_name_en' => $employee->jobhistory->beat_list->name_en ?? '',
                    'revenue_id' => $employee->projectrevenue_id ?? '',
                    'project_id' => $employee->project_id ?? '',
                    'project_name_bn' => $employee->project->name_bn ?? '',
                    'project_name_en' => $employee->project->name_en ?? '',
                    'job_histories' => $jobHistories,
                    'total_job_bn' => $total_job_bn,
                    'total_job_en' => $total_job_en,
                    'quota_bn' => $employee->quota->name_bn ?? '',
                    'quota_en' => $employee->quota->name_en ?? '',
                    'relation_bn' => $employee->freedomfighter->name_bn ?? '',
                    'relation_en' => $employee->freedomfighter->name_en ?? '',
                    'fighter_name' => $employee->freedomfighter_name ?? '',
                    'fighter_address' => $employee->freedomfighter_address ?? '',
                    'fighter_number' => $employee->freedomfighter_go ?? '',
                    'training_histories' => $trainingHistories,
                    'education_histories' => $educationHistories,
                    'mamla_histories' => $mamlaHistories,
                    'prl_date' => $employee->prl_date ?? '',
                ];
            }

            // Generate the PDF for the chunk
            $pdf = PDF::loadView('admin.employeeLists.threeMonthsReportDownload', compact('userId', 'chunkReport'), [], [
                'margin_top' => 20,
                'margin_bottom' => 15,
                'margin_left' => 18,
                'margin_right' => 18,
                'format' => 'A4',
                'orientation' => 'landscape',
                'default_font_size' => '15',
                'default_font' => 'nsikosh',
            ]);

            // Store the PDF in the $pdfs array
            $pdfs[] = $pdf;
        }

        // Zip and return all PDFs (optional for better handling)
        $zipFile = storage_path('app/reports.zip');
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE) === true) {
            foreach ($pdfs as $index => $pdf) {
                $pdfPath = storage_path("app/three_month_report_{$index}.pdf");
                $pdf->save($pdfPath);
                $zip->addFile($pdfPath, "three_month_report_{$index}.pdf");
            }
            $zip->close();
        }

        // Return the ZIP file for download
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }










    public function create()
    {
        // $dd= EmployeeList::generateEmployeeid('3rd');
        // dd($dd);
        $locale = App::getLocale();
        $batchColumn = $locale === 'bn' ? 'batch_bn' : 'batch_en';
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $project_revenue_bn = $locale === 'bn' ? 'project_revenue_bn' : 'project_revenue_en';
        $exam_name_bn = $locale === 'bn' ? 'exam_name_bn' : 'exam_name_en';
        $maritialstatus = $locale === 'bn' ? 'name' : 'name_en';

        abort_if(Gate::denies('employee_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck($batchColumn, 'id')->prepend(trans('global.pleaseSelect'), '');
        $home_districts = District::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $marital_status = Maritalstatus::pluck($maritialstatus, 'id')->prepend(trans('global.pleaseSelect'), '');

        $genders = Gender::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $religions = Religion::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $blood_groups = BloodGroup::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $license_types = LicenseType::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $projectrevenues = Joininginfo::pluck($project_revenue_bn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $joiningexaminfos = ProjectRevenueExam::pluck($exam_name_bn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $departmental_exams = ProjectRevenuelone::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $quotas = Quotum::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $freedomfighters = FreedomFighteRelation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employeeLists.create', compact('designations', 'batches', 'blood_groups', 'departmental_exams', 'freedomfighters', 'genders', 'grades', 'home_districts', 'joiningexaminfos', 'license_types', 'marital_status', 'projectrevenues', 'projects', 'quotas', 'religions'));
    }

    public function store(StoreEmployeeListRequest $request)
    {
        //    dd($request->all());

        if ($request->religion_name_bn) {
            $insearrid = Religion::create([
                'name_bn' => $request->religion_name_bn,
                'name_en' => $request->religion_name_en,
            ]);
            $request->merge(['religion_id' => $insearrid->id]);
        }

        //$employeeList = EmployeeList::create($request->all());

        $class = $request->input('class');

        // Generate the employee ID
        $employeeId = EmployeeList::generateEmployeeId($class);

        // Create the employee with the generated ID
        $employeeData = $request->all();
        $employeeData['employeeid'] = $employeeId;
        $employeeData['created_by'] = auth()->id();

        $employeeList = EmployeeList::create($employeeData);

        if ($request->input('birth_certificate_upload', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('birth_certificate_upload'))))->toMediaCollection('birth_certificate_upload');
        }

        if ($request->input('nid_upload', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('nid_upload'))))->toMediaCollection('nid_upload');
        }

        if ($request->input('passport_upload', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('passport_upload'))))->toMediaCollection('passport_upload');
        }

        if ($request->input('license_upload', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('license_upload'))))->toMediaCollection('license_upload');
        }

        if ($request->input('certificate_upload', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('certificate_upload'))))->toMediaCollection('certificate_upload');
        }

        if ($request->input('first_joining_order', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('first_joining_order'))))->toMediaCollection('first_joining_order');
        }

        if ($request->input('fjoining_letter', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('fjoining_letter'))))->toMediaCollection('fjoining_letter');
        }

        if ($request->input('transfer_order', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('transfer_order'))))->toMediaCollection('transfer_order');
        }

        if ($request->input('date_of_gazette_if_any', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('date_of_gazette_if_any'))))->toMediaCollection('date_of_gazette_if_any');
        }

        if ($request->input('ptr_upload', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('ptr_upload'))))->toMediaCollection('ptr_upload');
        }

        if ($request->input('regularization_office_orde_go', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('regularization_office_orde_go'))))->toMediaCollection('regularization_office_orde_go');
        }

        if ($request->input('confirmation_in_service', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('confirmation_in_service'))))->toMediaCollection('confirmation_in_service');
        }

        if ($request->input('electric_signature', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('electric_signature'))))->toMediaCollection('electric_signature');
        }

        if ($request->input('employee_photo', false)) {
            $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('employee_photo'))))->toMediaCollection('employee_photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $employeeList->id]);
        }

        return redirect()->route('admin.employee-lists.index')->with('status', __('global.saveactions'));
    }

    public function edit(EmployeeList $employeeList)
    {

        // /dd($employeeList);
        $locale = App::getLocale();
        $batchColumn = $locale === 'bn' ? 'batch_bn' : 'batch_en';
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $project_revenue_bn = $locale === 'bn' ? 'project_revenue_bn' : 'project_revenue_en';
        $exam_name_bn = $locale === 'bn' ? 'exam_name_bn' : 'exam_name_en';
        $maritialstatus = $locale === 'bn' ? 'name' : 'name_en';

        abort_if(Gate::denies('employee_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck($batchColumn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $home_districts = District::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $marital_status = Maritalstatus::pluck($maritialstatus, 'id')->prepend(trans('global.pleaseSelect'), '');

        $genders = Gender::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $religions = Religion::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $blood_groups = BloodGroup::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $license_types = LicenseType::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $projectrevenues = Joininginfo::pluck($project_revenue_bn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $joiningexaminfos = ProjectRevenueExam::pluck($exam_name_bn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $departmental_exams = ProjectRevenuelone::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $quotas = Quotum::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');


        $freedomfighters = FreedomFighteRelation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $employeeList->load('batch', 'home_district', 'marital_statu', 'gender', 'religion', 'blood_group', 'license_type', 'projectrevenue', 'joiningexaminfo', 'departmental_exam', 'project', 'grade', 'quota', 'freedomfighter');

        return view('admin.employeeLists.edit', compact('designations', 'batches', 'blood_groups', 'departmental_exams', 'employeeList', 'freedomfighters', 'genders', 'grades', 'home_districts', 'joiningexaminfos', 'license_types', 'marital_status', 'projectrevenues', 'projects', 'quotas', 'religions'));
    }

    public function update(UpdateEmployeeListRequest $request, EmployeeList $employeeList)
    {
        dd($request->all());
        $employeeList->update($request->all());

        if ($request->input('birth_certificate_upload', false)) {
            if (!$employeeList->birth_certificate_upload || $request->input('birth_certificate_upload') !== $employeeList->birth_certificate_upload->file_name) {
                if ($employeeList->birth_certificate_upload) {
                    $employeeList->birth_certificate_upload->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('birth_certificate_upload'))))->toMediaCollection('birth_certificate_upload');
            }
        } elseif ($employeeList->birth_certificate_upload) {
            $employeeList->birth_certificate_upload->delete();
        }

        if ($request->input('nid_upload', false)) {
            if (!$employeeList->nid_upload || $request->input('nid_upload') !== $employeeList->nid_upload->file_name) {
                if ($employeeList->nid_upload) {
                    $employeeList->nid_upload->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('nid_upload'))))->toMediaCollection('nid_upload');
            }
        } elseif ($employeeList->nid_upload) {
            $employeeList->nid_upload->delete();
        }

        if ($request->input('passport_upload', false)) {
            if (!$employeeList->passport_upload || $request->input('passport_upload') !== $employeeList->passport_upload->file_name) {
                if ($employeeList->passport_upload) {
                    $employeeList->passport_upload->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('passport_upload'))))->toMediaCollection('passport_upload');
            }
        } elseif ($employeeList->passport_upload) {
            $employeeList->passport_upload->delete();
        }

        if ($request->input('license_upload', false)) {
            if (!$employeeList->license_upload || $request->input('license_upload') !== $employeeList->license_upload->file_name) {
                if ($employeeList->license_upload) {
                    $employeeList->license_upload->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('license_upload'))))->toMediaCollection('license_upload');
            }
        } elseif ($employeeList->license_upload) {
            $employeeList->license_upload->delete();
        }

        if ($request->input('certificate_upload', false)) {
            if (!$employeeList->certificate_upload || $request->input('certificate_upload') !== $employeeList->certificate_upload->file_name) {
                if ($employeeList->certificate_upload) {
                    $employeeList->certificate_upload->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('certificate_upload'))))->toMediaCollection('certificate_upload');
            }
        } elseif ($employeeList->certificate_upload) {
            $employeeList->certificate_upload->delete();
        }

        if ($request->input('first_joining_order', false)) {
            if (!$employeeList->first_joining_order || $request->input('first_joining_order') !== $employeeList->first_joining_order->file_name) {
                if ($employeeList->first_joining_order) {
                    $employeeList->first_joining_order->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('first_joining_order'))))->toMediaCollection('first_joining_order');
            }
        } elseif ($employeeList->first_joining_order) {
            $employeeList->first_joining_order->delete();
        }

        if ($request->input('fjoining_letter', false)) {
            if (!$employeeList->fjoining_letter || $request->input('fjoining_letter') !== $employeeList->fjoining_letter->file_name) {
                if ($employeeList->fjoining_letter) {
                    $employeeList->fjoining_letter->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('fjoining_letter'))))->toMediaCollection('fjoining_letter');
            }
        } elseif ($employeeList->fjoining_letter) {
            $employeeList->fjoining_letter->delete();
        }

        if ($request->input('date_of_gazette_if_any', false)) {
            if (!$employeeList->date_of_gazette_if_any || $request->input('date_of_gazette_if_any') !== $employeeList->date_of_gazette_if_any->file_name) {
                if ($employeeList->date_of_gazette_if_any) {
                    $employeeList->date_of_gazette_if_any->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('date_of_gazette_if_any'))))->toMediaCollection('date_of_gazette_if_any');
            }
        } elseif ($employeeList->date_of_gazette_if_any) {
            $employeeList->date_of_gazette_if_any->delete();
        }

        if ($request->input('ptr_upload', false)) {
            if (!$employeeList->ptr_upload || $request->input('ptr_upload') !== $employeeList->ptr_upload->file_name) {
                if ($employeeList->ptr_upload) {
                    $employeeList->ptr_upload->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('ptr_upload'))))->toMediaCollection('ptr_upload');
            }
        } elseif ($employeeList->ptr_upload) {
            $employeeList->ptr_upload->delete();
        }

        if ($request->input('regularization_office_orde_go', false)) {
            if (!$employeeList->regularization_office_orde_go || $request->input('regularization_office_orde_go') !== $employeeList->regularization_office_orde_go->file_name) {
                if ($employeeList->regularization_office_orde_go) {
                    $employeeList->regularization_office_orde_go->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('regularization_office_orde_go'))))->toMediaCollection('regularization_office_orde_go');
            }
        } elseif ($employeeList->regularization_office_orde_go) {
            $employeeList->regularization_office_orde_go->delete();
        }

        if ($request->input('confirmation_in_service', false)) {
            if (!$employeeList->confirmation_in_service || $request->input('confirmation_in_service') !== $employeeList->confirmation_in_service->file_name) {
                if ($employeeList->confirmation_in_service) {
                    $employeeList->confirmation_in_service->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('confirmation_in_service'))))->toMediaCollection('confirmation_in_service');
            }
        } elseif ($employeeList->confirmation_in_service) {
            $employeeList->confirmation_in_service->delete();
        }

        if ($request->input('electric_signature', false)) {
            if (!$employeeList->electric_signature || $request->input('electric_signature') !== $employeeList->electric_signature->file_name) {
                if ($employeeList->electric_signature) {
                    $employeeList->electric_signature->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('electric_signature'))))->toMediaCollection('electric_signature');
            }
        } elseif ($employeeList->electric_signature) {
            $employeeList->electric_signature->delete();
        }

        if ($request->input('employee_photo', false)) {
            if (!$employeeList->employee_photo || $request->input('employee_photo') !== $employeeList->employee_photo->file_name) {
                if ($employeeList->employee_photo) {
                    $employeeList->employee_photo->delete();
                }
                $employeeList->addMedia(storage_path('tmp/uploads/' . basename($request->input('employee_photo'))))->toMediaCollection('employee_photo');
            }
        } elseif ($employeeList->employee_photo) {
            $employeeList->employee_photo->delete();
        }

        return redirect()->route('admin.employee-lists.index')->with('status', __('global.updateAction'));
    }

    public function show(EmployeeList $employeeList)
    {
        abort_if(Gate::denies('employee_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeList->load('batch', 'home_district', 'marital_statu', 'gender', 'religion', 'blood_group', 'license_type', 'projectrevenue', 'joiningexaminfo', 'departmental_exam', 'project', 'grade', 'quota', 'freedomfighter');

        return view('admin.employeeLists.show', compact('employeeList'));
    }

    public function destroy(EmployeeList $employeeList)
    {
        abort_if(Gate::denies('employee_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeList->delete();

        return back();
    }





    public function approve($id)
    {
        $employee = EmployeeList::find($id);

        if ($employee) {
            $employee->approve = 'Approved';
            $employee->approveby = Auth::id();
            $employee->save();


            return redirect()->back()->with('success', 'অনুমোদনটি সফলভাবে সম্পন্ন হয়েছে।');
        }


        return redirect()->back()->with('error', 'অনুগ্রহপূর্বক আবার চেষ্টা করুন');
    }

    public function send($id)
    {
        $employee = EmployeeList::find($id);
        // dd($employee);

        if ($employee) {
            $employee->approve = 'pending';
            $employee->save();


            return redirect()->back()->with('success', 'তথ্যট অনুমোদনের জন্য পাঠানো হয়েছে।');
        }


        return redirect()->back()->with('error', 'অনুগ্রহপূর্বক আবার চেষ্টা করুন');
    }


    public function massDestroy(MassDestroyEmployeeListRequest $request)
    {
        $employeeLists = EmployeeList::find(request('ids'));

        foreach ($employeeLists as $employeeList) {
            $employeeList->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_list_create') && Gate::denies('employee_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new EmployeeList();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    public function Commonemployeecreate()
    {

        $locale = App::getLocale();
        $batchColumn = $locale === 'bn' ? 'batch_bn' : 'batch_en';
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $project_revenue_bn = $locale === 'bn' ? 'project_revenue_bn' : 'project_revenue_en';
        $exam_name_bn = $locale === 'bn' ? 'exam_name_bn' : 'exam_name_en';

        abort_if(Gate::denies('employee_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck($batchColumn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $home_districts = District::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $marital_status = Maritalstatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $genders = Gender::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $religions = Religion::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $blood_groups = BloodGroup::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $license_types = LicenseType::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $joiningexaminfos = ProjectRevenueExam::pluck($exam_name_bn, 'id')->prepend(trans('global.pleaseSelect'), '');

        $name_of_exams = Examination::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $exam_boards = ExamBoard::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');


        $job_types = JobType::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $new_designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $designations = Designation::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $grades = Grade::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $quotas = Quotum::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $thana_upazilas = Upazila::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('admin.commonemployee.create', compact('new_designations', 'designations', 'job_types', 'thana_upazilas', 'batches', 'blood_groups', 'genders', 'grades', 'home_districts', 'joiningexaminfos', 'license_types', 'marital_status', 'quotas', 'religions', 'employees', 'exam_boards', 'name_of_exams'));
    }


    public function commonemployeeshow(Request $request)
    {


        //EmployeeList $employeeList

        abort_if(Gate::denies('employee_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employeeList = EmployeeList::findOrFail($request->id);

        $employeeList->load('batch', 'home_district', 'marital_statu', 'gender', 'religion', 'blood_group', 'license_type', 'joiningexaminfo', 'grade', 'quota');

        return view('admin.employeeLists.showcommonenployee', compact('employeeList'));
    }


    public function employeedata_pdf(Request $request)
    {

        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        $deucationDegree = ExamDegree::all();
        $employeeList = EmployeeList::with([
            'batch',
            'home_district',
            'marital_statu',
            'gender',
            'religion',
            'blood_group',
            'license_type',
            'joiningexaminfo',
            'grade',
            'quota',
            // Load educations and sort them by ID in ascending order
            'educations' => function ($query) {
                $query->orderBy('id', 'asc'); // Adjust 'id' to the appropriate column if needed
            },
            'trainings' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'professionales' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'addressdetailes' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'emergencecontactes' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'jobhistories' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'employeepromotions' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'leaverecords' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'travelRecords' => function ($query) {
                $query->orderBy('id', 'asc');
            },
        ])->find($request->id);

        if (!$employeeList) {
            abort(404);
        }


        //return view('admin.employeeLists.pdf', compact('employeeList', 'columname', 'deucationDegree'));


        $pdf = PDF::loadView('admin.employeeLists.pdf', compact('employeeList', 'columname', 'deucationDegree'), [], [
            'margin_top' => 20,
            'margin_bottom' => 15,
            'margin_left' => 18,
            'margin_right' => 18,
            'format' => 'A4',
            'orientation' => 'portrait',  // Added orientation option
            'default_font_size' => '15',
            'default_font' => 'nsikosh',
        ]);





        $name = $employeeList->employeeid . '_' . $employeeList->fullname_en . '_employee.pdf';
        //return $pdf->download($name);
        return $pdf->stream($name);

    }
    public function employeedata(Request $request)
    {
        // Load employee data along with related models, including educations
        $employeeList = EmployeeList::with([
            'batch',
            'home_district',
            'marital_statu',
            'gender',
            'religion',
            'blood_group',
            'license_type',
            'joiningexaminfo',
            'grade',
            'quota',
            // Load educations and sort them by ID in ascending order
            'educations' => function ($query) {
                $query->orderBy('id', 'asc'); // Adjust 'id' to the appropriate column if needed
            },
            'trainings' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'professionales' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'addressdetailes' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'emergencecontactes' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'jobhistories' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'employeepromotions' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'leaverecords' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'travelRecords' => function ($query) {
                $query->orderBy('id', 'asc');
            },
        ])->find($request->id);

        // Check if employeeList is found
        if (!$employeeList) {
            return redirect()->route('admin.employeeLists.index')->with('error', 'Employee not found.');
        }

        return view('admin.employeeLists.employeedata', compact('employeeList'));
    }


    public function upcoming_retirement_list()
    {
        // Retrieve filters from session or set defaults
        $start_date = Session::get('start_date', now()->toDateString());
        $end_date = Session::get('end_date', now()->addMonths(3)->toDateString());
        $designation_id = Session::get('designation_id');
        $division_id = Session::get('division_id');
        $circle_id = Session::get('circle_id');

        // Get authenticated user info
        $userId = Auth::id();
        $userInfo = User::select('forest_circle_id', 'forest_division_id')->find($userId);

        // Build employee query
        $employeeQuery = EmployeeList::where('approve', 'Approved');

        // Apply filters
        if ($designation_id) {
            $employeeQuery->where('designation_id', $designation_id);
        }
        if ($division_id || $circle_id) {
            $sameOfficeIds = User::when($division_id, fn($query) => $query->where('forest_division_id', $division_id))
                                 ->when($circle_id, fn($query) => $query->orWhere('forest_circle_id', $circle_id))
                                 ->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        }

        // Additional filtering based on user circle/division
        if ($userInfo->forest_circle_id && !$userInfo->forest_division_id) {
            $sameOfficeIds = User::where('forest_circle_id', $userInfo->forest_circle_id)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        } elseif (!$userInfo->forest_circle_id && $userInfo->forest_division_id) {
            $sameOfficeIds = User::where('forest_division_id', $userInfo->forest_division_id)->pluck('id');
            $employeeQuery->whereIn('created_by', $sameOfficeIds);
        }

        // Apply date range and fetch results
        $employeeList = (clone $employeeQuery)->whereBetween('prl_date', [$start_date, $end_date])
                                              ->orderBy('prl_date', 'asc')
                                              ->paginate(10);

        $data = $employeeQuery->whereBetween('prl_date', [$start_date, $end_date])->count();
        $designations = Designation::all();
        $forest_divisions = ForestDivision::all();
        $forest_circles = ForestState::all();

        return view('admin.retirement.index', compact('employeeList', 'forest_divisions', 'forest_circles', 'data', 'designations'));
    }


    public function search_retirement(Request $request)
    {
        // Parse the start and end dates from the form (assuming dd/mm/yyyy format)
        $start_date = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');
        $designation_id = $request->input('designation_id');
        $division_id = $request->input('division_id');
        $circle_id = $request->input('circle_id');

        // Store the dates in the session
        Session::put([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'designation_id' => $designation_id,
            'circle_id' => $circle_id,
            'division_id' => $division_id
        ]);

        // Redirect to the upcoming retirement list
        return redirect()->route('admin.upcoming_retirement_list');
    }

    public function entry_list()
    {
        $employeeQuery = EmployeeList::with(['approve_user.circle', 'approve_user.division'])
        ->select('approveby', \DB::raw('COUNT(*) as count'))
        ->where('approve', 'Approved')
        ->groupBy('approveby')
        ->get();

        // Calculate the total count
        $totalCount = $employeeQuery->sum('count');

        return view('admin.employeeLists.entryList', compact('employeeQuery', 'totalCount'));

    }

    public function employeedata_delete($id)
    {
        $employee = EmployeeList::find($id);

        if ($employee) {
            $employee->update([
                'deleted_at' => now(),
            ]);
            return redirect()->back()->with('success', 'তথ্যটি সফলভাবে মুছে ফেলা হয়েছে।');
        }

        return redirect()->back()->with('error', 'অনুগ্রহপূর্বক আবার চেষ্টা করুন');
    }

    public function pendingChange()
    {
        $pendingQuery = Editlog::with(['employee', 'user']);

        $userId = Auth::id();
        $userInfo = User::select('forest_circle_id', 'forest_division_id')->find($userId);

        // Additional filtering based on user circle/division
        if ($userInfo->forest_circle_id && !$userInfo->forest_division_id) {
            $sameOfficeIds = User::where('forest_circle_id', $userInfo->forest_circle_id)->pluck('id');
            $pendingQuery->whereIn('edit_by', $sameOfficeIds);
        } elseif (!$userInfo->forest_circle_id && $userInfo->forest_division_id) {
            $sameOfficeIds = User::where('forest_division_id', $userInfo->forest_division_id)->pluck('id');
            $pendingQuery->whereIn('edit_by', $sameOfficeIds);
        }


        $pendingChange = Editlog::orderBy('id', 'desc')
            ->where('status', 0)
            ->paginate(20);

        return view('admin.employeeLists.pending-change', compact('pendingChange'));
    }

    public function approveMultiple(Request $request)
    {
        $ids = $request->input('changes', []);

        $editLogs = Editlog::whereIn('id', $ids)->get();

        foreach ($editLogs as $log) {
            $modelClass = $log->form_model;

            if ($modelClass && $log->field && $log->data_id && class_exists($modelClass)) {
                $record = $modelClass::find($log->data_id);

                if ($record && isset($record->{$log->field})) {
                    // Update the target field with the new content
                    $record->{$log->field} = $log->content;
                    $record->save();
                }
            }

            // Mark the change as approved
            $log->status = 1;
            $log->save();
        }

        return redirect()->back()->with('success', 'Selected changes have been approved and applied.');
    }








}
