<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEducationInformationeRequest;
use App\Http\Requests\StoreEducationInformationeRequest;
use App\Http\Requests\UpdateEducationInformationeRequest;
use App\Models\AchievementschoolsUniversity;
use App\Models\EducationInformatione;
use App\Models\EmployeeList;
use App\Models\ExamBoard;
use App\Models\Examination;
use App\Models\ExamDegree;
use App\Models\Result;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EducationInformationeController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('education_informatione_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
				// Fetch the same office IDs based on the circles
				$sameOfficeIds = User::select('id')
					->where('forest_circle_id', $circles)
					->pluck('id');
					
				$query = EducationInformatione::with(['name_of_exam', 'exam_board', 'result', 'achievement_types', 'employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new EducationInformatione)->table));

			}elseif ($circles == null && $divisions !== null) {
				// Fetch the same office IDs based on the circles
				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');
					
				$query = EducationInformatione::with(['name_of_exam', 'exam_board', 'result', 'achievement_types', 'employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new EducationInformatione)->table));

			}else{
				$query = EducationInformatione::with(['name_of_exam', 'exam_board', 'result', 'achievement_types', 'employee'])
					->select(sprintf('%s.*', (new EducationInformatione)->table));
			}
			
			$table = Datatables::of($query);


            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'education_informatione_show';
                $editGate = 'education_informatione_edit';
                $deleteGate = 'education_informatione_delete';
                $crudRoutePart = 'education-informationes';

                return view(
                    'partials.datatablesActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            $table->addColumn('name_of_exam_name_bn', function ($row) {
                return $row->name_of_exam ? $row->name_of_exam->name_bn : '';
            });
			
			$table->addColumn('exam_degree', function ($row) {
                return $row->exam_degree ? $row->examdegree->name_bn : '';
            });

            $table->addColumn('exam_board_name_bn', function ($row) {
                return $row->exam_board ? $row->exam_board->name_bn : '';
            });

            $table->editColumn('concentration_major_group', function ($row) {
                return $row->concentration_major_group ? $row->concentration_major_group : '';
            });
            $table->editColumn('school_university_name', function ($row) {
                return $row->school_university_name ? $row->school_university_name : '';
            });
            $table->addColumn('result_name_bn', function ($row) {
                return $row->result ? $row->result->name_bn : '';
            });

            $table->editColumn('passing_year', function ($row) {
                return $row->passing_year ? englishToBanglaNumber($row->passing_year) : '';
            });
            $table->addColumn('achievement_types_name_bn', function ($row) {
                return $row->achievement_types ? $row->achievement_types->name_bn : '';
            });

            $table->editColumn('achievement_types.name_en', function ($row) {
                return $row->achievement_types ? (is_string($row->achievement_types) ? $row->achievement_types : $row->achievement_types->name_en) : '';
            });
            $table->editColumn('achivement', function ($row) {
                return $row->achivement ? $row->achivement : '';
            });
            $table->editColumn('catificarte', function ($row) {
                return $row->catificarte ? '<a href="' . $row->catificarte->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? englishToBanglaNumber($row->employee->employeeid) : '';
            });

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : '';
            });
            
            $table->editColumn('cgpa', function ($row) {
                return $row->cgpa ? englishToBanglaNumber($row->cgpa) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'name_of_exam', 'exam_board', 'result', 'achievement_types', 'catificarte', 'employee']);

            return $table->make(true);
        }

        return view('admin.educationInformationes.index');
    }

    public function create(Request $request)
    {
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';

        abort_if(Gate::denies('education_informatione_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);
        $name_of_exams = Examination::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $exam_boards = ExamBoard::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $results = Result::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $achievement_types = AchievementschoolsUniversity::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.educationInformationes.create', compact('achievement_types', 'employees', 'exam_boards', 'name_of_exams', 'results', 'employee'));
    }


    public function store(StoreEducationInformationeRequest $request)
    {
        $educationInformatione = EducationInformatione::create($request->all());

        if ($request->input('catificarte', false)) {
            $educationInformatione->addMedia(storage_path('tmp/uploads/' . basename($request->input('catificarte'))))->toMediaCollection('catificarte');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $educationInformatione->id]);
        }

        return redirect()->back()->with('status', __('global.saveactions'));
    }

    public function edit(EducationInformatione $educationInformatione)
    {
        $locale = App::getLocale();
        $columname = $locale === 'bn' ? 'name_bn' : 'name_en';
        abort_if(Gate::denies('education_informatione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $name_of_exams = Examination::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');
		
		$name_of_degrees = ExamDegree::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');


        $exam_boards = ExamBoard::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $results = Result::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $achievement_types = AchievementschoolsUniversity::pluck($columname, 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $educationInformatione->load('name_of_exam', 'exam_board', 'result', 'achievement_types', 'employee');

        return view('admin.educationInformationes.edit', compact('name_of_degrees','achievement_types', 'educationInformatione', 'employees', 'exam_boards', 'name_of_exams', 'results'));
    }

    public function update(UpdateEducationInformationeRequest $request, EducationInformatione $educationInformatione)
    {
        $educationInformatione->update($request->all());

        if ($request->input('catificarte', false)) {
            if (!$educationInformatione->catificarte || $request->input('catificarte') !== $educationInformatione->catificarte->file_name) {
                if ($educationInformatione->catificarte) {
                    $educationInformatione->catificarte->delete();
                }
                $educationInformatione->addMedia(storage_path('tmp/uploads/' . basename($request->input('catificarte'))))->toMediaCollection('catificarte');
            }
        } elseif ($educationInformatione->catificarte) {
            $educationInformatione->catificarte->delete();
        }

        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(EducationInformatione $educationInformatione)
    {
        abort_if(Gate::denies('education_informatione_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $educationInformatione->load('name_of_exam', 'exam_board', 'result', 'achievement_types', 'employee');

        return view('admin.educationInformationes.show', compact('educationInformatione'));
    }

    public function destroy(EducationInformatione $educationInformatione)
    {
        abort_if(Gate::denies('education_informatione_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $educationInformatione->delete();

        return back();
    }

    public function massDestroy(MassDestroyEducationInformationeRequest $request)
    {
        $educationInformationes = EducationInformatione::find(request('ids'));

        foreach ($educationInformationes as $educationInformatione) {
            $educationInformatione->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('education_informatione_create') && Gate::denies('education_informatione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new EducationInformatione();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
