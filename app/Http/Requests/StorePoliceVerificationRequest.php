<?php

namespace App\Http\Requests;

use App\Models\PoliceVerification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePoliceVerificationRequest extends FormRequest
{

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
                'integer',
            ],
            'verification_type' => [
                'required',
                'integer',
            ],
            
        ];
    }
}
