<?php
namespace Modules\Activity\Repositories\Admin;

use App\Repositories\EloquentRepository;

use Modules\Activity\Repositories\Admin\ActivityRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class ActivityRepository extends EloquentRepository implements ActivityRepositoryInterface
{

    public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with('user')->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with('user')->paginate($request->total);
            
        }
       return  $modelData;
   }
    
}
