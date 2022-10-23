<?php
namespace App\Repositories;

use App\Repositories\BaseRepositoryInterface;
use App\Models\User;
use Modules\Auth\Repositories\User\UserRepository;
use Modules\Auth\Repositories\Role\RoleRepository;
use App\Providers\RouteServiceProvider;
use App\Repositories\EloquentRepository;

class BaseRepository extends EloquentRepository implements BaseRepositoryInterface
{
    /**
     * @var UserRepository
     */
    protected $userRepo;
    /**
     * @var RoleRepository
     */
    protected $roleRepo;
    /**
     * @var User
     */
    protected $user;
    /**
     * BaseRepository constructor.
     *
     */
    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, User $user)
    {
        $this->user = $user;
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;

    }
    public function globalVars(){
        $success=trans('messages.Operation has been successfully');
        $error=trans('messages.Something went wrong');
        $vars=[
            'success'=>$success,
            'error'=>$error,
        ];
        return $vars;

    }
    public function redirectTo(){
        $user=User::find(auth()->user()->id);
        $rolesUser= $user->roles->pluck('name')->toArray();
        $existRoleSuperadministrator=  in_array('superadministrator',$rolesUser);
        if ( $existRoleSuperadministrator==true) {
            return route(RouteServiceProvider::DASHBOARD);
        }else{
            return route(RouteServiceProvider::HOME);
        }
    }

    public function authorize(){
        $user= $this->find(auth()->user()->id,$this->user);
        $rolesUser=$this->roleRepo->rolesUserByName($user);
        $existRoleSuperadministrator=  in_array('superadministrator',$rolesUser);
        if($existRoleSuperadministrator==true){
            return true;
        }else{
            return false;
        }
    }
    public function authorizeSuperAndAdmin(){
        $user= $this->find(auth()->user()->id,$this->user);
        $rolesUser=$this->roleRepo->rolesUserByName($user);
        $existRoleadministrator=  in_array('administrator',$rolesUser);
        $existSuperRole=  in_array('superadministrator',$rolesUser);
        if($existSuperRole==true||$existRoleadministrator==true){
            return true;
        }else{
            return false;
        }
    }  
    public function authorizeSuperAndDelegate(){
        $user= $this->find(auth()->user()->id,$this->user);
        $rolesUser=$this->roleRepo->rolesUserByName($user);
        $existRoledelegate=  in_array('delegate',$rolesUser);
        $existSuperRole=  in_array('superadministrator',$rolesUser);
        if($existSuperRole==true||$existRoledelegate==true){
            return true;
        }else{
            return false;
        }
    }    
    public function authorizeSuperAndChargingEmployee(){
        $user= $this->find(auth()->user()->id,$this->user);
        $rolesUser=$this->roleRepo->rolesUserByName($user);
        $existRolechargingEmployee=  in_array('chargingEmployee',$rolesUser);
        $existSuperRole=  in_array('superadministrator',$rolesUser);
        if($existSuperRole==true||$existRolechargingEmployee==true){
            return true;
        }else{
            return false;
        }
    }
    public function authorizeSuperAndTraveler(){
        $user= $this->find(auth()->user()->id,$this->user);
        $rolesUser=$this->roleRepo->rolesUserByName($user);
        $existRoletraveler=  in_array('traveler',$rolesUser);
        $existSuperRoletaraveler=  in_array('superadministrator',$rolesUser);
        if($existSuperRoletaraveler==true||$existRoletraveler==true){
            return true;
        }else{
            return false;
        }
    }
        public function authorizeSuperAndDriver(){
        $user= $this->find(auth()->user()->id,$this->user);
        $rolesUser=$this->roleRepo->rolesUserByName($user);
        $existRoletraveler=  in_array('driver',$rolesUser);
        $existSuperRoletaraveler=  in_array('superadministrator',$rolesUser);
        if($existSuperRoletaraveler==true||$existRoletraveler==true){
            return true;
        }else{
            return false;
        }
    }

    public function getStatuses(){
        $statusCollection=collect([
            ['id'=>0,'status'=>'InActive'],
            ['id'=>1,'status'=>'Active']
           ]);
        return $statusCollection->pluck('id');
    }


    
}