<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'max:16|required',
            'email' => 'required',
            'company_id' => 'nullable',
            'profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'credit_limit' => 'nullable',
            'gender'=>'required'
//            'region' => 'nullable',
//            'branch_id' => 'nullable',
//            'zone_id' => 'nullable',
//            'customer_id' => 'nullable',
//            'bio' => 'nullable',
//            'gender' => 'nullable',
//            'address' => 'nullable',
//            'password' => 'nullable',
//            'can_login' => 'nullable',
//            'facebook' => 'nullable',
//            'linkedin' => 'nullable',
//            'dob' => 'nullable',
//            'report_to' => 'nullable',
//            'position_of_report_to' => 'nullable',
//            "priority" => 'nullable',
//            "tags_id" => 'nullable',
//            "emp_id" => 'nullable',
//            'department' => 'nullable',
//            'position' => 'nullable',
//            'status' => 'nullable',
//            'lead_title' => 'nullable',
//            'customer_type' => 'nullable',
//            'current_credit' => 'nullable',
//            'case' => 'nullable',
//            'main_customer' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => 'Company Name must be filled.'
        ];
    }
}
