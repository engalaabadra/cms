<?php

namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Auth\Login\LoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * @var LoginRepository
     */
    protected $loginRepo;
    public function __construct(LoginRepository $loginRepo,User $user){
        $this->loginRepo = $loginRepo;
        $this->user=$user;
    }

    public function authLogin(){
        return response()->json(['status'=>false,'message'=>config('contants.auth')],401);
    }
   
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function login(LoginRequest $request){
        // try{
        $data=$request->validated();
        // dd($data);
            $loginUser=  $this->loginRepo->login($request);
            if(is_string($loginUser)){
                return response()->json(['status'=>false,'message'=>$loginUser],400);

            }
                        $user=auth()->user();

            $data=[
                "token"=>'Bearer'.' '.Storage::get($user->id.'-token'),
                "user"=>auth()->user()
                ];
            return response()->json(['status'=>true,'message'=>trans('login successfully'),'data'=>$data],200);
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->globalVars()['error']],500);
        // }
      }
       
    public function getUserToken(){
        try{
                        $user=auth()->user();

            $token=  Storage::get($user->id.'-token');
            $user=  json_decode(Storage::get($user->id.'-user'));
            if($token){
                $data=[
                    'user'=>$user,
                    'token'=>'Bearer'.' '.$token
                    ];
            return response()->json(['status'=>true,'message'=>$this->globalVars()['success'],'data'=>$data],200);
                    
            }else{
                return response()->json(['status'=>false,'message'=>trans('Un Authorized')],401);
            }
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->globalVars()['error']],500);
        } 

    }
        
        
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        try{
            $logout=  $this->loginRepo->logout($request);
            if($logout==true){
            return response()->json(['status'=>true,'message'=>trans('logout successfully')],200);
            }
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->globalVars()['error']],500);
        } 
    }
}
