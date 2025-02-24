<?php

namespace App\Http\Requests;

use App\Models\CriminalproDisciplinary;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCriminalproDisciplinaryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('criminalpro_disciplinary_create');
    }

    public function rules()
    {
        return [
            'criminalprosecutione_id' => [
                'required',
                'integer',
            ],
            'judgement_type' => [
                'string',
                'nullable',
            ],
            'government_order_no' => [
                'string',
                'nullable',
            ],
            'govt_order' => [
                'string',
                'nullable',
            ],
            'employee_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
