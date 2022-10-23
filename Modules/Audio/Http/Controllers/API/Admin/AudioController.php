<?php

namespace Modules\Audio\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Audio\Entities\Audio;
use Modules\Audio\Http\Requests\DeleteAudioRequest;
use Modules\Audio\Http\Requests\StoreAudioRequest;
use Modules\Audio\Http\Requests\UpdateAudioRequest;
use Modules\Audio\Repositories\Admin\AudioRepository;

class AudioController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var AudioRepository
     */
    protected $audioRepo;
    /**
     * @var Audio
     */
    protected $audio;
   

    /**
     * AudiosController constructor.
     *
     * @param AudioRepository $audios
     */
    public function __construct(BaseRepository $baseRepo, Audio $audio,AudioRepository $audioRepo)
    {
        $this->middleware(['permission:audios_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:audios_trash'])->only('trash');
        $this->middleware(['permission:audios_restore'])->only('restore');
        $this->middleware(['permission:audios_restore-all'])->only('restore-all');
        $this->middleware(['permission:audios_show'])->only('show');
        $this->middleware(['permission:audios_store'])->only('store');
        $this->middleware(['permission:audios_update'])->only('update');
        $this->middleware(['permission:audios_destroy'])->only('destroy');
        $this->middleware(['permission:audios_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->audio = $audio;
        $this->audioRepo = $audioRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $audios=$this->audioRepo->all($this->audio,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audios],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $audios=$this->audioRepo->getAllPaginates($this->audio,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audios],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $audios=$this->audioRepo->trash($this->audio,$request);
                if(is_string($audios)){
            return response()->json(['status'=>false,'message'=>$audios],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audios],200);

        
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
    public function store(StoreAudioRequest $request)
    {
        // try{
       $audio= $this->audioRepo->store($request,$this->audio);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audio->load(['audioCategory','thumb','media'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
     public function storeTrans(StoreAudioRequest $request,$id,$lang)
    {
        // try{
       $audio= $this->audioRepo->storeTrans($request,$this->audio,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audio->load(['audioCategory','thumb','media'])],200);

        
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
        $audio=$this->audioRepo->find($id,$this->audio);
                          if(is_string($audio)){
            return response()->json(['status'=>false,'message'=>$audio],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audio->load(['audioCategory','thumb','media'])],200);

        
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
    public function update(UpdateAudioRequest $request,$id)
    {
        //   try{
       $audio= $this->audioRepo->update($request,$id,$this->audio);
                                 if(is_string($audio)){
            return response()->json(['status'=>false,'message'=>$audio],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audio->load(['audioCategory','thumb','media'])],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $audio =  $this->audioRepo->restore($id,$this->audio);
                                  if(is_string($audio)){
            return response()->json(['status'=>false,'message'=>$audio],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audio->load(['audioCategory','thumb','media'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $audios =  $this->audioRepo->restoreAll($this->audio);
                                  if(is_string($audios)){
            return response()->json(['status'=>false,'message'=>$audios],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audios],200);

        
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
    public function destroy(DeleteAudioRequest $request,$id)
    {
           try{
       $audio= $this->audioRepo->destroy($id,$this->audio);
                          if(is_string($audio)){
            return response()->json(['status'=>false,'message'=>$audio],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audio->load(['audioCategory','thumb','media'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteAudioRequest $request,$id)
    {
          try{
        //to make force destroy for a Audio must be this Audio  not found in Audios table  , must be found in trash Audios
        $audio=$this->audioRepo->forceDelete($id,$this->audio);
                          if(is_string($audio)){
            return response()->json(['status'=>false,'message'=>$audio],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
