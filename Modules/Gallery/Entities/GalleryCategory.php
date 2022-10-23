<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LanguageScope;
class GalleryCategory extends Model
{
    use SoftDeletes;
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
        'deleted_at',
        'created_at'
    ];
  
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }
    
    public function galleryAlbums(){
        return $this->hasMany(GalleryAlbum::class);
    }
}
