<?php
namespace Modules\Page\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\Page\Repositories\User\PageRepositoryInterface;
class PageRepository extends EloquentRepository implements PageRepositoryInterface
{


     public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
          $modelData=$model->where(['main_lang'=>$lang])->with(['pageBanners'])->get();
          return $modelData;
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['pageBanners'])->get();
            
        }
       return  $modelData;
   }
}
