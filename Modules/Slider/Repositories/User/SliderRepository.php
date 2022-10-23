<?php
namespace Modules\Slider\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\Slider\Repositories\User\SliderRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class SliderRepository extends EloquentRepository implements SliderRepositoryInterface
{
        public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['image'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['image'])->get();
            
        }
       return  $modelData;
    }

}
