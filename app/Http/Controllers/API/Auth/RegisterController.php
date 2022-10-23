<?php

namespace  App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckCodeRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\RegisterSecondRequest;
use App\Models\RegisterCodeNum;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Repositories\Auth\Register\RegisterRepository;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /**
     * @var RegisterRepository
     */
    protected $regRepo;
    /**
     * @var User
     */
    protected $user;    
    /**
    * @var RegisterCodeNum
    */
   protected $registerCodeNum;

    

    public function __construct(RegisterRepository $regRepo,User $user,RegisterCodeNum $registerCodeNum){
        $this->regRepo = $regRepo;
        $this->user = $user;
        $this->registerCodeNum=$registerCodeNum;

    }
    
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request)
    {
        // try{
          $regUser =  $this->regRepo->register($request, $this->user);
            if(!empty($regUser)){


              $email= Storage::get($regUser['rand'].'-email');
              // Delete all old code that user send before.
              RegisterCodeNum::where('email', $email)->delete();
              $code=mt_rand(1000, 9999);
              //insert code 
              RegisterCodeNum::insert(['code'=>$code,'email'=>$email]);
              // Send into email  
            //   dd($regUser->image);
            $image=null;
              if($regUser['image']){
                    $image= $regUser['image']->url;
                }
                $accessToken=$regUser['user']->createToken('token')->accessToken;
                $data=[
                    'user'=>$regUser['user'],
                    // 'image'=>$image,
                    'token'=>$accessToken,
                    'code'=>$code,
                    'rand'=>$regUser['rand']
                ];
                   
                return response()->json(['status'=>true,'message'=>$this->globalVars()['success'],'data'=>$data],200);
            }
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>config('constants.error')],500);
        // } 
    }


    public function checkCodeRegister(CheckCodeRequest $request,$rand){
        try{
            
            $code=$this->regRepo->checkCode($request,$this->registerCodeNum,$rand);
            if(is_string($code)){
                return response()->json(['status'=>false,'message'=>$code],400);
            }
            $email=Storage::get($rand.'-email');
            $user= User::where(['email'=>$email])->first();
                
            $accessToken=$user->createToken('token')->accessToken;
            $data=[
                'token'=> $accessToken,
                'user'=> $user,
                'code'=>$code
            ];
            return response()->json(['status'=>true,'message'=>$this->globalVars()['success'],'data'=>$data],200);
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->globalVars()['error']],500);
        } 
    }
    public function resendCodeRegister($rand){
        $resendCode=$this->regRepo->resendCode($this->registerCodeNum,$rand);
        if(is_string($resendCode)){
            return response()->json(['status'=>false,'message'=>$resendCode],400);
        }
        $data=[
            'code'=>$resendCode,
            'email'=>$email
        ];
        return response()->json([
            'status'=>true,
            'message' => 'code has been sent again successfully',
            'data'=> $data
        ]);
}


}
