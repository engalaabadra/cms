<?php
namespace App\Repositories\Auth\Login;

use App\Models\User;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TempDataUser;
class LoginRepository extends EloquentRepository implements LoginRepositoryInterface{


    
    public function login($request){
        $data=$request->validated();
        // Storage::put('loggedInPassword',$data['password']);
        if(!auth()->attempt($data)){
            return trans('messages.Invalid credentials');
        }else{

            $accessToken=auth()->user()->createToken('token')->accessToken;
            $user=auth()->user();
            
            Storage::put($user->id.'-token',$accessToken);
            Storage::put($user->id.'-user',$user);
                 $TempDataUser= TempDataUser::where(['user_id'=>$user->id])->first();

                 if(empty($TempDataUser)){
                 $TempDataUser=new TempDataUser();
                 $TempDataUser->user_id=$user->id;
                $TempDataUser->token=$accessToken;
                $TempDataUser->user=$user;
                  $TempDataUser->save();
              }else{
                $TempDataUser->token=$accessToken;
                 $TempDataUser->user=$user;

                  $TempDataUser->save();
              }

            return 200;
        }

    }
    

    

    public function logout($request){
                    $user=auth()->user();

                    Storage::put($user->id.'-token',null);
                    Storage::put($user->id.'-user',null);
                    $TempDataUser= TempDataUser::where(['user_id'=>$user->id])->first();

                 if(empty($TempDataUser)){
                 $TempDataUser=new TempDataUser();
                 $TempDataUser->user_id=$user->id;
                $TempDataUser->token=null;
                $TempDataUser->user=null;
                  $TempDataUser->save();
              }else{
                $TempDataUser->token=null;
                                $TempDataUser->user=null;

                  $TempDataUser->save();
              }
        $request->user()->token()->revoke();

        return true;
    }
    

}