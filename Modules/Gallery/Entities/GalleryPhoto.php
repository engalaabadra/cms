<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class GalleryPhoto extends Model
{
 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gallery_image_id',
        'filename',
    ];
    protected static function boot(){
        parent::boot();
    }
    public function galleryImage(){
        return $this->belongsTo(GalleryImage::class);
    }
}
