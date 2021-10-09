<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
         return true;   //Default false .Now set return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            //
            // 'name' => 'required|max:64',
            // 'business_type' => 'required|max:64',
             'address' => 'required',
            // 'phone' => 'required',
            // 'ceo_name' => 'required|max:32',
            // 'company_registry' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
