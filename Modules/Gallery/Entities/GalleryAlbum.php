<?php

namespace Modules\Gallery\Entities;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Gallery\Entities\GalleryCategory;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class GalleryAlbum extends Model
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
        'gallery_category_id',
        'date',
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
    public function galleryCategory(){
        return $this->belongsTo(GalleryCategory::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
    
    public function galleryImages(){
        return $this->hasMany(GalleryImage::class);
    }
}
