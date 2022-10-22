<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Slider\Entities\SliderPhoto;

class Theme extends Model
{

    public function sliderPhotos(){
        return $this->hasMany(SliderPhoto::class);
    }
}
