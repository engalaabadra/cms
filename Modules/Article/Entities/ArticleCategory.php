<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
use App\Models\Image;

class ArticleCategory extends Model
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

        'slug',
        
        'created_at'
    ];
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }

    public function articles(){
        return $this->hasMany(Article::class);
    }
     public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

}
