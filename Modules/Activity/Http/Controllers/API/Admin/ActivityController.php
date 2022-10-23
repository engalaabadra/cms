<?php

namespace Modules\Activity\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Activity\Entities\Activity;
use Modules\Activity\Http\Requests\DeleteActivityRequest;
use Modules\Activity\Http\Requests\StoreActivityRequest;
use Modules\Activity\Http\Requests\UpdateActivityRequest;
use Modules\Activity\Repositories\Admin\ActivityRepository;

class ActivityController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ActivityRepository
     */
    protected $activityRepo;
    /**
     * @var Activity
     */
    protected $activity;
   

    /**
     * ActivitysController constructor.
     *
     * @param ActivityRepository $activities
     */
    public function __construct(BaseRepository $baseRepo, Activity $activity,ActivityRepository $activityRepo)
    {
        // $this->middleware(['permission:activities_read'])->only('index','getAllPaginates');
        // $this->middleware(['permission:activities_trash'])->only('trash');
        // $this->middleware(['permission:activities_restore'])->only('restore');
        // $this->middleware(['permission:activities_restore-all'])->only('restore-all');
        // $this->middleware(['permission:activities_show'])->only('show');
        // $this->middleware(['permission:activities_store'])->only('store');
        // $this->middleware(['permission:activities_update'])->only('update');
        // $this->middleware(['permission:activities_destroy'])->only('destroy');
        // $this->middleware(['permission:activities_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->activity = $activity;
        $this->activityRepo = $activityRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $activities=$this->activityRepo->all($this->activity,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activities],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $activities=$this->activityRepo->getAllPaginates($this->activity,$request,$lang);
          return response()->json(['status'=>true,'message'=>$activities],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $activities=$this->activityRepo->trash($this->activity,$request);
      if(is_string($activities)){
            return response()->json(['status'=>false,'message'=>$activities],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activities],200);

        
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
    public function store(StoreActivityRequest $request)
    {
        // try{
       $activity= $this->activityRepo->store($request,$this->activity);
             if(is_string($activity)){
            return response()->json(['status'=>false,'message'=>$activity],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activity],200);

        
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
        $activity=$this->activityRepo->find($id,$this->activity);
                          if(is_string($activity)){
            return response()->json(['status'=>false,'message'=>$activity],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activity],200);

        
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
    public function update(UpdateActivityRequest $request,$id)
    {
          try{
       $activity= $this->activityRepo->update($request,$id,$this->activity);
                                 if(is_string($activity)){
            return response()->json(['status'=>false,'message'=>$activity],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activity],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $activity =  $this->activityRepo->restore($id,$this->activity);
                                  if(is_string($activity)){
            return response()->json(['status'=>false,'message'=>$activity],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activity],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $activities =  $this->activityRepo->restoreAll($this->activity);
                                  if(is_string($activities)){
            return response()->json(['status'=>false,'message'=>$activities],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activities],200);

        
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
    public function destroy(DeleteActivityRequest $request,$id)
    {
           try{
       $activity= $this->activityRepo->destroy($id,$this->activity);
                          if(is_string($activity)){
            return response()->json(['status'=>false,'message'=>$activity],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$activity],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteActivityRequest $request,$id)
    {
          try{
        //to make force destroy for a Activity must be this Activity  not found in Activitys table  , must be found in trash Activitys
        $activity=$this->activityRepo->forceDelete($id,$this->activity);
                          if(is_string($activity)){
            return response()->json(['status'=>false,'message'=>$activity],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
