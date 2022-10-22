<?php

namespace Modules\Page\Http\Controllers\API\Admin\Accordions;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\PageAccordion;
use Modules\Page\Http\Requests\Accordions\DeletePageRequest;
use Modules\Page\Http\Requests\Accordions\StorePageRequest;
use Modules\Page\Http\Requests\Accordions\UpdatePageRequest;
use Modules\Page\Repositories\Admin\Accordions\PageRepository;

class PageController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var PageRepository
     */
    protected $pageAccordionRepo;
    /**
     * @var Page
     */
    protected $pageAccordion;
   

    /**
     * PagesController constructor.
     *
     * @param PageRepository $pageAccordions
     */
    public function __construct(BaseRepository $baseRepo, PageAccordion $pageAccordion,PageRepository $pageAccordionRepo)
    {
        $this->middleware(['permission:page-accordions_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:page-accordions_trash'])->only('trash');
        $this->middleware(['permission:page-accordions_restore'])->only('restore');
        $this->middleware(['permission:page-accordions_restore-all'])->only('restore-all');
        $this->middleware(['permission:page-accordions_show'])->only('show');
        $this->middleware(['permission:page-accordions_store'])->only('store');
        $this->middleware(['permission:page-accordions_update'])->only('update');
        $this->middleware(['permission:page-accordions_destroy'])->only('destroy');
        $this->middleware(['permission:page-accordions_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->pageAccordion = $pageAccordion;
        $this->pageAccordionRepo = $pageAccordionRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $pageAccordions=$this->pageAccordionRepo->all($this->pageAccordion,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordions],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request){
        
         try{
        $pageAccordions=$this->pageAccordionRepo->getAllPaginates($this->pageAccordion,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordions],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $pageAccordions=$this->pageAccordionRepo->trash($this->pageAccordion,$request);
                if(is_string($pageAccordions)){
            return response()->json(['status'=>false,'message'=>$pageAccordions],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordions],200);

        
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
       $pageAccordion= $this->pageAccordionRepo->store($request,$this->pageAccordion);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordion->load('page')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StorePageRequest $request,$id,$lang)
    {
        // try{
       $pageAccordion= $this->pageAccordionRepo->store($request,$this->pageAccordion,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordion->load('page')],200);

        
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
        $pageAccordion=$this->pageAccordionRepo->find($id,$this->pageAccordion);
                          if(is_string($pageAccordion)){
            return response()->json(['status'=>false,'message'=>$pageAccordion],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordion->load('page')],200);

        
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
          try{
       $pageAccordion= $this->pageAccordionRepo->update($request,$id,$this->pageAccordion);
                                 if(is_string($pageAccordion)){
            return response()->json(['status'=>false,'message'=>$pageAccordion],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordion->load('page')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $pageAccordion =  $this->pageAccordionRepo->restore($id,$this->pageAccordion);
                                  if(is_string($pageAccordion)){
            return response()->json(['status'=>false,'message'=>$pageAccordion],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordion->load('page')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $pageAccordions =  $this->pageAccordionRepo->restoreAll($this->pageAccordion);
                                  if(is_string($pageAccordions)){
            return response()->json(['status'=>false,'message'=>$pageAccordions],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordions],200);

        
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
       $pageAccordion= $this->pageAccordionRepo->destroy($id,$this->pageAccordion);
                          if(is_string($pageAccordion)){
            return response()->json(['status'=>false,'message'=>$pageAccordion],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageAccordion->load('page')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeletePageRequest $request,$id)
    {
          try{
        //to make force destroy for a Page must be this Page  not found in Pages table  , must be found in trash Pages
        $pageAccordion=$this->pageAccordionRepo->forceDelete($id,$this->pageAccordion);
                          if(is_string($pageAccordion)){
            return response()->json(['status'=>false,'message'=>$pageAccordion],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
