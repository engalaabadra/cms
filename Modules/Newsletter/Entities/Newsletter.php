<?php

namespace Modules\Newsletter\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Newsletter extends Model
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
        'first_name',
        'last_name',
        'email',
        'order',
        'deleted_at',
        'created_at'
    ];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }
}
