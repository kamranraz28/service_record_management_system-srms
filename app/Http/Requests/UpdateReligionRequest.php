<?php

namespace App\Http\Requests;

use App\Models\Religion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReligionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('religion_edit');
    }

    public function rules()
    {
        return [
            'name_bn' => [
                'string',
                'required',
                'unique:religions,name_bn,' . request()->route('religion')->id,
            ],
            'name_en' => [
                'string',
                'required',
            ],
        ];
    }
}
