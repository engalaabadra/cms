<?php
namespace Modules\Gallery\Repositories\Admin\Categories;

use App\Repositories\EloquentRepository;

use Modules\Gallery\Repositories\Admin\Categories\GalleryRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class GalleryRepository extends EloquentRepository implements GalleryRepositoryInterface
{


    public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['galleryAlbums'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['galleryAlbums'])->paginate($request->total);
            
        }
       return  $modelData;
   }
    
}
