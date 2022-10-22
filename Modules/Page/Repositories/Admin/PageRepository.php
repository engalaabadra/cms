<?php
namespace Modules\Page\Repositories\Admin;

use App\Repositories\EloquentRepository;

use Modules\Page\Repositories\Admin\PageRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class PageRepository extends EloquentRepository implements PageRepositoryInterface
{


    public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['pageAccordions','pageBanners'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['pageAccordions','pageBanners'])->paginate($request->total);
            
        }
       return  $modelData;
   }
        public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['pageAccordions','pageBanners'])->paginate($request->total);
         return $modelData;
     }
    
}
