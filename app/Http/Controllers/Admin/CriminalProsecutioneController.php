<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCriminalProsecutioneRequest;
use App\Http\Requests\StoreCriminalProsecutioneRequest;
use App\Http\Requests\UpdateCriminalProsecutioneRequest;
use App\Models\CriminalProsecutionDerail;
use App\Models\CriminalProsecutione;
use App\Models\EmployeeList;
use App\Models\MamlaType;
use App\Models\MamlaSituation;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CriminalProsecutioneController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('criminal_prosecutione_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
					
				$query = CriminalProsecutione::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new CriminalProsecutione)->table));

			}elseif ($circles == null && $divisions !== null) {
				
				$sameOfficeIds = User::select('id')
					->where('forest_division_id', $divisions)
					->pluck('id');
					
				$query = CriminalProsecutione::with(['employee'])
					->whereHas('employee', function ($query) use ($sameOfficeIds) {
						$query->whereIn('created_by', $sameOfficeIds);
					})
					->select(sprintf('%s.*', (new CriminalProsecutione)->table));

			}else{
				$query = CriminalProsecutione::with(['employee'])
				->select(sprintf('%s.*', (new CriminalProsecutione)->table));
			}
			
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'criminal_prosecutione_show';
                $editGate      = 'criminal_prosecutione_edit';
                $deleteGate    = 'criminal_prosecutione_delete';
                $crudRoutePart = 'criminal-prosecutiones';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? $row->employee->employeeid : '';
            });
			
			$table->editColumn('employee_fullname_bn', function ($row) {
                return $row->employee ? $row->employee->fullname_bn : '';
            });
			
			$table->editColumn('mamla_id', function ($row) {
                return $row->mamla ? $row->mamla->name_bn : '';
            });
			
			$table->editColumn('situation', function ($row) {
                return $row->situation ? $row->situation : '';
            });
			
			$table->editColumn('mamla_start', function ($row) {
                return $row->mamla_start ? $row->mamla_start : '';
            });
			
			$table->editColumn('mamla_end', function ($row) {
                return $row->mamla_end ? $row->mamla_end : '';
            });

            $table->editColumn('judgement_type', function ($row) {
                return $row->judgement_type ? $row->judgement_type : '';
            });
            $table->editColumn('natureof_offence', function ($row) {
                return $row->natureof_offence ? $row->natureof_offence : '';
            });
            $table->editColumn('government_order_no', function ($row) {
                return $row->government_order_no ? $row->government_order_no : '';
            });
			$table->editColumn('remzrk', function ($row) {
                return $row->remzrk ? $row->remzrk : '';
            });
            $table->editColumn('court_order', function ($row) {
                return $row->court_order ? '<a href="' . $row->court_order->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee', 'court_order']);

            return $table->make(true);
        }

        return view('admin.criminalProsecutiones.index');
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('criminal_prosecutione_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);
		$mamlatypes = MamlaType::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');
		$mamlasituations = MamlaSituation::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.criminalProsecutiones.create', compact('mamlasituations','mamlatypes','employees','employee'));
    }

    public function store(StoreCriminalProsecutioneRequest $request)
    {

    //     dd($request->all());
    $criminalProsecutione = CriminalProsecutione::create($request->all());

    if ($request->input('court_order', false)) {
            if (! $criminalProsecutione->court_order || $request->input('court_order') !== $criminalProsecutione->court_order->file_name) {
                if ($criminalProsecutione->court_order) {
                    $criminalProsecutione->court_order->delete();
                }
                $criminalProsecutione->addMedia(storage_path('tmp/uploads/' . basename($request->input('court_order'))))->toMediaCollection('court_order');
            }
        } elseif ($criminalProsecutione->court_order) {
            $criminalProsecutione->court_order->delete();
        }
		
		
		if ($request->input('court_order_new', false)) {
            if (! $criminalProsecutione->court_order_new || $request->input('court_order_new') !== $criminalProsecutione->court_order_new->file_name) {
                if ($criminalProsecutione->court_order_new) {
                    $criminalProsecutione->court_order_new->delete();
                }
                $criminalProsecutione->addMedia(storage_path('tmp/uploads/' . basename($request->input('court_order_new'))))->toMediaCollection('court_order_new');
            }
        } elseif ($criminalProsecutione->court_order_new) {
            $criminalProsecutione->court_order_new->delete();
        }
		
		if ($request->input('appeal_order', false)) {
            if (! $criminalProsecutione->appeal_order || $request->input('appeal_order') !== $criminalProsecutione->appeal_order->file_name) {
                if ($criminalProsecutione->appeal_order) {
                    $criminalProsecutione->appeal_order->delete();
                }
                $criminalProsecutione->addMedia(storage_path('tmp/uploads/' . basename($request->input('appeal_order'))))->toMediaCollection('appeal_order');
            }
        } elseif ($criminalProsecutione->appeal_order) {
            $criminalProsecutione->appeal_order->delete();
        }
         return redirect()->back()->with('status', __('global.saveactions'));
    //     //return redirect()->route('admin.criminal-prosecutiones.index');
     }


    
    
    

    

    public function edit(CriminalProsecutione $criminalProsecutione)
    {
        abort_if(Gate::denies('criminal_prosecutione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $criminalProsecutione->load('employee');
		$mamlatypes = MamlaType::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');
		$mamlasituations = MamlaSituation::pluck('name_bn', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('admin.criminalProsecutiones.edit', compact('mamlasituations','mamlatypes','criminalProsecutione', 'employees'));
    }

    public function update(UpdateCriminalProsecutioneRequest $request, CriminalProsecutione $criminalProsecutione)
    {
        $criminalProsecutione->update($request->all());

        if ($request->input('court_order', false)) {
            if (! $criminalProsecutione->court_order || $request->input('court_order') !== $criminalProsecutione->court_order->file_name) {
                if ($criminalProsecutione->court_order) {
                    $criminalProsecutione->court_order->delete();
                }
                $criminalProsecutione->addMedia(storage_path('tmp/uploads/' . basename($request->input('court_order'))))->toMediaCollection('court_order');
            }
        } elseif ($criminalProsecutione->court_order) {
            $criminalProsecutione->court_order->delete();
        }
		
		if ($request->input('court_order_new', false)) {
            if (! $criminalProsecutione->court_order_new || $request->input('court_order_new') !== $criminalProsecutione->court_order_new->file_name) {
                if ($criminalProsecutione->court_order_new) {
                    $criminalProsecutione->court_order_new->delete();
                }
                $criminalProsecutione->addMedia(storage_path('tmp/uploads/' . basename($request->input('court_order_new'))))->toMediaCollection('court_order_new');
            }
        } elseif ($criminalProsecutione->court_order_new) {
            $criminalProsecutione->court_order_new->delete();
        }
		
		if ($request->input('appeal_order', false)) {
            if (! $criminalProsecutione->appeal_order || $request->input('appeal_order') !== $criminalProsecutione->appeal_order->file_name) {
                if ($criminalProsecutione->appeal_order) {
                    $criminalProsecutione->appeal_order->delete();
                }
                $criminalProsecutione->addMedia(storage_path('tmp/uploads/' . basename($request->input('appeal_order'))))->toMediaCollection('appeal_order');
            }
        } elseif ($criminalProsecutione->appeal_order) {
            $criminalProsecutione->appeal_order->delete();
        }

        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(CriminalProsecutione $criminalProsecutione)
    {
        abort_if(Gate::denies('criminal_prosecutione_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $criminalProsecutione->load('employee');

        return view('admin.criminalProsecutiones.show', compact('criminalProsecutione'));
    }

    public function destroy(CriminalProsecutione $criminalProsecutione)
    {
        abort_if(Gate::denies('criminal_prosecutione_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $criminalProsecutione->delete();

        return back();
    }

    public function massDestroy(MassDestroyCriminalProsecutioneRequest $request)
    {
        $criminalProsecutiones = CriminalProsecutione::find(request('ids'));

        foreach ($criminalProsecutiones as $criminalProsecutione) {
            $criminalProsecutione->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('criminal_prosecutione_create') && Gate::denies('criminal_prosecutione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CriminalProsecutione();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
