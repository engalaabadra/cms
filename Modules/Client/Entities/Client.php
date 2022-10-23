<?php

namespace Modules\Client\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
use Modules\Form\Entities\Form;
class Client extends Model
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
        // 'client_category_id',
        'deleted_at',
        'created_at'
    ];
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }
    // public function clientCategory(){
    //     return $this->belongsTo(ClientCategory::class);
    // }
        public function form(){
        return $this->hasMany(Form::class);
    }
    //         public function infos(){
    //     return $this->hasMany(ClientInfo::class);
    // }
}
