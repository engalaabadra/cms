<?php

namespace Modules\Slider\Entities;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
use App\Models\Image;
class Slider extends Model
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
        'title',
        'translate_id',
        'description',
        'link',
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
    // public function sliderPhotos(){
    //     return $this->hasMany(SliderPhoto::class);
    // }
    // public function theme(){
    //     return $this->belongsTo(Theme::class);
    // }
        public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
   
    }
