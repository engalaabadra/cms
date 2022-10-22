<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBannerPhoto extends Model
{
/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_banner_id',
        'filename'
    ];

    public function pageBanner(){
        return $this->belongsTo(PageBanner::class);
    }
}
