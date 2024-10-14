<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAwardRequest;
use App\Http\Requests\StoreAwardRequest;
use App\Http\Requests\UpdateAwardRequest;
use App\Models\Award;
use App\Models\EmployeeList;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AwardsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('award_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
				
			$awards = Award::with(['employee', 'media'])
				->whereHas('employee', function ($query) use ($sameOfficeIds) {
					$query->whereIn('created_by', $sameOfficeIds);
				})
				->get();

		}elseif ($circles == null && $divisions !== null) {
			
			$sameOfficeIds = User::select('id')
				->where('forest_division_id', $divisions)
				->pluck('id');
				
			$awards = Award::with(['employee', 'media'])
				->whereHas('employee', function ($query) use ($sameOfficeIds) {
					$query->whereIn('created_by', $sameOfficeIds);
				})
				->get();

		}else{
			$awards = Award::with(['employee', 'media'])
			->get();
		}

        return view('admin.awards.index', compact('awards'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('award_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeId = $request->query('id');
        $employee = EmployeeList::find($employeeId);

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.awards.create', compact('employees','employee'));
    }

    public function store(StoreAwardRequest $request)
    {
        $award = Award::create($request->all());

        if ($request->input('certificate', false)) {
            $award->addMedia(storage_path('tmp/uploads/' . basename($request->input('certificate'))))->toMediaCollection('certificate');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $award->id]);
        }
         return redirect()->back()->with('status', __('global.saveactions'));
        //return redirect()->route('admin.awards.index');
    }

    public function edit(Award $award)
    {
        abort_if(Gate::denies('award_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $award->load('employee');

        return view('admin.awards.edit', compact('award', 'employees'));
    }

    public function update(UpdateAwardRequest $request, Award $award)
    {
        $award->update($request->all());

        if ($request->input('certificate', false)) {
            if (! $award->certificate || $request->input('certificate') !== $award->certificate->file_name) {
                if ($award->certificate) {
                    $award->certificate->delete();
                }
                $award->addMedia(storage_path('tmp/uploads/' . basename($request->input('certificate'))))->toMediaCollection('certificate');
            }
        } elseif ($award->certificate) {
            $award->certificate->delete();
        }

        return redirect()->back()->with('status', __('global.updateAction'));
    }

    public function show(Award $award)
    {
        abort_if(Gate::denies('award_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $award->load('employee');

        return view('admin.awards.show', compact('award'));
    }

    public function destroy(Award $award)
    {
        abort_if(Gate::denies('award_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $award->delete();

        return back();
    }

    public function massDestroy(MassDestroyAwardRequest $request)
    {
        $awards = Award::find(request('ids'));

        foreach ($awards as $award) {
            $award->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('award_create') && Gate::denies('award_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Award();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
