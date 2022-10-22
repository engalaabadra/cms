<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct()
    {

    }
    public function globalVars(){
        $success=trans('messages.Operation has been successfully');
        $error=trans('messages.Something went wrong');
        $vars=[
            'success'=>$success,
            'error'=>$error,
        ];
        return $vars;

    }
   

}
