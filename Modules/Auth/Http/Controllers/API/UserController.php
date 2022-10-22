<?php

namespace Modules\Auth\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Modules\Auth\Http\Requests\User\StoreUserRequest;
use Modules\Auth\Http\Requests\User\UpdateUserRequest;
use Modules\Auth\Http\Requests\User\DeleteUserRequest;
// use Modules\Auth\Repositories\User\UserRepository;
use Modules\Auth\Repositories\Role\RoleRepository;
use Modules\Auth\Repositories\Permission\PermissionRepository;
use Modules\Geocode\Repositories\Country\CountryRepository;
use Modules\Geocode\Repositories\City\CityRepository;
use Modules\Geocode\Repositories\Town\TownRepository;
use App\Repositories\BaseRepository;
use App\Repositories\EloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Repositories\User\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var UserRepository
     */
    protected $userRepo;
        /**
     * @var User
     */
    protected $user;
    /**
     * @var RoleRepository
     */
    protected $roleRepo;
    
    /**
     * @var PermissionRepository
     */
    protected $permissionRepo;


    /**
     * UsersController constructor.
     *
     * @param UserRepository $users
     */
    public function __construct(BaseRepository $baseRepo, User $user,UserRepository $userRepo, RoleRepository $roleRepo,PermissionRepository $permissionRepo)
    {
        $this->middleware(['permission:users_read'])->only('index');
        $this->middleware(['permission:users_trash'])->only('trash');
        $this->middleware(['permission:users_restore'])->only('restore');
        $this->middleware(['permission:users_restore-all'])->only('restore-all');
        $this->middleware(['permission:users_show'])->only('show');
        $this->middleware(['permission:users_store'])->only('store');
        $this->middleware(['permission:users_update'])->only('update');
        $this->middleware(['permission:users_destroy'])->only('destroy');
        $this->middleware(['permission:users_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->user = $user;
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        
        $users=$this->userRepo->all($this->user,$lang);
                    return response()->json(['status'=>true,'message'=>trans('items has been getten successfully'),'data'=>$users],200);

    }
        public function getAllPaginates(Request $request,$lang=null){
        
        $users=$this->userRepo->getAllPaginates($this->user,$request,$lang);
                    return response()->json(['status'=>true,'message'=>trans('items has been getten successfully'),'data'=>$users],200);

    }

    public function activation($id){
        $user=  $this->user->find($id);
        $user->status=1;
        $user->save();
        return response()->json(['status'=>true,'message'=>trans('Congrats,  account  user has been activated'),'data'=>$user],200);


         
     }
    


    // methods for trash
    public function trash(Request $request){
        $users=$this->userRepo->trash($this->user,$request);
        if(is_string($users)){
            return response()->json(['status'=>false,'message'=>$users],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been getten successfully'),'data'=>$users],200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
      $user=  $this->userRepo->store($request,$this->user);
      if(is_string($user)){
            return response()->json(['status'=>false,'message'=>$user],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been stored successfully'),'data'=>$user->load('roles')],200);

    }
        public function storeTrans(StoreUserRequest $request,$id,$lang)
    {
      $user=  $this->userRepo->storeTrans($request,$this->user,$id,$lang);
            if(is_string($user)){
            return response()->json(['status'=>false,'message'=>$user],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been stored successfully'),'data'=>$user->load('roles')],200);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=$this->userRepo->find($id,$this->user);
        if(is_string($user)){
            return response()->json(['status'=>false,'message'=>$user],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been getten successfully'),'data'=>$user->load('roles')],200);

        
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request,$id)
    {
      $user= $this->userRepo->update($request,$id,$this->user);
        
                    return response()->json(['status'=>true,'message'=>trans('item has been updated successfully'),'data'=>$user->load('roles')],200);


    }

    //methods for restoring
    public function restore($id){
        
        $user =  $this->userRepo->restore($id,$this->user);
        
        if(is_string($user)){
            return response()->json(['status'=>false,'message'=>$user],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been restored successfully'),'data'=>$user->load('roles')],200);

        

    }
    public function restoreAll(){
        $users =  $this->userRepo->restoreAll($this->user);
        
                if(is_string($users)){
            return response()->json(['status'=>false,'message'=>$users],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('all items has been restored successfully'),'data'=>$users],200);

        

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $request,$id)
    {
       $user= $this->userRepo->destroy($id,$this->user);
               if(is_string($user)){
            return response()->json(['status'=>false,'message'=>$user],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been destroyed successfully'),'data'=>$user],200);

       
    }
    public function forceDelete(DeleteUserRequest $request,$id)
    {
        //to make force destroy for a user must be this user  not found in users table  , must be found in trash Categories
        $user=$this->userRepo->forceDelete($id,$this->user);
                if(is_string($user)){
            return response()->json(['status'=>false,'message'=>$user],404);
        }
                    return response()->json(['status'=>true,'message'=>trans('item has been destroyed forcely successfully'),'data'=>$user],200);

        
    }
    public function allNotifications(){
        $user=auth()->user();
        $notifications=[];
        $resultNotifications=[];
        foreach ($user->unreadNotifications as $notification) {
            $resultNotifications= array_push($notifications,$notification);
        }    
            return response()->json(['status'=>true,'message'=>trans('data has been getten successfully'),'data'=>$resultNotifications],200);

    }

}
