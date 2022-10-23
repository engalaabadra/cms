<?php
namespace Modules\Add\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\Add\Repositories\User\AddRepositoryInterface;
class AddRepository extends EloquentRepository implements AddRepositoryInterface
{
 public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['media'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['media'])->get();
            
        }
       return  $modelData;
   }
}
