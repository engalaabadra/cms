<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Project extends Model
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
        'project_category_id',
        'body',
        'description',
        'meta_description',
        'meta_keywords',
        'link',
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
    
    public function projectCategory(){
        return $this->belongsTo(ProjectCategory::class);
    }
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function logo(){
        return $this->morphOne(Image::class, 'imageable');
    }
}
