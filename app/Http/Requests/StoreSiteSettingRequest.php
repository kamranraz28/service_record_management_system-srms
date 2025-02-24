<?php

namespace App\Http\Requests;

use App\Models\SiteSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSiteSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('site_setting_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'unique:site_settings',
            ],
            'site_logo' => [
                'required',
            ],
            'copyright' => [
                'string',
                'required',
            ],
            'helpline' => [
                'string',
                'nullable',
            ],
            'title_en' => [
                'string',
                'required',
            ],
            'favicon' => [
                'required',
            ],
        ];
    }
}
