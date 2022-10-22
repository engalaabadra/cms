<?php

namespace Modules\Auth\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\Permission\StoreRoleRequest;
use Modules\Auth\Http\Requests\Permission\UpdateRoleRequest;
use Modules\Auth\Http\Requests\Permission\DeleteRoleRequest;
use Modules\Auth\Repositories\Permission\RoleRepository;
use App\Repositories\EloquentRepository;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Entities\Role;
use Modules\Auth\Http\Requests\Permission\DeletePermissionRequest;
use Modules\Auth\Http\Requests\Permission\StorePermissionRequest;
use Modules\Auth\Http\Requests\Permission\UpdatePermissionRequest;
use Modules\Auth\Repositories\Permission\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepo;

    /**
     * @var Permission
     */
    protected $permission;
    
    /**
     * @var Role
     */
    protected $role;

    
    /**
     * rolesController constructor.
     *
     * @param RoleRepository $roles
     */
    public function __construct(PermissionRepository $permissionRepo, Permission $permission,Role $role)
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
        $this->permissionRepo = $permissionRepo;
        $this->permission = $permission;
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $roles=$this->permissionRepo->all($this->permission);
        return \response()->json([
            'status'=>200,
            'data'=>$roles
        ]);
    }
        public function getAllPermissionsPaginate(Request $request){
        
        $permissions=$this->permissionRepo->getAllPermissionsPaginate($this->permission,$request);
        return \response()->json([
            'status'=>200,
            'data'=>$permissions
        ]);
    }
    public function trash(Request $request){
        $permissions=$this->permissionRepo->trash($this->permission,$request);

        return \response()->json([
            'status'=>200,
            'data'=>$permissions
        ]);
    }

        public function permissionsRoleByName($roleId){
       $roles=  $this->permissionRepo->permissionsRoleByName($this->role,$roleId);
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
    public function store(StorePermissionRequest $request)
    {
     $this->permissionRepo->store($request,$this->permission);

            return \response()->json([
                'status'=>200,
                'message'=>'stored  permission for module successfully'
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
        $permission=$this->permissionRepo->find($id,$this->permission);
        if(empty($permission)){
            return \response()->json([
                'status'=>404,
                'data'=>'there is not exit this Permission'
            ]);
        }else{
            return \response()->json([
                'status'=>200,
                'data'=>$permission
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
    public function update(UpdatePermissionRequest $request,$id)
    {
        $this->permissionRepo->update($request,$id,$this->permission);
        
        return \response()->json([
            'status'=>200,
            'message'=>'updated successfully'
        ]);

    }

    //methods for restoring
    public function restore($id){
        
        $permission =  $this->permissionRepo->restore($id,$this->permission);
        
        if(empty($permission)){
         return \response()->json([
             'status'=>404,
             'message'=>'this Permission not found in trash to restore it '
         ]);    
        }else{
            return \response()->json([
                'status'=>200,
                'message'=>'restored successfully'
            ]);
        }

    }
    public function restoreAll(){
        $permission =  $this->permissionRepo->restoreAll($this->permission);
        
        if(empty($permission)){
         return \response()->json([
             'status'=>404,
             'message'=>' not found any Permission in trash to restore all it '
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
    public function destroy(DeletePermissionRequest $request,$id)
    {
       $permission= $this->permissionRepo->destroy($id,$this->permission);
       if(empty($permission)){//this Permission not found in table roles
        return \response()->json([
            'status'=>404,
            'message'=>'this Permission not found in table roles '
        ]); 
       }else{
           return \response()->json([
               'status'=>200,
               'message'=>'destroyed  successfully'
           ]);
       }
    }
    public function forceDelete(DeletePermissionRequest $request,$id)
    {
        //to make force destroy for a Permission must be this Permission  not found in roles table  , must be found in trash roles
        $permission=$this->permissionRepo->forceDelete($id,$this->permission);
        if($permission==404){
            return \response()->json([
                'status'=>404,
                'message'=>'this Permission not found in roles table and  trash roles to delete it by forcely'
            ]); 
        }elseif($permission==200){
            return \response()->json([
                'status'=>200,
                'message'=>'force deleted all successfully'
            ]); 
        }elseif($permission==400){
            return \response()->json([
                'status'=>400,
                'message'=>'this Permission  found in roles table so you cannt   delete it by forcely , you can delete it Temporarily after that delete it by forcely  '
            ]); 
        }
    }
}
