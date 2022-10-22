<?php
namespace Modules\Gallery\Repositories\User\Images;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Gallery\Repositories\User\Images\GalleryRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class GalleryRepository extends EloquentRepository implements GalleryRepositoryInterface
{


        public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['galleryAlbum','galleryAlbum.image','galleryPhotos'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['galleryAlbum','galleryAlbum.image','galleryPhotos'])->get();
            
        }
       return  $modelData;
   }

}
