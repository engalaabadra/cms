<?php

namespace Modules\Page\Entities;

use Modules\Page\Entities\PageBannerPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Page\Entities\Page;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;

class PageBanner extends Model
{
    use SoftDeletes;

        protected $appends = ['original_status'];
    /**
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
          'page_id',
        'order',
          'status',
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
      public function page(){
        return $this->belongsTo(Page::class);
    }
    public function pageBannerPhotos(){
        return $this->hasMany(PageBannerPhoto::class);
    }
      }
