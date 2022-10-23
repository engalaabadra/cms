<?php

namespace Modules\Menu\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Repositories\User\MenuRepository;

class MenuController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var MenuRepository
     */
    protected $menuRepo;
    /**
     * @var Menu
     */
    protected $menu;
   

    /**
     * MenusController constructor.
     *
     * @param MenuRepository $menus
     */
    public function __construct(BaseRepository $baseRepo, Menu $menu,MenuRepository $menuRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->menu = $menu;
        $this->menuRepo = $menuRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $menus=$this->menuRepo->all($this->menu,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menus],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // }
    }
    
    
     public function getMainMenus($lang=null){
                //  try{
        $mainMenus=$this->menuRepo->mainMenus($this->menu,$lang);
          return response()->json(['status'=>true,'message'=>config('constants.success'),'data'=>$mainMenus],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>config('constants.error')],500);

        // } 
     }

    public function getSubMenusForMain($menuId,$lang=null){
        try{
        $subMenusForMain=$this->menuRepo->getSubMenusForMain($this->menu,$menuId,$lang);
          return response()->json(['status'=>true,'message'=>config('constants.success'),'data'=>$subMenusForMain],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>config('constants.error')],500);

        } 
    
    }
      
    
}
