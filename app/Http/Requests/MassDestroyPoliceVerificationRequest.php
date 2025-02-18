<?php

namespace App\Http\Requests;

use App\Models\PoliceVerification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPoliceVerificationRequest extends FormRequest
{

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:police_verifications,id',
        ];
    }
}
