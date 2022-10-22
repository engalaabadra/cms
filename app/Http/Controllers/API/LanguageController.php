<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
        
    public function switchLang($lang)
    {

        if (array_key_exists($lang, Config::get('languages'))) {
            Storage::put('applocale', $lang);
            app()->setLocale(Storage::get('applocale'));
        
        }
        // return Redirect::back();
    }
 
    public function defaultLang(){
        $defaultLang=config('app.locale');
        return response()->json(['status'=>true,'message'=>$this->globalVars()['success'],'data'=>$defaultLang],200);
    }
    
    public function getAllLangs(){
        $getAllLangs=Config::get('languages');
        return response()->json(['status'=>true,'message'=>$this->globalVars()['success'],'data'=>$getAllLangs],200);
    }
   
}
    