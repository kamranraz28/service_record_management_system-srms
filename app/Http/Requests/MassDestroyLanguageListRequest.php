<?php

namespace App\Http\Requests;

use App\Models\LanguageList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLanguageListRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('language_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:language_lists,id',
        ];
    }
}
