<?php

namespace Modules\Add\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Media;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Add extends Model
{
    
    use SoftDeletes;
        protected $appends = ['original_status','type'];
    public $table='adds';
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
        'type',
        'link',
        'body',
        'start_date',
        'end_date',
        'order',
        'status',
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
        public function getTypeAttribute($value){
       return  $this->attributes['type'];
    }
    public function getOriginalTypeAttribute($value){
        if($value==0){
            return 'Image';
        }elseif ($value==1) {
            return 'Video';
        }
    }
    
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }

        public function media(){
        return $this->morphOne(Media::class, 'mediaable');
    }

}
