<?php
namespace Modules\Menu\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\Menu\Repositories\User\MenuRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class MenuRepository extends EloquentRepository implements MenuRepositoryInterface
{
    // public function getAllPaginates($model,$request){
    // $modelData=$model->with(['mainMenu','subMenus'])->paginate($request->total);
    //   return  $modelData;
   
    // }
    public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->with(['mainMenu','subMenus'])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->with(['mainMenu','subMenus'])->get();
            
        }
       return  $modelData;
    }
    public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['mainMenu','subMenus'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['mainMenu','subMenus'])->paginate($request->total);
            
        }
       return  $modelData;
   }
     public function mainMenus($model,$lang){
        //  dd(config('languages'));
           $result=array_key_exists($lang, config('languages'));
        //   dd($result);
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->where(['target'=>null])->get();
           // dd($lang);
          
        }else{

            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->where(['target'=>null])->get();
        }
       return  $modelData;
    }
            public function getSubMenusForMain($model,$menuId,$lang){
                           $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->where('target',$menuId)->with('mainMenu')->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->where('target',$menuId)->with('mainMenu')->get();
            
     
       }
           return  $modelData;

                
            }


}
