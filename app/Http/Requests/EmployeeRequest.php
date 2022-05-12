<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'department_id' => 'required',
            'name' => 'required',
            'role_id' => 'required',
//            'password' => 'required',
            'email'=>'required',
            'can_login' => 'nullable',
            'can_post_assignments' => 'nullable',
            'phone' => 'required',
            'work_phone' => 'required',
            'join_date' => 'required',
            'mobile_seller'=>'nullable',
            'office_branch_id'=>'nullable',
            'region_id'=>'nullable',
            'head_office'=>'required'

        ];
    }

    protected function prepareForValidation()
    {
        if ($this->password) {
            $this->merge([
                'password' => bcrypt($this->password),
            ]);
        }
    }
}
