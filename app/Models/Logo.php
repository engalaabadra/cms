<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'imageable_id',
        'imageable_type'
    ];

    /**
     * Get the parent imageable model 
     */
    public function imageable()
    {
        // return $this->morphTo(Form::class,'imageable_type','imageable_id');
    }
}
