<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustPermission;
class Permission extends LaratrustPermission 
{
    // use SoftDeletes;

        protected $appends = ['original_status'];
        protected $hidden = ['locale'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'main_lang',
        'name',
                'translate_id',

        'display_name',
        'description',
        'status'
    ];
    public $guarded = [];
          public function getStatusAttribute(){
        return  $this->attributes['status'];
        
    }
    public function getOriginalStatusAttribute(){
        $value=$this->attributes['status'];
        if($value==0){
            return 'InActive';
        }elseif($value==1) {
            return 'Active';
        }
    } 
    public function roles(){
        return $this->belongsToMany("Modules\Auth\Entities\Role",'permission_role','permission_id','role_id');
    }
    public function users(){
        return $this->belongsToMany("App\Models\User",'permission_user','permission_id','user_id');
    }

}
