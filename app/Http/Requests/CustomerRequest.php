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
            'phone' => 'required',
            'email' => 'required',
            'company_id' => 'required',
            'profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'credit_limit'=>'nullable',
            'region'=>'nullable'
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => 'Company Name must be filled.'
        ];
    }
}
