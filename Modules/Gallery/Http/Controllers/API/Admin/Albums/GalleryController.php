<?php

namespace Modules\Gallery\Http\Controllers\API\Admin\Albums;

use Modules\Gallery\Entities\GalleryAlbum;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Http\Requests\Albums\DeleteGalleryRequest;
use Modules\Gallery\Http\Requests\Albums\StoreGalleryRequest;
use Modules\Gallery\Http\Requests\Albums\UpdateGalleryRequest;
use Modules\Gallery\Repositories\Admin\Albums\GalleryRepository;

class GalleryController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var GalleryAlbumRepository
     */
    protected $galleryAlbumRepo;
    /**
     * @var Page
     */
    protected $galleryAlbum;
   

    /**
     * PagesController constructor.
     *
     * @param GalleryAlbumRepository $galleyAlbums
     */
    public function __construct(BaseRepository $baseRepo, GalleryAlbum $galleryAlbum,GalleryRepository $galleryAlbumRepo)
    {
        $this->middleware(['permission:galleries-albums_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:galleries-albums_trash'])->only('trash');
        $this->middleware(['permission:galleries-albums_restore'])->only('restore');
        $this->middleware(['permission:galleries-albums_restore-all'])->only('restore-all');
        $this->middleware(['permission:galleries-albums_show'])->only('show');
        $this->middleware(['permission:galleries-albums_store'])->only('store');
        $this->middleware(['permission:galleries-albums_update'])->only('update');
        $this->middleware(['permission:galleries-albums_destroy'])->only('destroy');
        $this->middleware(['permission:galleries-albums_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->galleryAlbum = $galleryAlbum;
        $this->galleryAlbumRepo = $galleryAlbumRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $galleyAlbums=$this->galleryAlbumRepo->all($this->galleryAlbum,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $galleyAlbums=$this->galleryAlbumRepo->getAllPaginates($this->galleryAlbum,$request,$lang);
        
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $galleyAlbums=$this->galleryAlbumRepo->trash($this->galleryAlbum,$request);
                                  if(is_string($galleryAlbums)){
            return response()->json(['status'=>false,'message'=>$galleryAlbums],404);
        }
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
            
       $galleryAlbum= $this->galleryAlbumRepo->store($request,$this->galleryAlbum);
                                 if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryAlbum->load(['galleryCategory','galleryImages','image'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

    public function storeTrans(StoreGalleryRequest $request,$id,$lang)
    {
        try{
            
       $galleryAlbum= $this->galleryAlbumRepo->storeTrans($request,$this->galleryAlbum,$id,$lang);
                                 if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryAlbum->load(['galleryCategory','galleryImages','image'])],200);

        
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
        $galleryAlbum=$this->galleryAlbumRepo->find($id,$this->galleryAlbum);
                          if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryAlbum->load(['galleryCategory','galleryImages','image'])],200);

        
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
       $galleryAlbum= $this->galleryAlbumRepo->update($request,$id,$this->galleryAlbum);
                                 if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryAlbum->load(['galleryCategory','galleryImages','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $galleryAlbum =  $this->galleryAlbumRepo->restore($id,$this->galleryAlbum);
                                  if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryAlbum->load(['galleryCategory','galleryImages','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $galleyAlbums =  $this->galleryAlbumRepo->restoreAll($this->galleryAlbum);
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
       $galleryAlbum= $this->galleryAlbumRepo->destroy($id,$this->galleryAlbum);
                          if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleryAlbum->load(['galleryCategory','galleryImages','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteGalleryRequest $request,$id)
    {
          try{
        //to make force destroy for a Page must be this Page  not found in Pages table  , must be found in trash Pages
        $galleryAlbum=$this->galleryAlbumRepo->forceDelete($id,$this->galleryAlbum);
                          if(is_string($galleryAlbum)){
            return response()->json(['status'=>false,'message'=>$galleryAlbum],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
