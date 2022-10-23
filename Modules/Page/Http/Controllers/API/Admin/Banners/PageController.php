<?php

namespace Modules\Page\Http\Controllers\API\Admin\Banners;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\PageBanner;
use Modules\Page\Http\Requests\Banners\DeletePageRequest;
use Modules\Page\Http\Requests\Banners\StorePageRequest;
use Modules\Page\Http\Requests\Banners\UpdatePageRequest;
use Modules\Page\Repositories\Admin\Banners\PageRepository;

class PageController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var PageBannerRepository
     */
    protected $pageBannerRepo;
    /**
     * @var Page
     */
    protected $pageBanner;
   

    /**
     * PagesController constructor.
     *
     * @param PageBannerRepository $pageCategories
     */
    public function __construct(BaseRepository $baseRepo, PageBanner $pageBanner,PageRepository $pageBannerRepo)
    {
        $this->middleware(['permission:page-banners_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:page-banners_trash'])->only('trash');
        $this->middleware(['permission:page-banners_restore'])->only('restore');
        $this->middleware(['permission:page-banners_restore-all'])->only('restore-all');
        $this->middleware(['permission:page-banners_show'])->only('show');
        $this->middleware(['permission:page-banners_store'])->only('store');
        $this->middleware(['permission:page-banners_update'])->only('update');
        $this->middleware(['permission:page-banners_destroy'])->only('destroy');
        $this->middleware(['permission:page-banners_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->pageBanner = $pageBanner;
        $this->pageBannerRepo = $pageBannerRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $pageCategories=$this->pageBannerRepo->all($this->pageBanner,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageCategories],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $pageCategories=$this->pageBannerRepo->getAllPaginates($this->pageBanner,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageCategories],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $pageCategories=$this->pageBannerRepo->trash($this->pageBanner,$request);
                if(is_string($pageCategories)){
            return response()->json(['status'=>false,'message'=>$pageCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageCategories],200);

        
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
       $pageBanner= $this->pageBannerRepo->store($request,$this->pageBanner);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageBanner->load(['pageBannerPhotos','page'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    public function storeTrans(StorePageRequest $request,$id,$lang)
    {
        try{
       $pageBanner= $this->pageBannerRepo->storeTrans($request,$this->pageBanner,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageBanner->load(['pageBannerPhotos','page'])],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
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
        $pageBanner=$this->pageBannerRepo->find($id,$this->pageBanner);
                          if(is_string($pageBanner)){
            return response()->json(['status'=>false,'message'=>$pageBanner],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageBanner->load(['pageBannerPhotos','page'])],200);

        
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
       $pageBanner= $this->pageBannerRepo->update($request,$id,$this->pageBanner);
                                 if(is_string($pageBanner)){
            return response()->json(['status'=>false,'message'=>$pageBanner],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageBanner->load(['pageBannerPhotos','page'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $pageBanner =  $this->pageBannerRepo->restore($id,$this->pageBanner);
                                  if(is_string($pageBanner)){
            return response()->json(['status'=>false,'message'=>$pageBanner],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageBanner->load(['pageBannerPhotos','page'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $pageCategories =  $this->pageBannerRepo->restoreAll($this->pageBanner);
                                  if(is_string($pageCategories)){
            return response()->json(['status'=>false,'message'=>$pageCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageCategories],200);

        
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
       $pageBanner= $this->pageBannerRepo->destroy($id,$this->pageBanner);
                          if(is_string($pageBanner)){
            return response()->json(['status'=>false,'message'=>$pageBanner],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageBanner->load('pageBannerPhotos')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeletePageRequest $request,$id)
    {
        //   try{
        //to make force destroy for a Page must be this Page  not found in Pages table  , must be found in trash Pages
        $pageBanner=$this->pageBannerRepo->forceDelete($id,$this->pageBanner);
                          if(is_string($pageBanner)){
            return response()->json(['status'=>false,'message'=>$pageBanner],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
    
}
