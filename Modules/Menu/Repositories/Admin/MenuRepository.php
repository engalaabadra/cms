<?php
namespace Modules\Menu\Repositories\Admin;

use App\Repositories\EloquentRepository;

use Modules\Menu\Repositories\Admin\MenuRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class MenuRepository extends EloquentRepository implements MenuRepositoryInterface
{
public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['mainMenu','subMenus'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['mainMenu','subMenus'])->paginate($request->total);
            
        }
       return  $modelData;
   }
 public function mainMenus($model){
          $mainCategories=$model->withoutGlobalScope(ActiveScope::class)->where(['target'=>null])->get();
        return $mainCategories;
    }
        public function getSubMenusForMain($model,$menuId){
        $modelData=$model->withoutGlobalScope(ActiveScope::class)->where('target',$menuId)->with('mainMenu')->get();
          return  $modelData;
    }

    
}
