<?php

namespace App\Http\Requests;

use App\Models\Professionale;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProfessionaleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('professionale_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'qualification_title' => [
                'string',
                'required',
            ],
            'institution' => [
                'string',
                'required',
            ],
            'from_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'to_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'passing_year' => [
                'nullable',
            ],
        ];
    }
}
