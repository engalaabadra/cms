<?php

namespace Modules\Staff\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Staff\Entities\Staff;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class StaffCategory extends Model
{
    use SoftDeletes;
    protected $table='staff_categories';

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
    public function staffs(){
        return $this->hasMany(Staff::class);
    }
    }
