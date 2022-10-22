<?php

namespace Modules\Audio\Http\Controllers\API\Admin\Categories;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Audio\Entities\AudioCategory;
use Modules\Audio\Http\Requests\Categories\DeleteAudioRequest;
use Modules\Audio\Http\Requests\Categories\StoreAudioRequest;
use Modules\Audio\Http\Requests\Categories\UpdateAudioRequest;
use Modules\Audio\Repositories\Admin\Categories\AudioRepository;

class AudioController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var AudioRepository
     */
    protected $audioCategoryRepo;
    /**
     * @var AudioCategory
     */
    protected $audioCategory;
   

    /**
     * AudiosController constructor.
     *
     * @param AudioCategoryRepository $audioCategories
     */
    public function __construct(BaseRepository $baseRepo, AudioCategory $audioCategory,AudioRepository $audioCategoryRepo)
    {
        $this->middleware(['permission:audio-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:audio-categories_trash'])->only('trash');
        $this->middleware(['permission:audio-categories_restore'])->only('restore');
        $this->middleware(['permission:audio-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:audio-categories_show'])->only('show');
        $this->middleware(['permission:audio-categories_store'])->only('store');
        $this->middleware(['permission:audio-categories_update'])->only('update');
        $this->middleware(['permission:audio-categories_destroy'])->only('destroy');
        $this->middleware(['permission:audio-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->audioCategory = $audioCategory;
        $this->audioCategoryRepo = $audioCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $audioCategories=$this->audioCategoryRepo->all($this->audioCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategories],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request){
        
         try{
        $audioCategories=$this->audioCategoryRepo->getAllPaginates($this->audioCategory,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategories],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $audioCategories=$this->audioCategoryRepo->trash($this->audioCategory,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategories],200);

        
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
       $audioCategory= $this->audioCategoryRepo->store($request,$this->audioCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategory],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
     public function storeTrans(StoreAudioRequest $request,$id,$lang)
    {
        // try{
       $audioCategory= $this->audioCategoryRepo->store($request,$this->audioCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategory],200);

        
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
        $audioCategory=$this->audioCategoryRepo->find($id,$this->audioCategory);
                          if(is_string($audioCategory)){
            return response()->json(['status'=>false,'message'=>$audioCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategory],200);

        
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
         // try{
       $audioCategory= $this->audioCategoryRepo->update($request,$id,$this->audioCategory);
                                 if(is_string($audioCategory)){
            return response()->json(['status'=>false,'message'=>$audioCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategory],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $audioCategory =  $this->audioCategoryRepo->restore($id,$this->audioCategory);
                                  if(is_string($audioCategory)){
            return response()->json(['status'=>false,'message'=>$audioCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $audioCategories =  $this->audioCategoryRepo->restoreAll($this->audioCategory);
                                  if(is_string($audioCategories)){
            return response()->json(['status'=>false,'message'=>$audioCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategories],200);

        
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
       $audioCategory= $this->audioCategoryRepo->destroy($id,$this->audioCategory);
                          if(is_string($audioCategory)){
            return response()->json(['status'=>false,'message'=>$audioCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$audioCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteAudioRequest $request,$id)
    {
          try{
        //to make force destroy for a Audio must be this Audio  not found in Audios table  , must be found in trash Audios
        $audioCategory=$this->audioCategoryRepo->forceDelete($id,$this->audioCategory);
                          if(is_string($audioCategory)){
            return response()->json(['status'=>false,'message'=>$audioCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
