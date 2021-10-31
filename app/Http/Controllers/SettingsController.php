<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ThemeSetting;
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
    public function theme_setting(){
       $theme=ThemeSetting::all();
       return view('settings.theme',compact('theme'));
    }
    public function theme_color(Request $request){
        $current_theme=ThemeSetting::where('active',1)->first();
        $current_theme->active=0;
        $current_theme->update();
        $select_theme=ThemeSetting::where('id',$request->theme_id)->first();
        $select_theme->active=1;
        $select_theme->update();
        return redirect('/');
    }
}
