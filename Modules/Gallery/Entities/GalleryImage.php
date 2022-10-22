<?php

namespace Modules\Gallery\Entities;

use Modules\Gallery\Entities\GalleryPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Gallery\Entities\GalleryAlbum;
use App\Scopes\LanguageScope;
class GalleryImage extends Model
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
        'gallery_album_id',
                'order',

        'date',
        'deleted_at',
        'created_at'
    ];

    public function getStatusAttribute($value){
       return  $this->attributes['status'];
    }
    public function getOriginalStatusAttribute($value){
        if($value==0){
            return 'Not Active';
        }elseif ($value==1) {
            return 'Active';
        }
    }
    
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }
    
    public function galleryAlbum(){
        return $this->belongsTo(GalleryAlbum::class);
    }
    public function galleryPhotos(){
        return $this->hasMany(GalleryPhoto::class);
    }


}
