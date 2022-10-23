<?php

namespace Modules\Video\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Video\Entities\Video;
use Modules\Video\Http\Requests\DeleteVideoRequest;
use Modules\Video\Http\Requests\StoreVideoRequest;
use Modules\Video\Http\Requests\UpdateVideoRequest;
use Modules\Video\Repositories\Admin\VideoRepository;

class VideoController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var VideoRepository
     */
    protected $videoRepo;
    /**
     * @var Video
     */
    protected $video;
   

    /**
     * VideosController constructor.
     *
     * @param VideoRepository $videos
     */
    public function __construct(BaseRepository $baseRepo, Video $video,VideoRepository $videoRepo)
    {
        $this->middleware(['permission:videos_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:videos_trash'])->only('trash');
        $this->middleware(['permission:videos_restore'])->only('restore');
        $this->middleware(['permission:videos_restore-all'])->only('restore-all');
        $this->middleware(['permission:videos_show'])->only('show');
        $this->middleware(['permission:videos_store'])->only('store');
        $this->middleware(['permission:videos_update'])->only('update');
        $this->middleware(['permission:videos_destroy'])->only('destroy');
        $this->middleware(['permission:videos_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->video = $video;
        $this->videoRepo = $videoRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $videos=$this->videoRepo->all($this->video,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videos],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $videos=$this->videoRepo->getAllPaginates($this->video,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videos],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $videos=$this->videoRepo->trash($this->video,$request);
                              if(is_string($videos)){
            return response()->json(['status'=>false,'message'=>$videos],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videos],200);

        
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
       $video= $this->videoRepo->store($request,$this->video);
                                          if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$video->load('VideoCategory')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreVideoRequest $request,$id,$lang)
    {
        // try{
       $video= $this->videoRepo->storeTrans($request,$this->video,$id,$lang);
                                          if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$video->load('VideoCategory')],200);

        
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
        $video=$this->videoRepo->find($id,$this->video);
                          if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$video->load('VideoCategory')],200);

        
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
       $video= $this->videoRepo->update($request,$id,$this->video);
                                 if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$video->load('VideoCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $video =  $this->videoRepo->restore($id,$this->video);
                                  if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$video->load('VideoCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $videos =  $this->videoRepo->restoreAll($this->video);
                                  if(is_string($videos)){
            return response()->json(['status'=>false,'message'=>$videos],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videos],200);

        
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
       $video= $this->videoRepo->destroy($id,$this->video);
                          if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$video->load('VideoCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteVideoRequest $request,$id)
    {
          try{
        //to make force destroy for a Video must be this Video  not found in Videos table  , must be found in trash Videos
        $video=$this->videoRepo->forceDelete($id,$this->video);
                          if(is_string($video)){
            return response()->json(['status'=>false,'message'=>$video],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
