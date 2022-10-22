<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Article extends Model
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
        'article_category_id',
        'date',
        'order',
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
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
    public function articleCategory(){
        return $this->belongsTo(ArticleCategory::class);
    }
    
  public function articleSimilars(){
        return $this->hasMany("Modules\Article\Entities\ArticleSimilar",'article_id');
    }
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
    

}
