<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeAuthController extends LoginController
{

    protected $redirectTo = '/employees';

    public function __construct()
    {
        $this->middleware('guest:employee')->except('logout');
    }
    public function showLoginForm()
    {
        return view('employee.login');
    }

    protected function guard()
    {
        return Auth::guard('employee');
    }


    protected function authenticated(Request $request, $user)
    {
        if ($user->can_login) {

            return redirect()->intended($this->redirectPath());
        }
        return $this->logout($request)->withErrors(['email' => 'This user account is not authorized to Login']);
    }

    protected function loggedOut(Request $request)
    {
        //
        return redirect('/employees/login');
    }
}