<?php

namespace App\Http\Requests;

use App\Models\ServiceParticular;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServiceParticularRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('service_particular_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:service_particulars,id',
        ];
    }
}
