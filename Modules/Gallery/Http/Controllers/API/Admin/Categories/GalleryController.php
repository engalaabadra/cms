<?php

namespace Modules\Gallery\Http\Controllers\API\Admin\Categories;

use Modules\Gallery\Entities\GalleryCategory;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Http\Requests\Categories\DeleteGalleryRequest;
use Modules\Gallery\Http\Requests\Categories\StoreGalleryRequest;
use Modules\Gallery\Http\Requests\Categories\UpdateGalleryRequest;
use Modules\Gallery\Repositories\Admin\Categories\GalleryRepository;

class GalleryController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var GalleryRepository
     */
    protected $galleryCategoryRepo;
    /**
     * @var Page
     */
    protected $galleryCategory;
   

    /**
     * PagesController constructor.
     *
     * @param GalleryCategoryRepository $galleyCategories
     */
    public function __construct(BaseRepository $baseRepo, GalleryCategory $galleryCategory,GalleryRepository $galleryCategoryRepo)
    {
        // $this->middleware(['permission:gallery-categories_read'])->only('index','getAllPaginates');
        // $this->middleware(['permission:gallery-categories_trash'])->only('trash');
        // $this->middleware(['permission:gallery-categories_restore'])->only('restore');
        // $this->middleware(['permission:gallery-categories_restore-all'])->only('restore-all');
        // $this->middleware(['permission:gallery-categories_show'])->only('show');
        // $this->middleware(['permission:gallery-categories_store'])->only('store');
        // $this->middleware(['permission:gallery-categories_update'])->only('update');
        // $this->middleware(['permission:gallery-categories_destroy'])->only('destroy');
        // $this->middleware(['permission:gallery-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->galleryCategory = $galleryCategory;
        $this->galleryCategoryRepo = $galleryCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $galleyCategories=$this->galleryCategoryRepo->all($this->galleryCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyCategories],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $galleyCategories=$this->galleryCategoryRepo->getAllPaginates($this->galleryCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyCategories],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $galleyCategories=$this->galleryCategoryRepo->trash($this->galleryCategory,$request);
                if(is_string($galleyCategories)){
            return response()->json(['status'=>false,'message'=>$galleyCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyCategories],200);

        
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
    public function store(StoreGalleryRequest $request)
    {
        // try{
       $galleryCategory= $this->galleryCategoryRepo->store($request,$this->galleryCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryCategory],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreGalleryRequest $request,$id,$lang)
    {
        // try{
       $galleryCategory= $this->galleryCategoryRepo->storeTrans($request,$this->galleryCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryCategory],200);

        
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
        $galleryCategory=$this->galleryCategoryRepo->find($id,$this->galleryCategory);
                          if(is_string($galleryCategory)){
            return response()->json(['status'=>false,'message'=>$galleryCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryCategory],200);

        
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
    public function update(UpdateGalleryRequest $request,$id)
    {
          try{
       $galleryCategory= $this->galleryCategoryRepo->update($request,$id,$this->galleryCategory);
                                 if(is_string($galleryCategory)){
            return response()->json(['status'=>false,'message'=>$galleryCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $galleryCategory =  $this->galleryCategoryRepo->restore($id,$this->galleryCategory);
                                  if(is_string($galleryCategory)){
            return response()->json(['status'=>false,'message'=>$galleryCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $galleyCategories =  $this->galleryCategoryRepo->restoreAll($this->galleryCategory);
                                  if(is_string($galleyCategories)){
            return response()->json(['status'=>false,'message'=>$galleyCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyCategories],200);

        
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
    public function destroy(DeleteGalleryRequest $request,$id)
    {
           try{
       $galleryCategory= $this->galleryCategoryRepo->destroy($id,$this->galleryCategory);
                          if(is_string($galleryCategory)){
            return response()->json(['status'=>false,'message'=>$galleryCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteGalleryRequest $request,$id)
    {
          try{
        //to make force destroy for a Page must be this Page  not found in Pages table  , must be found in trash Pages
        $galleryCategory=$this->galleryCategoryRepo->forceDelete($id,$this->galleryCategory);
                          if(is_string($galleryCategory)){
            return response()->json(['status'=>false,'message'=>$galleryCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
