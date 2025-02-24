<?php

namespace App\Http\Requests;

use App\Models\EmergenceContacte;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmergenceContacteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('emergence_contacte_create');
    }

    public function rules()
    {
        return [
            'contact_person_name' => [
                'string',
                'required',
            ],
            'contact_person_relation' => [
                'string',
                'required',
            ],
            'contact_person_number' => [
                'string',
                'required',
            ],
        ];
    }
}
