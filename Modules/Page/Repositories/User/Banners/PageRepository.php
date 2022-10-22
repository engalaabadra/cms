<?php
namespace Modules\Page\Repositories\User\Banners;

use App\Repositories\EloquentRepository;

use Modules\Page\Repositories\User\Banners\PageRepositoryInterface;
class PageRepository extends EloquentRepository implements PageRepositoryInterface
{
         public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['page','pageBannerPhotos'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['page','pageBannerPhotos'])->get();
            
        }
       return  $modelData;
   }
}
