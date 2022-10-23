<?php

namespace Modules\Program\Http\Controllers\API\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Modules\Program\Entities\ProgramCategory;
use Modules\Program\Http\Requests\Categories\StoreProgramRequest;
use Modules\Program\Http\Requests\Categories\UpdateProgramRequest;
use Modules\Program\Http\Requests\Categories\DeleteProgramRequest;
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
    protected $programCategoryRepo;
    /**
     * @var ProgramCategory
     */
    protected $programCategory;
   

    /**
     * ProgramCategorysController constructor.
     *
     * @param ProgramCategoryRepository $programCategorys
     */
    public function __construct(BaseRepository $baseRepo, ProgramCategory $programCategory,ProgramRepository $programCategoryRepo)
    {
        $this->middleware(['permission:program-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:program-categories_trash'])->only('trash');
        $this->middleware(['permission:program-categories_restore'])->only('restore');
        $this->middleware(['permission:program-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:program-categories_show'])->only('show');
        $this->middleware(['permission:program-categories_store'])->only('store');
        $this->middleware(['permission:program-categories_update'])->only('update');
        $this->middleware(['permission:program-categories_destroy'])->only('destroy');
        $this->middleware(['permission:program-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->programCategory = $programCategory;
        $this->programCategoryRepo = $programCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
//          try{
        $programCategorys=$this->programCategoryRepo->all($this->programCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategorys],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $programCategorys=$this->programCategoryRepo->getAllPaginates($this->programCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategorys],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $programCategorys=$this->programCategoryRepo->trash($this->programCategory,$request);
                if(is_string($programCategorys)){
            return response()->json(['status'=>false,'message'=>$programCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategorys],200);

        
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
       $programCategory= $this->programCategoryRepo->store($request,$this->programCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategory->load('image')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    public function storeTrans(StoreProgramRequest $request,$id,$lang)
    {
        try{
       $programCategory= $this->programCategoryRepo->storeTrans($request,$this->programCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategory->load('image')],200);

        
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
        $programCategory=$this->programCategoryRepo->find($id,$this->programCategory);
                          if(is_string($programCategory)){
            return response()->json(['status'=>false,'message'=>$programCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategory->load('image')],200);

        
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
       $programCategory= $this->programCategoryRepo->update($request,$id,$this->programCategory);
                                 if(is_string($programCategory)){
            return response()->json(['status'=>false,'message'=>$programCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategory->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $programCategory =  $this->programCategoryRepo->restore($id,$this->programCategory);
                                  if(is_string($programCategory)){
            return response()->json(['status'=>false,'message'=>$programCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategory->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $programCategorys =  $this->programCategoryRepo->restoreAll($this->programCategory);
                                  if(is_string($programCategorys)){
            return response()->json(['status'=>false,'message'=>$programCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategorys],200);

        
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
       $programCategory= $this->programCategoryRepo->destroy($id,$this->programCategory);
                          if(is_string($programCategory)){
            return response()->json(['status'=>false,'message'=>$programCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$programCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteProgramRequest $request,$id)
    {
          try{
        //to make force destroy for a ProgramCategory must be this ProgramCategory  not found in ProgramCategorys table  , must be found in trash ProgramCategorys
        $programCategory=$this->programCategoryRepo->forceDelete($id,$this->programCategory);
                          if(is_string($programCategory)){
            return response()->json(['status'=>false,'message'=>$programCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    


}
