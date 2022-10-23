<?php

namespace Modules\Constant\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Constant\Entities\Constant;
use Modules\Constant\Http\Requests\DeleteConstantRequest;
use Modules\Constant\Http\Requests\StoreConstantRequest;
use Modules\Constant\Http\Requests\UpdateConstantRequest;
use Modules\Constant\Repositories\Admin\ConstantRepository;

class ConstantController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ConstantRepository
     */
    protected $constantRepo;
    /**
     * @var Constant
     */
    protected $constant;
   

    /**
     * ConstantsController constructor.
     *
     * @param ConstantRepository $constants
     */
    public function __construct(BaseRepository $baseRepo, Constant $constant,ConstantRepository $constantRepo)
    {
        $this->middleware(['permission:constants_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:constants_trash'])->only('trash');
        $this->middleware(['permission:constants_restore'])->only('restore');
        $this->middleware(['permission:constants_restore-all'])->only('restore-all');
        $this->middleware(['permission:constants_show'])->only('show');
        $this->middleware(['permission:constants_store'])->only('store');
        $this->middleware(['permission:constants_update'])->only('update');
        $this->middleware(['permission:constants_destroy'])->only('destroy');
        $this->middleware(['permission:constants_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->constant = $constant;
        $this->constantRepo = $constantRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $constants=$this->constantRepo->all($this->constant,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constants],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $constants=$this->constantRepo->getAllPaginates($this->constant,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constants],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
//   try{
        $constants=$this->constantRepo->trash($this->constant,$request);
                                  if(is_string($constants)){
            return response()->json(['status'=>false,'message'=>$constants],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constants],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConstantRequest $request)
    {
        // try{
       $constant= $this->constantRepo->store($request,$this->constant);
                                         if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constant],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }



public function storeTrans(StoreConstantRequest $request)
    {
        // try{
       $constant= $this->constantRepo->storeTrans($request,$this->constant);
                                         if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constant],200);

        
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
        $constant=$this->constantRepo->find($id,$this->constant);
                          if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constant],200);

        
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
    public function update(UpdateConstantRequest $request,$id)
    {
          try{
       $constant= $this->constantRepo->update($request,$id,$this->constant);
                                 if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constant],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $constant =  $this->constantRepo->restore($id,$this->constant);
                                  if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constant],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $constants =  $this->constantRepo->restoreAll($this->constant);
                                  if(is_string($constants)){
            return response()->json(['status'=>false,'message'=>$constants],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constants],200);

        
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
    public function destroy(DeleteConstantRequest $request,$id)
    {
           try{
       $constant= $this->constantRepo->destroy($id,$this->constant);
                          if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$constant],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteConstantRequest $request,$id)
    {
          try{
        //to make force destroy for a Constant must be this Constant  not found in Constants table  , must be found in trash Constants
        $constant=$this->constantRepo->forceDelete($id,$this->constant);
                          if(is_string($constant)){
            return response()->json(['status'=>false,'message'=>$constant],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
