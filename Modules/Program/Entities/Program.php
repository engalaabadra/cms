<?php

namespace Modules\Program\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Program extends Model
{
    use SoftDeletes;
        protected $appends = ['original_status','original_is_featured'];
        protected $hidden = ['locale'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'main_lang',
        'title',
        'translate_id',
        'program_category_id',
        'description',
        'meta_description',
        'body',
        'meta_keywords',
        'date',
        'order',
        'status',
        'is_featured',
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
    
    public function getIsFeaturedAttribute(){
       return  $this->attributes['is_featured'];
    }
    public function getOriginalIsFeaturedAttribute(){
        $value=$this->attributes['is_featured'];
        if($value==0){
            return 'Not Feature';
        }elseif ($value==1) {
            return 'Featured';
        }
    }
    public function programCategory(){
        return $this->belongsTo(ProgramCategory::class);
    }
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
}
