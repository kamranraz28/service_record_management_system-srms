<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSocialAssPrAttachmentRequest;
use App\Http\Requests\UpdateSocialAssPrAttachmentRequest;
use App\Models\EmployeeList;
use App\Models\SocialAssPrAttachment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SocialAssPrAttachmentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('social_ass_pr_attachment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SocialAssPrAttachment::with(['employee'])->select(sprintf('%s.*', (new SocialAssPrAttachment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'social_ass_pr_attachment_show';
                $editGate      = 'social_ass_pr_attachment_edit';
                $deleteGate    = 'social_ass_pr_attachment_delete';
                $crudRoutePart = 'social-ass-pr-attachments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('degree_membership_organization', function ($row) {
                return $row->degree_membership_organization ? $row->degree_membership_organization : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('certificate_achievement', function ($row) {
                return $row->certificate_achievement ? $row->certificate_achievement : '';
            });
            $table->addColumn('employee_employeeid', function ($row) {
                return $row->employee ? $row->employee->employeeid : '';
            });

            $table->editColumn('employee.fullname_bn', function ($row) {
                return $row->employee ? (is_string($row->employee) ? $row->employee : $row->employee->fullname_bn) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'employee']);

            return $table->make(true);
        }

        return view('admin.socialAssPrAttachments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('social_ass_pr_attachment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.socialAssPrAttachments.create', compact('employees'));
    }

    public function store(StoreSocialAssPrAttachmentRequest $request)
    {
        $socialAssPrAttachment = SocialAssPrAttachment::create($request->all());
         return redirect()->back()->with('status', __('global.saveactions'));
       // return redirect()->route('admin.social-ass-pr-attachments.index');
    }

    public function edit(SocialAssPrAttachment $socialAssPrAttachment)
    {
        abort_if(Gate::denies('social_ass_pr_attachment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = EmployeeList::pluck('employeeid', 'id')->prepend(trans('global.pleaseSelect'), '');

        $socialAssPrAttachment->load('employee');

        return view('admin.socialAssPrAttachments.edit', compact('employees', 'socialAssPrAttachment'));
    }

    public function update(UpdateSocialAssPrAttachmentRequest $request, SocialAssPrAttachment $socialAssPrAttachment)
    {
        $socialAssPrAttachment->update($request->all());

        return redirect()->route('admin.social-ass-pr-attachments.index');
    }

    public function show(SocialAssPrAttachment $socialAssPrAttachment)
    {
        abort_if(Gate::denies('social_ass_pr_attachment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socialAssPrAttachment->load('employee');

        return view('admin.socialAssPrAttachments.show', compact('socialAssPrAttachment'));
    }
}