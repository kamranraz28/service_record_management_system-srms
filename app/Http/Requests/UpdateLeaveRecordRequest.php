<?php

namespace App\Http\Requests;

use App\Models\LeaveRecord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateLeaveRecordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_record_edit');
    }

    public function rules()
    {
        return [
            'type_of_leave_id' => [
                'required',
                'integer',
            ],
            'leave_category_id' => [
                'required',
                'integer',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
