<?php

namespace Modules\Video\Http\Controllers\API\Admin\Categories;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Video\Entities\VideoCategory;
use Modules\Video\Http\Requests\Categories\DeleteVideoRequest;
use Modules\Video\Http\Requests\Categories\StoreVideoRequest;
use Modules\Video\Http\Requests\Categories\UpdateVideoRequest;
use Modules\Video\Repositories\Admin\Categories\VideoRepository;

class VideoController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var VideoCategoryRepository
     */
    protected $videoCategoryRepo;
    /**
     * @var VideoCategory
     */
    protected $videoCategory;
   

    /**
     * VideosController constructor.
     *
     * @param VideoCategoryRepository $videoCategories
     */
    public function __construct(BaseRepository $baseRepo, VideoCategory $videoCategory,VideoRepository $videoCategoryRepo)
    {
        $this->middleware(['permission:video-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:video-categories_trash'])->only('trash');
        $this->middleware(['permission:video-categories_restore'])->only('restore');
        $this->middleware(['permission:video-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:video-categories_show'])->only('show');
        $this->middleware(['permission:video-categories_store'])->only('store');
        $this->middleware(['permission:video-categories_update'])->only('update');
        $this->middleware(['permission:video-categories_destroy'])->only('destroy');
        $this->middleware(['permission:video-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->videoCategory = $videoCategory;
        $this->videoCategoryRepo = $videoCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $videoCategories=$this->videoCategoryRepo->all($this->videoCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategories],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $videoCategories=$this->videoCategoryRepo->getAllPaginates($this->videoCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategories],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $videoCategories=$this->videoCategoryRepo->trash($this->videoCategory,$request);
                if(is_string($videoCategories)){
            return response()->json(['status'=>false,'message'=>$videoCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategories],200);

        
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
    public function store(StoreVideoRequest $request)
    {
        // try{
       $videoCategory= $this->videoCategoryRepo->store($request,$this->videoCategory);
                       if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategory],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    public function storeTrans(StoreVideoRequest $request,$id,$lang)
    {
        // try{
       $videoCategory= $this->videoCategoryRepo->storeTrans($request,$this->videoCategory,$id,$lang);
                       if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategory],200);

        
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
        $videoCategory=$this->videoCategoryRepo->find($id,$this->videoCategory);
                          if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategory],200);

        
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
    public function update(UpdateVideoRequest $request,$id)
    {
          try{
       $videoCategory= $this->videoCategoryRepo->update($request,$id,$this->videoCategory);
                                 if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $videoCategory =  $this->videoCategoryRepo->restore($id,$this->videoCategory);
                                  if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $videoCategories =  $this->videoCategoryRepo->restoreAll($this->videoCategory);
                                  if(is_string($videoCategories)){
            return response()->json(['status'=>false,'message'=>$videoCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategories],200);

        
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
    public function destroy(DeleteVideoRequest $request,$id)
    {
           try{
       $videoCategory= $this->videoCategoryRepo->destroy($id,$this->videoCategory);
                          if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videoCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(Request $request,$id)
    {
          try{
        //to make force destroy for a Video must be this Video  not found in Videos table  , must be found in trash Videos
        $videoCategory=$this->videoCategoryRepo->forceDelete($id,$this->videoCategory);
                          if(is_string($videoCategory)){
            return response()->json(['status'=>false,'message'=>$videoCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
