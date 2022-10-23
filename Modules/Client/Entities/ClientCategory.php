<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class ClientCategory extends Model
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
          'slug',
          'created_at'
      ];
          protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
  
      public function clients(){
          return $this->hasMany(Client::class);
      }
      
}
