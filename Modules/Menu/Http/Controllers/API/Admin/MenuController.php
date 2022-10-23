<?php

namespace Modules\Menu\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Http\Requests\DeleteMenuRequest;
use Modules\Menu\Http\Requests\StoreMenuRequest;
use Modules\Menu\Http\Requests\UpdateMenuRequest;
use Modules\Menu\Repositories\Admin\MenuRepository;

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
        $this->middleware(['permission:menus_read'])->only('index','getAllPaginates','getMainMenus','getSubMenusForMain');
        $this->middleware(['permission:menus_trash'])->only('trash');
        $this->middleware(['permission:menus_restore'])->only('restore');
        $this->middleware(['permission:menus_restore-all'])->only('restore-all');
        $this->middleware(['permission:menus_show'])->only('show');
        $this->middleware(['permission:menus_store'])->only('store');
        $this->middleware(['permission:menus_update'])->only('update');
        $this->middleware(['permission:menus_destroy'])->only('destroy');
        $this->middleware(['permission:menus_destroy-force'])->only('destroy-force');
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
        try{
        $menus=$this->menuRepo->all($this->menu,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menus],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $menus=$this->menuRepo->getAllPaginates($this->menu,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menus],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $menus=$this->menuRepo->trash($this->menu,$request);
      if(is_string($menus)){
            return response()->json(['status'=>false,'message'=>$menus],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menus],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }

     public function getMainMenus(){
                //  try{
        $mainMenus=$this->menuRepo->mainMenus($this->menu);
          return response()->json(['status'=>true,'message'=>config('constants.success'),'data'=>$mainMenus],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>config('constants.error')],500);

        // } 
     }

    public function getSubMenusForMain($menuId){
        try{
        $subMenusForMain=$this->menuRepo->getSubMenusForMain($this->menu,$menuId);
          return response()->json(['status'=>true,'message'=>config('constants.success'),'data'=>$subMenusForMain],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>config('constants.error')],500);

        } 
    
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        // try{
       $menu= $this->menuRepo->store($request,$this->menu);
             if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menu],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    public function storeTrans(StoreMenuRequest $request,$id,$lang)
    {
        // try{
       $menu= $this->menuRepo->storeTrans($request,$this->menu,$id,$lang);
             if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menu],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              try{
        $menu=$this->menuRepo->find($id,$this->menu);
                          if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menu],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request,$id)
    {
        //   try{
       $menu= $this->menuRepo->update($request,$id,$this->menu);
                                 if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menu],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $menu =  $this->menuRepo->restore($id,$this->menu);
                                  if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menu],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $menus =  $this->menuRepo->restoreAll($this->menu);
                                  if(is_string($menus)){
            return response()->json(['status'=>false,'message'=>$menus],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menus],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
        
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteMenuRequest $request,$id)
    {
           try{
       $menu= $this->menuRepo->destroy($id,$this->menu);
                          if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$menu],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteMenuRequest $request,$id)
    {
          try{
        //to make force destroy for a Menu must be this Menu  not found in Menus table  , must be found in trash Menus
        $menu=$this->menuRepo->forceDelete($id,$this->menu);
                          if(is_string($menu)){
            return response()->json(['status'=>false,'message'=>$menu],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
