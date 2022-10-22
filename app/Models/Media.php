<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
        public $table='medias';

    use HasFactory;
            /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'mediaable_id',
        'url',
        'mediaable_type'
    ];

    /**
     * Get the parent mediaable model 
     */
    public function mediaable()
    {
        // return $this->morphTo(Form::class,'imageable_type','imageable_id');
    }
}
