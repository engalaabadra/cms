<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Template extends Model
{
    use SoftDeletes;

        protected $appends = ['original_status','have_sub'];
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
        'main_value',
        'value',
        'main_model',
        'model',
        'have_sub',
        'date',
        'order',
        'status',
        'deleted_at',
        'created_at'
    ];
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
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

    public function getHaveSubAttribute(){
       return  $this->attributes['have_sub'];
    }
    public function getOriginalHaveSubAttribute(){
        $value=$this->attributes['have_sub'];
        if($value==0){
            return 'No';
        }elseif ($value==1) {
            return 'Yes';
        }
    }
}
