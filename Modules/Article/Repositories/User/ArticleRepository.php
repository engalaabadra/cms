<?php
namespace Modules\Article\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\Article\Repositories\User\ArticleRepositoryInterface;
use App\Scopes\ActiveScope;

class ArticleRepository extends EloquentRepository implements ArticleRepositoryInterface
{

 public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['image','articleCategory','image'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['image','articleCategory','image'])->get();
            
        }
       return  $modelData;
   }
}
