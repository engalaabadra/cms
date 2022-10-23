<?php

namespace Modules\Staff\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Staff\Entities\StaffCategory;
use App\Models\Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class Staff extends Model
{
    use SoftDeletes;
    
        protected $appends = ['original_status'];
    protected $table='staffs';
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
        'staff_category_id',
        'body',
        'job',
        'description',
        'order',
        'status',
        'deleted_at',
        'created_at'
    ];
        protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
     public function getStatusAttribute(){
        return  $this->attributes['status'];
        
    }
    public function getOriginalStatusAttribute(){
        $value=$this->attributes['status'];
        if($value==0){
            return 'InActive';
        }elseif($value==1) {
            return 'Active';
        }
    } 
    public function staffCategory(){
        return $this->belongsTo(StaffCategory::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }
}
