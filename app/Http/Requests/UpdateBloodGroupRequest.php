<?php

namespace App\Http\Requests;

use App\Models\BloodGroup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBloodGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('blood_group_edit');
    }

    public function rules()
    {
        return [
            'name_bn' => [
                'string',
                'required',
                'unique:blood_groups,name_bn,' . request()->route('blood_group')->id,
            ],
            'name_en' => [
                'string',
                'required',
            ],
        ];
    }
}
