<?php

namespace Modules\Audio\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Thumb;
use App\Models\Media;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Audio extends Model
{
    
    use SoftDeletes;
        protected $appends = ['original_status'];
    public $table='audios';
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

        'audio_category_id',
        'description',
        'date',
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
    
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
    
    public function audioCategory(){
        return $this->belongsTo(AudioCategory::class);
    }
        public function thumb(){
        return $this->morphOne(Thumb::class, 'thumbable');
    }
        public function media(){
        return $this->morphOne(Media::class, 'mediaable');
    }
}
