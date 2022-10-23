<?php

namespace Modules\Video\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Video\Entities\VideoCategory;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
use App\Models\Thumb;

class Video extends Model
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
        'title',
        'description',
        'video_link',
        'video_category_id',
        'is_featured',
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

    public function videoCategory(){
        return $this->belongsTo(VideoCategory::class);
    }
            public function thumb(){
        return $this->morphOne(Thumb::class, 'thumbable');
    }
}
