<?php
namespace App\Repositories\Auth\Password;

use App\Repositories\Auth\Sms\SmsRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PasswordRepository  implements PasswordRepositoryInterface{
        /**
     * @var SmsRepository
     */
    protected $smsRepo;
    public function __construct(SmsRepository $smsRepo){
        $this->smsRepo = $smsRepo;
    }
    public function forgotPassword($request,$model1,$model2){//model2: password_resets , model1: user
        $data=$request->validated();
        $user= $model1->where(['email'=>$data['email']])->first();
        if(!empty($user)){
            // Generate random code
            $data['code'] = mt_rand(1000, 9999);
            // Create a new code
            $password_resets= $model2->create($data);
                                      $rand=mt_rand();

            Storage::put($rand.'-code',$data['code']);
            Storage::put($rand.'-email_forgot',$data['email']);
            // Send sms to email
            return ['password_resets'=>$password_resets,'rand'=>$rand];
        }else{
            return __('email that you wrote it , not exsit in system');
        }
        
    }
    public function checkCode($request,$model,$rand){
        $email= Storage::get($rand.'-email_forgot');
        if($email){

            // find the code
            $passwordReset = $model->firstWhere(['code'=> $request->code,'email'=>$email]);
            // check if it does not expired: the time is one hour
            if($passwordReset==null){
                return __('code is invalid, try again');
            }
    
            if ($passwordReset->created_at > now()->addHour()) {
                $passwordReset->delete();
                return __('code is expire');
            }
            return $passwordReset;
        }else{
            return __('You should go into forgot password before this');
        }
  
        
         
    }
    public function resetPassword($request,$model,$rand){//model :user 
        $data=$request->validated();
        $email=Storage::get($rand.'-email_forgot');
        if($email){
            // find user's email 
            $user = $model->firstWhere('email', $email);
            if(empty($user)){
    
                return __('email that you wrote it , not exsit in system');
            }else{
                // if(Hash::make($data['password'])==$user->password){
                //     return __('password that you wrote it , same your old password');
    
                // }
                $user->password=Hash::make($data['password']);
                $user->save();    
        
                return $user;
    
            }
        }else{
            return trans('You should go into forgot password before this');
        }
    }


}