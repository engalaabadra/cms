<?php
namespace Modules\Banner\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\Banner\Repositories\User\BannerRepositoryInterface;
class BannerRepository extends EloquentRepository implements BannerRepositoryInterface
{

 public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['image'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['image'])->get();
            
        }
       return  $modelData;
   }

    
}
