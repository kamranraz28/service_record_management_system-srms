<?php

namespace App\Http\Requests;

use App\Models\EmployeeList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Rules\NidNumber;

class StoreEmployeeListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_list_create');
    }

    public function rules()
    {
        return [
            'cadreid' => ['string', 'nullable'],
            'fullname_bn' => ['string', 'min:2', 'max:50', 'required'],
            'fullname_en' => ['string', 'min:5', 'max:50', 'required'],
            'fname_bn' => ['string', 'min:1', 'max:50', 'required'],
            'fname_en' => ['string', 'min:5', 'max:50', 'required'],
            'mname_bn' => ['string', 'min:2', 'max:50', 'required'],
            'mname_en' => ['string', 'required'],
            'date_of_birth' => ['required', 'date_format:' . config('panel.date_format')],
            'prl_date' => ['required', 'date_format:' . config('panel.date_format')],
            'height' => ['string', 'nullable'],
            'special_identity' => ['string', 'nullable'],
            'home_district_id' => ['required', 'integer'],
            'marital_statu_id' => ['required', 'integer'],
            'designation_id' => ['required', 'integer'],
            'first_designation_id' => ['required', 'integer'],
            'gender_id' => ['required', 'integer'],
            'freedomfighter_id' => ['nullable', 'integer'],
            'religion_id' => ['nullable'],
            'blood_group_id' => ['required', 'integer'],
            'passport' => ['string', 'nullable'],
            'mobile_number' => ['string', 'min:11', 'max:15', 'required'],
            'fjoining_date' => ['required', 'date_format:' . config('panel.date_format')],
            'first_joining_office_name' => ['string', 'nullable'],
            'first_joining_g_o_date' => ['date_format:' . config('panel.date_format'), 'nullable'],
            'first_joining_memo_no' => ['string', 'nullable'],
            'project_to_revenue_date' => ['nullable'],
            'project_to_revenue_memo' => ['string', 'nullable'],
            'date_of_gazette' => ['date_format:' . config('panel.date_format'), 'nullable'],
            'date_of_regularization' => ['date_format:' . config('panel.date_format'), 'nullable'],
            'regularization_issue_date' => ['date_format:' . config('panel.date_format'), 'nullable'],
            'date_of_con_serviec' => ['date_format:' . config('panel.date_format'), 'nullable'],
            'license_number' => ['string', 'nullable'],
            'freedomfighter_name' => ['nullable'],
            'freedomfighter_address' => ['nullable'],
            'freedomfighter_go' => ['nullable'],
            'approve' => ['string', 'nullable'],
            'approveby' => ['string', 'nullable'],
            'nid' => [
                'numeric',
                'unique:employee_lists,nid',
                new NidNumber,
            ],
            'class' => ['required', 'in:1st,2nd,3rd,4th']
        ];
    }

    public function messages()
    {
        return [
            'cadreid.string' => 'ক্যাডার আইডি অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',

            // 'fullname_bn' messages
            'fullname_bn.required' => 'সম্পূর্ণ নাম (বাংলা) ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'fullname_bn.string' => 'সম্পূর্ণ নাম (বাংলা) অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',
            'fullname_bn.min' => 'সম্পূর্ণ নাম (বাংলা) অবশ্যই কমপক্ষে :min অক্ষরের হতে হবে।',
            'fullname_bn.max' => 'সম্পূর্ণ নাম (বাংলা) :max অক্ষরের বেশি হতে পারবে না।',

            // 'fullname_en' messages
            'fullname_en.required' => 'সম্পূর্ণ নাম (ইংরেজি) ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'fullname_en.string' => 'সম্পূর্ণ নাম (ইংরেজি) অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',
            'fullname_en.min' => 'সম্পূর্ণ নাম (ইংরেজি) অবশ্যই কমপক্ষে :min অক্ষরের হতে হবে।',
            'fullname_en.max' => 'সম্পূর্ণ নাম (ইংরেজি) :max অক্ষরের বেশি হতে পারবে না।',

            // 'fname_bn' messages
            'fname_bn.required' => 'পিতার নাম (বাংলা) ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'fname_bn.string' => 'পিতার নাম (বাংলা) অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',
            'fname_bn.min' => 'পিতার নাম (বাংলা) অবশ্যই কমপক্ষে :min অক্ষরের হতে হবে।',
            'fname_bn.max' => 'পিতার নাম (বাংলা) :max অক্ষরের বেশি হতে পারবে না।',

            // 'fname_en' messages
            'fname_en.required' => 'পিতার নাম (ইংরেজি) ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'fname_en.string' => 'পিতার নাম (ইংরেজি) অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',
            'fname_en.min' => 'পিতার নাম (ইংরেজি) অবশ্যই কমপক্ষে :min অক্ষরের হতে হবে।',
            'fname_en.max' => 'পিতার নাম (ইংরেজি) :max অক্ষরের বেশি হতে পারবে না।',

            // 'mname_bn' messages
            'mname_bn.required' => 'মাতার নাম (বাংলা) ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'mname_bn.string' => 'মাতার নাম (বাংলা) অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',
            'mname_bn.min' => 'মাতার নাম (বাংলা) অবশ্যই কমপক্ষে :min অক্ষরের হতে হবে।',
            'mname_bn.max' => 'মাতার নাম (বাংলা) :max অক্ষরের বেশি হতে পারবে না।',

            // 'mname_en' messages
            'mname_en.required' => 'মাতার নাম (ইংরেজি) ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'mname_en.string' => 'মাতার নাম (ইংরেজি) অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',

            // 'date_of_birth' messages
            'date_of_birth.required' => 'জন্ম তারিখ অবশ্যই পূরণ করতে হবে।',
            'date_of_birth.date_format' => 'জন্ম তারিখ অবশ্যই ফরম্যাটে হতে হবে: ' . config('panel.date_format') . '।',

            // 'prl_date' messages
            'prl_date.required' => 'পিআরএল তারিখ অবশ্যই পূরণ করতে হবে।',
            'prl_date.date_format' => 'পিআরএল তারিখ অবশ্যই ফরম্যাটে হতে হবে: ' . config('panel.date_format') . '।',

            // 'mobile_number' messages
            'mobile_number.required' => 'মোবাইল নাম্বার (ব্যক্তিগত) অবশ্যই পূরণ করতে হবে।',
            'mobile_number.string' => 'মোবাইল নাম্বার অবশ্যই একটি সঠিক স্ট্রিং হতে হবে।',
            'mobile_number.min' => 'মোবাইল নাম্বার কমপক্ষে :min সংখ্যা হতে হবে।',
            'mobile_number.max' => 'মোবাইল নাম্বার :max সংখ্যা অতিক্রম করতে পারবে না।',

            // 'nid' messages
            'nid.numeric' => 'জাতীয় পরিচয়পত্র নম্বর অবশ্যই একটি সংখ্যা হতে হবে।',
            'nid.unique' => 'এই জাতীয় পরিচয়পত্র নম্বর ইতিমধ্যে ব্যবহার করা হয়েছে।',

            // 'class' messages
            'class.required' => 'শ্রেণী ফিল্ডটি অবশ্যই পূরণ করতে হবে।',
            'class.in' => 'শ্রেণী অবশ্যই হতে হবে: 1st, 2nd, 3rd, অথবা 4th।',

            // 'designation_id' messages
            'designation_id.required' => 'পদবি (যে পদে প্রথম যোগদান করেছিলেন) অবশ্যই পূরণ করতে হবে।',
            'designation_id.integer' => 'The designation must be a valid integer.',

            // 'blood_group_id' messages
            'blood_group_id.required' => 'রক্তের গ্রুপ অবশ্যই পূরণ করতে হবে।',
            'blood_group_id.integer' => 'The blood group must be a valid integer.',

            // Repeat similar patterns for other fields...
        ];
    }

}
