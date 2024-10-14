<?php

namespace App\Http\Requests;

use App\Models\Training;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTrainingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('training_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'nullable',
                'integer',
            ],
            'training_type_id' => [
                'nullable',
                'integer',
            ],
            'training_name' => [
                'string',
                'nullable',
            ],
            'institute_name' => [
                'string',
                'nullable',
            ],
            'start_date' => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'grade' => [
                'string',
                'nullable',
            ],
            'position' => [
                'string',
                'nullable',
            ],
            'location' => [
                'string',
                'nullable',
            ],
        ];
    }
}
