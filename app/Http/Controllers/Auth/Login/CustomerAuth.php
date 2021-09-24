<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuth extends Controller
{


   public function login(Request $request){

//       dd('here');
//       dd($request->all());
       $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required',
       ]);

//       dd('here');
       // Attempt to log the user in
       // Passwordnya pake bcrypt
       if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
           // if successful, then redirect to their intended location
//           dd();
           return redirect(route('home'));
       } else {
           return redirect()->back()->with('error','These credentials do not match our records.');
       }

//       dd('here');
   }
    protected function guard()
    {

        return Auth::guard('customer');
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
    protected function loggedOut(Request $request)
    {
        //
        return redirect('/login');
    }
    protected function authenticated(Request $request, $user)
    {

//        $this->redirectTo=Auth::guard('employee')->user()->role->name=='Agent'?'tickets':'/';
        if ($user->can_login) {
            return redirect()->intended($this->redirectPath());
        }else{
            return $this->logout($request)->withErrors(['email' => 'This user account is not authorized to Login']);
        }

    }
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }
}
