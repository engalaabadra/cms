<?php
namespace Modules\Auth\Repositories\User;

use App\GeneralClasses\MediaClass;
use App\Models\Image as ModelsImage;
use App\Repositories\EloquentRepository;
use Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
// class UserRepository implements UserRepositoryInterface
{

    public function countryUser($user){
        $countryUser= $user->profile->country;
        return $countryUser;
    }
    public function cityUser($user){
        $cityUser= $user->profile->city;
        return $cityUser;
    }
    public function townUser($user){
        $townUser= $user->profile->town;
        return $townUser;
    }
 

    // methods overrides
    public function store($request,$model){
        $data=$request->validated();
        $password=Str::random(8);
        $data['password']=Hash::make($password);

        
        $enteredData=  Arr::except($data ,['image']);

        $user= $model->create($enteredData);
        if(!empty($data['roles'])){
           $explodeRoles=explode(',', $data['roles'][0]);

            foreach($explodeRoles as $role){
              if($role==1){
                  return trans('cannt add any user to role superadmin: num:1');
              }
              DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>$role]);
            }
        }


            if(!empty($data['image'])){
                if($request->hasFile('image')){
                    $file_path_original_image_user= MediaClass::store($request->file('image'),'profile-images');//store profile image
                    $data['image']=$file_path_original_image_user;
                }else{
                    $data['image']=$user->image;
                }
                $user->image()->create(['url'=>$data['image'],'imageable_id'=>$user->id,'imageable_type'=>'App\Models\User']);
            }
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
            return $user;
    }

    public function storeTrans($request,$model,$id,$lang){
        $data=$request->validated();
        $password=Str::random(8);
        $data['password']=Hash::make($password);

        
        $enteredData=  Arr::except($data ,['image']);
                $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
        $user= $model->create($enteredData);
        if(!empty($data['roles'])){
           $explodeRoles=explode(',', $data['roles'][0]);

            foreach($explodeRoles as $role){
              if($role==1){
                  return trans('cannt add any user to role superadmin: num:1');
              }
              DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>$role]);
            }
        }


            if(!empty($data['image'])){
                if($request->hasFile('image')){
                    $file_path_original_image_user= MediaClass::store($request->file('image'),'profile-images');//store profile image
                    $data['image']=$file_path_original_image_user;
                }else{
                    $data['image']=$user->image;
                }
                $user->image()->create(['url'=>$data['image'],'imageable_id'=>$user->id,'imageable_type'=>'App\Models\User']);
            }
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
            return $user;
    }

        public function update($request,$id,$model){

        $user=$this->find($id,$model);
        $data= $request->validated();
        $password=Str::random(8);
        $data['password']=Hash::make($password);

        $enteredData=  Arr::except($data,['image']);
        $user->update($enteredData);
        


     if(!empty($data['image'])){
           if($request->hasFile('image')){
               $file_path_original= MediaClass::store($request->file('image'),'profile-images');//store profile image
               $data['image']=$file_path_original;

           }else{
               $data['image']=$user->image;
           }
         if($user->image){
             $user->image()->update(['url'=>$data['image'],'imageable_id'=>$user->id,'imageable_type'=>'App\Models\User']);
   
         }else{
   
             $user->image()->create(['url'=>$data['image'],'imageable_id'=>$user->id,'imageable_type'=>'App\Models\User']);
         }
     }
        if(!empty($data['roles'])){
            $user->syncRoles($data['roles']);//to update roles a user
         //   $user->roles()->toggle($data['roles']);//to update roles a user
        }

        return $user;
    }

    public function forceDelete($id,$model){
        //to make force destroy for an item must be this item  not found in items table  , must be found in trash items
        $itemInTableitems = $this->find($id,$model);//find this item from  table items
        if(!empty($itemInTableitems)){//this item not found in items table
            $itemInTrash= $this->findItemOnlyTrashed($id,$model);//find this item from trash 
            if(is_string($itemInTrash)){//this item not found in trash items
                return trans('messages.this item not found in trash');
            }else{
                $itemInTrash->detachRoles($itemInTrash->roles);
                // MediaClass::delete($itemInTrash->image);
                $itemInTrash->forceDelete();
                return 200;
            }
        }else{
            return trans('messages.this item not found in system');
        }


    }

    
}
