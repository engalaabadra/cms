<?php

namespace Modules\Visit\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Visit\Entities\Visit;
use Modules\Visit\Http\Requests\DeleteVisitRequest;
use Modules\Visit\Http\Requests\StoreVisitRequest;
use Modules\Visit\Http\Requests\UpdateVisitRequest;
use Modules\Visit\Repositories\Admin\VisitRepository;

class VisitController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var VisitRepository
     */
    protected $visitRepo;
    /**
     * @var Visit
     */
    protected $visit;
   

    /**
     * VisitsController constructor.
     *
     * @param VisitRepository $visits
     */
    public function __construct(BaseRepository $baseRepo, Visit $visit,VisitRepository $visitRepo)
    {
        $this->middleware(['permission:visits_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:visits_trash'])->only('trash');
        $this->middleware(['permission:visits_restore'])->only('restore');
        $this->middleware(['permission:visits_restore-all'])->only('restore-all');
        $this->middleware(['permission:visits_show'])->only('show');
        $this->middleware(['permission:visits_store'])->only('store');
        $this->middleware(['permission:visits_update'])->only('update');
        $this->middleware(['permission:visits_destroy'])->only('destroy');
        $this->middleware(['permission:visits_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->visit = $visit;
        $this->visitRepo = $visitRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $visits=$this->visitRepo->all($this->visit,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visits],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){

        //  try{
        $visits=$this->visitRepo->getAllPaginates($this->visit,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visits],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $visits=$this->visitRepo->trash($this->visit,$request);
                              if(is_string($visits)){
            return response()->json(['status'=>false,'message'=>$visits],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visits],200);

        
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
    public function store(StoreVisitRequest $request)
    {
        // try{
       $visit= $this->visitRepo->store($request,$this->visit);
                                          if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visit->load('client')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreVisitRequest $request,$id,$lang)
    {
        // try{
       $visit= $this->visitRepo->storeTrans($request,$this->visit,$id,$lang);
                                          if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visit->load('client')],200);

        
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
        $visit=$this->visitRepo->find($id,$this->visit);
                          if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visit->load('client')],200);

        
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
    public function update(UpdateVisitRequest $request,$id)
    {
          try{
       $visit= $this->visitRepo->update($request,$id,$this->visit);
                                 if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visit->load('client')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $visit =  $this->visitRepo->restore($id,$this->visit);
                                  if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visit->load('client')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $visits =  $this->visitRepo->restoreAll($this->visit);
                                  if(is_string($visits)){
            return response()->json(['status'=>false,'message'=>$visits],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visits],200);

        
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
    public function destroy(DeleteVisitRequest $request,$id)
    {
           try{
       $visit= $this->visitRepo->destroy($id,$this->visit);
                          if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$visit->load('client')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteVisitRequest $request,$id)
    {
          try{
        //to make force destroy for a Visit must be this Visit  not found in Visits table  , must be found in trash Visits
        $visit=$this->visitRepo->forceDelete($id,$this->visit);
                          if(is_string($visit)){
            return response()->json(['status'=>false,'message'=>$visit],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
