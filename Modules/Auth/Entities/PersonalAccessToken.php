<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\SanctumServiceProvider;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    protected $fillable=[
        'name',
        'token',
        'abilities',
        'ip'
    ];
    protected static function booted()
    {
        parent::booted();
        static::creating(function($model){
            $model->ip=request()->ip();
        });
    }
}
