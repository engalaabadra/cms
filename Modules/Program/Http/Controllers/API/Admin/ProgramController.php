<?php

namespace Modules\Program\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Program\Entities\Program;
use Modules\Program\Http\Requests\DeleteProgramRequest;
use Modules\Program\Http\Requests\StoreProgramRequest;
use Modules\Program\Http\Requests\UpdateProgramRequest;
use Modules\Program\Repositories\Admin\ProgramRepository;

class ProgramController extends Controller
{
   /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ProgramRepository
     */
    protected $programRepo;
    /**
     * @var Program
     */
    protected $program;
   

    /**
     * ProgramsController constructor.
     *
     * @param ProgramRepository $programs
     */
    public function __construct(BaseRepository $baseRepo, Program $program,ProgramRepository $programRepo)
    {
        $this->middleware(['permission:programs_read'])->only('index');
        $this->middleware(['permission:programs_trash'])->only('trash');
        $this->middleware(['permission:programs_restore'])->only('restore');
        $this->middleware(['permission:programs_restore-all'])->only('restore-all');
        $this->middleware(['permission:programs_show'])->only('show');
        $this->middleware(['permission:programs_store'])->only('store');
        $this->middleware(['permission:programs_update'])->only('update');
        $this->middleware(['permission:programs_destroy'])->only('destroy');
        $this->middleware(['permission:programs_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->program = $program;
        $this->programRepo = $programRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $programs=$this->programRepo->all($this->program,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programs],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $programs=$this->programRepo->getAllPaginates($this->program,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programs],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $programs=$this->programRepo->trash($this->program,$request);
        if(is_string($programs)){
            return response()->json(['status'=>false,'message'=>$programs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programs],200);

        
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
    public function store(StoreProgramRequest $request)
    {
        // try{
       $program= $this->programRepo->store($request,$this->program);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$program->load('programCategory','image')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreProgramRequest $request,$id,$lang)
    {
        // try{
       $program= $this->programRepo->store($request,$this->program,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$program->load('programCategory','image')],200);

        
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
        $program=$this->programRepo->find($id,$this->program);
                          if(is_string($program)){
            return response()->json(['status'=>false,'message'=>$program],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$program->load('programCategory','image')],200);

        
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
    public function update(UpdateProgramRequest $request,$id)
    {
          try{
       $program= $this->programRepo->update($request,$id,$this->program);
                                 if(is_string($program)){
            return response()->json(['status'=>false,'message'=>$program],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$program->load('programCategory','image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $program =  $this->programRepo->restore($id,$this->program);
                                  if(is_string($program)){
            return response()->json(['status'=>false,'message'=>$program],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$program->load('programCategory','image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $programs =  $this->programRepo->restoreAll($this->program);
                                  if(is_string($programs)){
            return response()->json(['status'=>false,'message'=>$programs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programs],200);

        
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
    public function destroy(DeleteProgramRequest $request,$id)
    {
           try{
       $program= $this->programRepo->destroy($id,$this->program);
                          if(is_string($program)){
            return response()->json(['status'=>false,'message'=>$program],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$program->load('programCategory','image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteProgramRequest $request,$id)
    {
          try{
        //to make force destroy for a Program must be this Program  not found in Programs table  , must be found in trash Programs
        $program=$this->programRepo->forceDelete($id,$this->program);
                          if(is_string($program)){
            return response()->json(['status'=>false,'message'=>$program],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
