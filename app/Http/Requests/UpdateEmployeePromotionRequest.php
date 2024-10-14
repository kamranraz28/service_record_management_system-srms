<?php

namespace App\Http\Requests;

use App\Models\EmployeePromotion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeePromotionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_promotion_edit');
    }

    public function rules()
    {
        return [
            'new_designation_id' => [
                'required',
                'integer',
            ],
            'go_issue_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'office_order_date' => [
                'nullable',
            ],
			'grade_id' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
