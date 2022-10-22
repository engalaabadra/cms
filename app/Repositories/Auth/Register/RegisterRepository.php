<?php
namespace App\Repositories\Auth\Register;

use App\GeneralClasses\MediaClass;
use App\Repositories\Auth\Sms\SmsRepository;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class RegisterRepository extends EloquentRepository implements RegisterRepositoryInterface{
        
    /**
     * @var SmsRepository
     */
    protected $smsRepo;
    public function __construct(SmsRepository $smsRepo){
        $this->smsRepo = $smsRepo;
    }
    
    public function register($request,$model){
        $data=$request->validated();


        $data['password']=Hash::make($request->password);
        $enteredData=  Arr::except($data ,['image']);
        $user=new $model;
        $user->locale=config('app.locale');
        $user->email=$enteredData['email'];
        $user->password=Hash::make($request->password);
        $user->first_name=$enteredData['first_name'];
        $user->last_name=$enteredData['last_name'];
        $user->save();
        // $user= $model->create($enteredData);
        $user->roles()->attach([3]);//this user has role : user
        if(!empty($data['image'])){
            if($request->hasFile('image')){
                $file_path_original_image_user= MediaClass::store($request->file('image'),'profile-images');//store profile image
                $data['image']=$file_path_original_image_user;
            }else{
                $data['image']=$user->image;
            }
            $user->image()->create(['url'=>$data['image'],'imageable_id'=>$user->id,'imageable_type'=>'App\Models\User']);
        }

         $email=$data['email']; 
                          $rand=mt_rand();

               Storage::put($rand.'-email',$email);
         return ['user'=>$user,'rand'=>$rand,'image'=>$user->image];
    

    }
   
    public function checkCode($request,$model,$rand){
            $data=$request->validated();
$email=Storage::get($rand.'-email');
    if($email==null){
            return __('cannt add code because you not make first register');
        }
        // find the code
        $registerCodeNum = $model->firstWhere(['code'=> $data['code'],'email'=>$email]);

        // check if it does not expired: the time is one hour
        if(!$registerCodeNum){
            return __('code is invalid, try again');
        }
        if ($registerCodeNum->created_at > now()->addHour()) {
            $registerCodeNum->delete();
            return __('code is expire');
        }
        return $registerCodeNum;

    
    }
    public function resendCode($model,$rand){
        $email=Storage::get($rand.'-email');
        if($email==null){
            return __('you must write your email before this');
      
        }
        // Delete all old code that user send before.
        $model->where('email', $email)->delete();
        $code=mt_rand(1000, 9999);
        //insert code 
        $model->insert(['code'=>$code,'email'=>$email]);
        // Send into email
        return $code;
       
               
          }
      

}