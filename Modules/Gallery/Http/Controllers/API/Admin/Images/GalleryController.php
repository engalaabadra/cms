<?php

namespace Modules\Gallery\Http\Controllers\API\Admin\Images;

use Modules\Gallery\Entities\GalleryImage;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Http\Requests\Images\DeleteGalleryRequest;
use Modules\Gallery\Http\Requests\Images\StoreGalleryRequest;
use Modules\Gallery\Http\Requests\Images\UpdateGalleryRequest;
use Modules\Gallery\Repositories\Admin\Images\GalleryRepository;

class GalleryController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var GalleryImageRepository
     */
    protected $galleryImageRepo;
    /**
     * @var Page
     */
    protected $galleryImage;
   

    /**
     * PagesController constructor.
     *
     * @param GalleryImageRepository $galleyAlbums
     */
    public function __construct(BaseRepository $baseRepo, GalleryImage $galleryImage,GalleryRepository $galleryImageRepo)
    {
        $this->middleware(['permission:galleries-imags_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:galleries-imags_trash'])->only('trash');
        $this->middleware(['permission:galleries-imags_restore'])->only('restore');
        $this->middleware(['permission:galleries-imags_restore-all'])->only('restore-all');
        $this->middleware(['permission:galleries-imags_show'])->only('show');
        $this->middleware(['permission:galleries-imags_store'])->only('store');
        $this->middleware(['permission:galleries-imags_update'])->only('update');
        $this->middleware(['permission:galleries-imags_destroy'])->only('destroy');
        $this->middleware(['permission:galleries-imags_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->galleryImage = $galleryImage;
        $this->galleryImageRepo = $galleryImageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $galleyAlbums=$this->galleryImageRepo->all($this->galleryImage,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
      //   try{
        $galleyAlbums=$this->galleryImageRepo->getAllPaginates($this->galleryImage,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $galleyAlbums=$this->galleryImageRepo->trash($this->galleryImage,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

        
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
       $galleryImage= $this->galleryImageRepo->store($request,$this->galleryImage);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryImage->load(['galleryAlbum','galleryPhotos'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
    
        public function storeTrans(StoreGalleryRequest $request,$id,$lang)
    {
        // try{
       $galleryImage= $this->galleryImageRepo->storeTrans($request,$this->galleryImage,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryImage->load(['galleryAlbum','galleryPhotos'])],200);

        
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
        $galleryImage=$this->galleryImageRepo->find($id,$this->galleryImage);
                          if(is_string($galleryImage)){
            return response()->json(['status'=>false,'message'=>$galleryImage],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryImage->load(['galleryAlbum','galleryPhotos'])],200);

        
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
       $galleryImage= $this->galleryImageRepo->update($request,$id,$this->galleryImage);
                                 if(is_string($galleryImage)){
            return response()->json(['status'=>false,'message'=>$galleryImage],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryImage->load(['galleryAlbum','galleryPhotos'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $galleryImage =  $this->galleryImageRepo->restore($id,$this->galleryImage);
                                  if(is_string($galleryImage)){
            return response()->json(['status'=>false,'message'=>$galleryImage],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryImage->load(['galleryAlbum','galleryPhotos'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $galleyAlbums =  $this->galleryImageRepo->restoreAll($this->galleryImage);
                                  if(is_string($galleyAlbums)){
            return response()->json(['status'=>false,'message'=>$galleyAlbums],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

        
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
       $galleryImage= $this->galleryImageRepo->destroy($id,$this->galleryImage);
                          if(is_string($galleryImage)){
            return response()->json(['status'=>false,'message'=>$galleryImage],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryImage->load(['galleryAlbum','galleryPhotos'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteGalleryRequest $request,$id)
    {
          try{
        //to make force destroy for a Page must be this Page  not found in Pages table  , must be found in trash Pages
        $galleryImage=$this->galleryImageRepo->forceDelete($id,$this->galleryImage);
                          if(is_string($galleryImage)){
            return response()->json(['status'=>false,'message'=>$galleryImage],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
