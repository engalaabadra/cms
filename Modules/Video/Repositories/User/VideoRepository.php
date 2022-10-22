<?php
namespace Modules\Video\Repositories\User;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Video\Repositories\User\VideoRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class VideoRepository extends EloquentRepository implements VideoRepositoryInterface
{


     public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['videoCategory','thumb'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['videoCategory','thumb'])->get();
            
        }
       return  $modelData;
   }
   
}
