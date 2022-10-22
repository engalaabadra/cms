<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Entities\Role;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use App\Scopes\ActiveScope;
// use App\Scopes\LanguageScope;
class User extends Authenticatable
{
    use LaratrustUserTrait,HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
        protected $appends = ['original_status'];

            /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'locale'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'main_lang',
        'translate_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
        'deleted_at'
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];
    //  protected static function boot(){
    //     parent::boot();
    //     static::addGlobalScope(new ActiveScope);
    //     static::addGlobalScope(new LanguageScope);
    // }
    
    public function roles(){
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }
    public function permissions(){
        return $this->belongsToMany("Modules\Auth\Entities\Permission",'permission_user','user_id','permission_id');
    }
  
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getDocumentationAttribute(){
       return  $this->attributes['documentation'];
    }
    public function getOriginalDocumentationAttribute(){
        $value=$this->attributes['documentation'];
        if($value==0){
            return 'Pending';
        }elseif ($value==1) {
            return 'Verified';
        }elseif ($value==-1) {
            return 'Reject Verification';
        }
    }

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
}
