<?php

namespace Modules\Slider\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SliderPhoto extends Model
{
/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slider_id',
        'filename'
    ];

    public function slider(){
        return $this->belongsTo(Slider::class);
    }
}
