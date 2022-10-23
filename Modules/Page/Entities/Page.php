<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Page\Entities\PageAccordion;
use Modules\Page\Entities\PageBanner;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Page extends Model
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
        'body',
        'page_url',
        'page_accordion_id',
        'page_banner_id',
        'date',
        'meta_description',
        'meta_keywords',
        'order',
        'status',
        'static',
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
         public function getStaticAttribute(){
        return  $this->attributes['static'];
        
    }
    public function getOriginalStaticAttribute(){
        $value=$this->attributes['static'];
        if($value==0){
            return 'No';
        }elseif($value==1) {
            return 'Yes';
        }
    } 
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
    public function pageAccordions(){
        return $this->hasMany(PageAccordion::class);
    }

    public function pageBanners(){
        return $this->hasMany(PageBanner::class);
    }
    
}
