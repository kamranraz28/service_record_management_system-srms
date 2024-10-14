<?php

namespace App\Http\Requests;

use App\Models\ForeignTravelPersonal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreForeignTravelPersonalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('foreign_travel_personal_create');
    }

    public function rules()
    {
        return [
            // 'purpose_id' => [
            //     'required',
            //     'integer',
            // ],
            'from_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'to_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
            'leave_permission' => [
                'required',
            ],
            'title_id' => [
                'required',
            ],
        ];
    }
}
