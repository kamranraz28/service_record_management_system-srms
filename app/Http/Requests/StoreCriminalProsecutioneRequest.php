<?php

namespace App\Http\Requests;

use App\Models\CriminalProsecutione;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCriminalProsecutioneRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('criminal_prosecutione_create');
    }

    public function rules()
    {
        return [
            'judgement_type' => [
                'string',
                
            ],
            'natureof_offence' => [
                
                'nullable',
            ],
            'government_order_no' => [
                
                'nullable',
            ],
            'employee_id' => [
                
                'integer',
            ],
			'mamla_id' => [
				'nullable',
			],
			'situation_id' => [
				'integer',
				'nullable',
			],
			'mamla_start' => [
				'string',
				'nullable',
			],
			'mamla_result' => [
				'string',
				'nullable',
			],
			'appeal_go' => [
				'string',
				'nullable',
			],
			'appeal_result' => [
				'string',
				'nullable',
			],
			'mamla_end' => [
				'string',
				'nullable',
			],
			'remzrk' => [
				'string',
				'nullable',
			],
            // 'criminalprosecutione_id' => [
            //     'required',
            //     'integer',
            // ],
        ];
    }
}
