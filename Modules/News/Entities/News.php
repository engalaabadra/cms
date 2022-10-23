<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class News extends Model
{
    use SoftDeletes;
    protected $table='news';
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
        'description',
        'translate_id',
        'news_category_id',
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
    
    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
    public function newsCategory(){
        return $this->belongsTo(NewsCategory::class);
    }
    
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
    

}
