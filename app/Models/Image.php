<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Profile\Entities\Profile;
use App\Models\User;
use Modules\Form\Entities\Form;
class Image extends Model
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
        // return $this->morphTo(::class,'imageable_type','imageable_id');
    }
}

