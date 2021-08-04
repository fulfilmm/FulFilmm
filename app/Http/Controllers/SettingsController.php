<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    //
    public function settings()
    {
        return view('settings.settings');

    }

    public function updateProfile(Request $request){
        $company = Company::where('user_company', true)->first();
        if($company){
            $path = '';
            if ($request->file('file')) {

                $uploadedFile = $request->file('file');
                $path = Storage::url($uploadedFile->store('company_profie', ['disk' => 'public']));
                $company->logo = $path;
                $company->save();
                return view('settings.settings');
            }else{
                return 'Please input a file';
            }
        }else{
            return 'Please  add user company';
        }

    }
}
