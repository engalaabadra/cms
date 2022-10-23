<?php
namespace Modules\Staff\Repositories\User;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Staff\Repositories\User\StaffRepositoryInterface;
use Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class StaffRepository extends EloquentRepository implements StaffRepositoryInterface
{
     public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['staffCategory','image'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['staffCategory','image'])->get();
            
        }
       return  $modelData;
   }

 

}
