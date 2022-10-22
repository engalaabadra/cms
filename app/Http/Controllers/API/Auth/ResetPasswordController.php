<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Repositories\Auth\Password\PasswordRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ResetPasswordController extends Controller
{
    /**
     * @var PasswordRepository
     */
    protected $passwordRepo;
    public function __construct(User $user,PasswordRepository $passwordRepo, BaseRepository $baseRepo){
        $this->user = $user;
        $this->passwordRepo = $passwordRepo;
        $this->baseRepo = $baseRepo;
    }
    public function __invoke(ResetPasswordRequest $request,$rand)
    {
        // dd(trans('messages.Operation has been successfully'));

       try{
            $passwordReset=$this->passwordRepo->resetPassword($request,$this->user,$rand);
            if(is_string($passwordReset)){
                return response()->json(['status'=>false,'message'=>$passwordReset],400);
            }

            return response()->json(['status'=>true,'message'=>$this->globalVars()['success'],'data'=>$passwordReset],200);
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->globalVars()['error']],500);
        } 
        
    }

}
