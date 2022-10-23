<?php

namespace Modules\Audio\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Audio\Entities\Audio;
use App\Scopes\LanguageScope;
class AudioCategory extends Model
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
      public function audios(){
          return $this->hasMany(Audio::class);
      }

    }
    
