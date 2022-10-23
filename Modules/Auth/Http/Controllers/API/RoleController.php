<?php

namespace Modules\Auth\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\Role\StoreRoleRequest;
use Modules\Auth\Http\Requests\Role\UpdateRoleRequest;
use Modules\Auth\Http\Requests\Role\DeleteRoleRequest;
use Modules\Auth\Repositories\Role\RoleRepository;
use Modules\Auth\Entities\Role;
use App\Models\User;
use Modules\Auth\Entities\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roleRepo;

    /**
     * @var Role
     */
    protected $role;
    
    /**
     * @var User
     */
    protected $user;
        /**
     * @var Permission
     */
    protected $permission;

    
    /**
     * rolesController constructor.
     *
     * @param RoleRepository $roles
     */
    public function __construct(RoleRepository $roleRepo, Role $role,User $user,Permission $permission)
    {
        $this->middleware(['permission:roles_read'])->only('index');
        $this->middleware(['permission:roles_trash'])->only('trash');
        $this->middleware(['permission:roles_restore'])->only('restore');
        $this->middleware(['permission:roles_restore-all'])->only('restore-all');
        $this->middleware(['permission:roles_show'])->only('show');
        $this->middleware(['permission:roles_store'])->only('store');
        $this->middleware(['permission:roles_update'])->only('update');
        $this->middleware(['permission:roles_destroy'])->only('destroy');
        $this->middleware(['permission:roles_destroy-force'])->only('destroy-force');
        $this->roleRepo = $roleRepo;
        $this->role = $role;
        $this->user = $user;
        $this->permission = $permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        $roles=$this->roleRepo->all($this->role,$lang);
        return \response()->json([
            'status'=>200,
            'data'=>$roles
        ]);
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        $roles=$this->roleRepo->getAllPaginates($this->role,$request,$lang);
        return \response()->json([
            'status'=>200,
            'data'=>$roles
        ]);
    }
    public function trash(Request $request){
        $roles=$this->roleRepo->trash($this->role,$request);
        return \response()->json([
            'status'=>200,
            'data'=>$roles
        ]);
    }
    
    public function rolesUserByName($userId){
       $roles=  $this->roleRepo->rolesUserByNameModel($this->user,$userId);
        //   $arrays[] =  (array) $roles;
       return $roles;
        return \response()->json([
            'status'=>200,
            'data'=>$roles
        ]);
    }
        public function rolesPermissionByName($permissionId){
       $roles=  $this->roleRepo->rolesPermissionByName($this->permission,$permissionId);
        return \response()->json([
            'status'=>200,
            'data'=>$roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        

       $role =  $this->roleRepo->store($request,$this->role);
        return \response()->json([
            'status'=>200,
            'message'=>'stored successfully',
            'roleId'=>$role->id
        ]);
    }

    public function storeTrans(StoreRoleRequest $request,$id,$lang)
    {
        

       $role =  $this->roleRepo->storeTrans($request,$this->role,$id,$lang);
        return \response()->json([
            'status'=>200,
            'message'=>'stored successfully',
            'roleId'=>$role->id
        ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=$this->roleRepo->find($id,$this->role);
        if(empty($role)){
            return \response()->json([
                'status'=>404,
                'data'=>'there is not exit this Role'
            ]);
        }else{
            return \response()->json([
                'status'=>200,
                'data'=>$role
            ]);
        }
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request,$id)
    {
        $this->roleRepo->update($request,$id,$this->role);
        
        return \response()->json([
            'status'=>200,
            'message'=>'updated successfully'
        ]);

    }

    //methods for restoring
    public function restore($id){
        
        $role =  $this->roleRepo->restore($id,$this->role);
        
        if(empty($role)){
         return \response()->json([
             'status'=>404,
             'message'=>'this Role not found in trash to restore it '
         ]);    
        }else{
            return \response()->json([
                'status'=>200,
                'message'=>'restored successfully'
            ]);
        }

    }
    public function restoreAll(){
        $role =  $this->roleRepo->restoreAll($this->role);
        
        if(empty($role)){
         return \response()->json([
             'status'=>404,
             'message'=>' not found any role in trash to restore all it '
         ]);    
        }else{
            return \response()->json([
                'status'=>200,
                'message'=>'restored successfully'
            ]);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteRoleRequest $request,$id)
    {
       $role= $this->roleRepo->destroy($id,$this->role);
       if(empty($role)){//this Role not found in table roles
        return \response()->json([
            'status'=>404,
            'message'=>'this Role not found in table roles '
        ]); 
       }else{
           return \response()->json([
               'status'=>200,
               'message'=>'destroyed  successfully'
           ]);
       }
    }
    public function forceDelete(DeleteRoleRequest $request,$id)
    {
        //to make force destroy for a Role must be this Role  not found in roles table  , must be found in trash roles
        $role=$this->roleRepo->forceDelete($id,$this->role);
        if($role==404){
            return \response()->json([
                'status'=>404,
                'message'=>'this Role not found in roles table and  trash roles to delete it by forcely'
            ]); 
        }elseif($role==200){
            return \response()->json([
                'status'=>200,
                'message'=>'force deleted all successfully'
            ]); 
        }elseif($role==400){
            return \response()->json([
                'status'=>400,
                'message'=>'this Role  found in roles table so you cannt   delete it by forcely , you can delete it Temporarily after that delete it by forcely  '
            ]); 
        }
    }
}
