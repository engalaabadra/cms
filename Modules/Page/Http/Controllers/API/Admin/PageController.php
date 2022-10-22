<?php

namespace Modules\Page\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\DeletePageRequest;
use Modules\Page\Http\Requests\StorePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\Admin\PageRepository;

class PageController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var PageRepository
     */
    protected $pageRepo;
    /**
     * @var Page
     */
    protected $page;
   

    /**
     * PagesController constructor.
     *
     * @param PageRepository $pages
     */
    public function __construct(BaseRepository $baseRepo, Page $page,PageRepository $pageRepo)
    {
        $this->middleware(['permission:pages_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:pages_trash'])->only('trash');
        $this->middleware(['permission:pages_restore'])->only('restore');
        $this->middleware(['permission:pages_restore-all'])->only('restore-all');
        $this->middleware(['permission:pages_show'])->only('show');
        $this->middleware(['permission:pages_store'])->only('store');
        $this->middleware(['permission:pages_update'])->only('update');
        $this->middleware(['permission:pages_destroy'])->only('destroy');
        $this->middleware(['permission:pages_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->page = $page;
        $this->pageRepo = $pageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $pages=$this->pageRepo->all($this->page,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pages],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $pages=$this->pageRepo->getAllPaginates($this->page,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pages],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $pages=$this->pageRepo->trash($this->page,$request);
                                  if(is_string($pages)){
            return response()->json(['status'=>false,'message'=>$pages],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pages],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        // try{
       $page= $this->pageRepo->store($request,$this->page);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$page],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    public function storeTrans(StorePageRequest $request,$id,$lang)
    {
        // try{
       $page= $this->pageRepo->storeTrans($request,$this->page,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$page],200);

        
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
        $page=$this->pageRepo->find($id,$this->page);
                          if(is_string($page)){
            return response()->json(['status'=>false,'message'=>$page],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$page],200);

        
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
    public function update(UpdatePageRequest $request,$id)
    {
         // try{
       $page= $this->pageRepo->update($request,$id,$this->page);
                                 if(is_string($page)){
            return response()->json(['status'=>false,'message'=>$page],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$page],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $page =  $this->pageRepo->restore($id,$this->page);
                                  if(is_string($page)){
            return response()->json(['status'=>false,'message'=>$page],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$page],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $pages =  $this->pageRepo->restoreAll($this->page);
                                  if(is_string($pages)){
            return response()->json(['status'=>false,'message'=>$pages],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pages],200);

        
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
    public function destroy(DeletePageRequest $request,$id)
    {
           try{
       $page= $this->pageRepo->destroy($id,$this->page);
                          if(is_string($page)){
            return response()->json(['status'=>false,'message'=>$page],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$page],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeletePageRequest $request,$id)
    {
          try{
        //to make force destroy for a Page must be this Page  not found in Pages table  , must be found in trash Pages
        $page=$this->pageRepo->forceDelete($id,$this->page);
                          if(is_string($page)){
            return response()->json(['status'=>false,'message'=>$page],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
