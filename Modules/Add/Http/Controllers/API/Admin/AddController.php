<?php

namespace Modules\Add\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Add\Entities\Add;
use Modules\Add\Http\Requests\DeleteAddRequest;
use Modules\Add\Http\Requests\StoreAddRequest;
use Modules\Add\Http\Requests\UpdateAddRequest;
use Modules\Add\Repositories\Admin\AddRepository;

class AddController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var AddRepository
     */
    protected $addRepo;
    /**
     * @var Add
     */
    protected $add;
   

    /**
     * AddsController constructor.
     *
     * @param AddRepository $adds
     */
    public function __construct(BaseRepository $baseRepo, Add $add,AddRepository $addRepo)
    {
        $this->middleware(['permission:adds_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:adds_trash'])->only('trash');
        $this->middleware(['permission:adds_restore'])->only('restore');
        $this->middleware(['permission:adds_restore-all'])->only('restore-all');
        $this->middleware(['permission:adds_show'])->only('show');
        $this->middleware(['permission:adds_store'])->only('store');
        $this->middleware(['permission:adds_update'])->only('update');
        $this->middleware(['permission:adds_destroy'])->only('destroy');
        $this->middleware(['permission:adds_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->add = $add;
        $this->addRepo = $addRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $adds=$this->addRepo->all($this->add,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$adds],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $adds=$this->addRepo->getAllPaginates($this->add,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$adds],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
      public function paginates(Request $request,$lang){
        
        //  try{
        $adds=$this->addRepo->paginates($this->add,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$adds],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $adds=$this->addRepo->trash($this->add,$request);
                if(is_string($adds)){
            return response()->json(['status'=>false,'message'=>$adds],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$adds],200);

        
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
    public function store(StoreAddRequest $request)
    {
        // try{
       $add= $this->addRepo->store($request,$this->add);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$add->load('media')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
     public function storeTrans(StoreAddRequest $request,$id,$lang)
    {
        // try{
       $add= $this->addRepo->storeTrans($request,$this->add,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$add->load('media')],200);

        
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
        $add=$this->addRepo->find($id,$this->add);
                          if(is_string($add)){
            return response()->json(['status'=>false,'message'=>$add],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$add->load('media')],200);

        
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
    public function update(UpdateAddRequest $request,$id)
    {
        //   try{
       $add= $this->addRepo->update($request,$id,$this->add);
                                 if(is_string($add)){
            return response()->json(['status'=>false,'message'=>$add],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$add->load('media')],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $add =  $this->addRepo->restore($id,$this->add);
                                  if(is_string($add)){
            return response()->json(['status'=>false,'message'=>$add],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$add->load('media')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $adds =  $this->addRepo->restoreAll($this->add);
                                  if(is_string($adds)){
            return response()->json(['status'=>false,'message'=>$adds],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$adds],200);

        
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
    public function destroy(DeleteAddRequest $request,$id)
    {
           try{
       $add= $this->addRepo->destroy($id,$this->add);
                          if(is_string($add)){
            return response()->json(['status'=>false,'message'=>$add],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$add->load('media')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteAddRequest $request,$id)
    {
          try{
        //to make force destroy for a Add must be this Add  not found in Adds table  , must be found in trash Adds
        $add=$this->addRepo->forceDelete($id,$this->add);
                          if(is_string($add)){
            return response()->json(['status'=>false,'message'=>$add],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
