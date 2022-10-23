<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Menu extends Model
{
    use SoftDeletes;
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
        'translate_id',
        'name',
        'slug',
        'position',
        'template_id',
        'target',
        'is_external',
        'link_external',       
        'order',
        'status',
        'deleted_at',
        'created_at'
    ];
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
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
    
    // public function position($value){

    //     if($value==0){
    //         return 'Main';
    //     }elseif ($value==1) {
    //         return 'Top';
    //     }elseif ($value==-1) {
    //         return 'Footer';
    //     }
    // }
    // public function getOriginalPositionAttribute($value){
    //   return  $this->attributes['position'];
    // }

    // public function target($value){

    //     if($value==0){
    //         return 'Same Windows';
    //     }elseif ($value==1) {
    //         return 'New Windows';
    //     }
    // }
            public function mainMenu(){
        return $this->belongsTo("Modules\Menu\Entities\Menu",'position');
    }
    public function subMenus(){
        return $this->hasMany("Modules\Menu\Entities\Menu",'position','id');
    }
    
    public function getOriginalTargetAttribute($value){
       return  $this->attributes['target'];
    }

}
