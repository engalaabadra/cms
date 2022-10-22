<?php

namespace Modules\Visit\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\LanguageScope;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
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
        'translate_id',
        'client_id',
        'doctor_name',
        'doctor_no',
        'patient_name',
        'patient_no',
        'date',
        'notes',
        'deleted_at',
        'created_at'
    ];
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }
       
   

    public function client(){
        return $this->belongsTo(Client::class);
    }    
}
