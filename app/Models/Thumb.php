<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumb extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'thumbable_id',
        'url',
        'thumbable_type'
    ];

    /**
     * Get the parent imageable model 
     */
    public function thumbable()
    {
        // return $this->morphTo(Form::class,'imageable_type','imageable_id');
    }
}
