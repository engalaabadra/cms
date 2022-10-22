<?php
namespace Modules\Auth\Repositories\Permission;

use App\Repositories\EloquentRepository;
use Modules\Auth\Entities\Permission;
use Modules\Auth\Repositories\Permission\PermissionRepositoryInterface;
class PermissionRepository extends EloquentRepository implements PermissionRepositoryInterface
{
    /**
     * @var EloquentRepository
     */
    protected $eloquentRepo;
        /**
     * @var Permission
     */
    protected $permission;
    public function __construct(EloquentRepository $eloquentRepo,Permission $permission)
    {
        $this->eloquentRepo = $eloquentRepo;
        $this->permission = $permission;
    }
       public function getAllPaginates($model,$request){
    $modelData=$model->where('main_lang',config('app.locale'))->paginate($request->total);
       return  $modelData;
   
    }
    public function PermissionsUser($user){
        $permissionsUser= $user->permissions->pluck('id')->toArray();
        return $permissionsUser;
    }
    public function PermissionsRole($role){
        $permissionsRole= $role->permissions->pluck('id')->toArray();
        return $permissionsRole;
    }
        public function permissionsRoleByName($model,$roleId){
            $role=$model->find($roleId);
        $permissionsRole= $role->permissions()->get();
        return $permissionsRole;
    }


     public function storePermissionForModule($request,$model){
        $data=$request->validated();//name per , module name , display name , dec
        $countNamesPermissionsForModule=$model->where(['name'=>$data['name'],'module_name'=>$data['module_name']])->count();
        if($countNamesPermissionsForModule!==0){
            return false;
        }else{
             $model->create($data);
          //  if($request->roles){
            //    $item->roles()->attach($data['roles']);
            //}
            return true;
        }
    }
    public function storePermissionForRole($request,$model){
        //name per , module name , display name , dec
        $data=$request->validated();//roles,status

        $item= $model->create($data);
        if($request->roles){
            $item->roles()->attach($data['roles']);
        }
            return $item;
        
    }
    public function update($request,$id,$model){

        $item=$this->find($id,$model);
        $item->update($request->validated());
        if($request->roles){
            $item->roles()->sync($request->roles);
        }
        return $item;
    }

    // methods overrides

    public function forceDelete($id,$model){
          //to make force destroy for an item must be this item  not found in items table  , must be found in trash items
          $itemInTableitems = $this->find($id,$model);//find this item from  table items
          if(empty($itemInTableitems)){//this item not found in items table
              $itemInTrash= $this->findItemOnlyTrashed($id,$model);//find this item from trash 
              if(empty($itemInTrash)){//this item not found in trash items
                  return 404;
              }else{
                if($itemInTrash->roles){
                    $itemInTrash->roles()->detach($itemInTrash->roles);
                }
                  $itemInTrash->forceDelete();
                  return 200;
              }
          }else{
              return 400;
          }
  
    }
}
