<?php

namespace App\Http\Requests;

use App\Models\Status;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('status_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:statuses',
            ],
            'name_en' => [
                'string',
                'required',
                'unique:statuses',
            ],
        ];
    }
}
