<?php

namespace Modules\Project\Http\Controllers\API\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Modules\Project\Entities\ProjectCategory;
use Modules\Project\Http\Requests\Categories\StoreProjectRequest;
use Modules\Project\Http\Requests\Categories\UpdateProjectRequest;
use Modules\Project\Http\Requests\Categories\DeleteProjectRequest;
use Modules\Project\Repositories\Admin\Categories\ProjectRepository;

class ProjectController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ProjectRepository
     */
    protected $projectCategoryRepo;
    /**
     * @var ProjectCategory
     */
    protected $projectCategory;
   

    /**
     * ProjectCategorysController constructor.
     *
     * @param ProjectCategoryRepository $projectCategorys
     */
    public function __construct(BaseRepository $baseRepo, ProjectCategory $projectCategory,ProjectRepository $projectCategoryRepo)
    {
        $this->middleware(['permission:project-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:project-categories_trash'])->only('trash');
        $this->middleware(['permission:project-categories_restore'])->only('restore');
        $this->middleware(['permission:project-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:project-categories_show'])->only('show');
        $this->middleware(['permission:project-categories_store'])->only('store');
        $this->middleware(['permission:project-categories_update'])->only('update');
        $this->middleware(['permission:project-categories_destroy'])->only('destroy');
        $this->middleware(['permission:project-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->projectCategory = $projectCategory;
        $this->projectCategoryRepo = $projectCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
//          try{
        $projectCategorys=$this->projectCategoryRepo->all($this->projectCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategorys],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $projectCategorys=$this->projectCategoryRepo->getAllPaginates($this->projectCategory,$request,$lang=null);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategorys],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $projectCategorys=$this->projectCategoryRepo->trash($this->projectCategory,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategorys],200);

        
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
    public function store(StoreProjectRequest $request)
    {
        try{
       $projectCategory= $this->projectCategoryRepo->store($request,$this->projectCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategory->load('image')],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }
    
        public function storeTrans(StoreProjectRequest $request,$id,$lang)
    {
        try{
       $projectCategory= $this->projectCategoryRepo->storeTrans($request,$this->projectCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategory->load('image')],200);

        
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
        $projectCategory=$this->projectCategoryRepo->find($id,$this->projectCategory);
                          if(is_string($projectCategory)){
            return response()->json(['status'=>false,'message'=>$projectCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategory->load('image')],200);

        
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
    public function update(UpdateProjectRequest $request,$id)
    {
          try{
       $projectCategory= $this->projectCategoryRepo->update($request,$id,$this->projectCategory);
                                 if(is_string($projectCategory)){
            return response()->json(['status'=>false,'message'=>$projectCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategory->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $projectCategory =  $this->projectCategoryRepo->restore($id,$this->projectCategory);
                                  if(is_string($projectCategory)){
            return response()->json(['status'=>false,'message'=>$projectCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategory->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $projectCategorys =  $this->projectCategoryRepo->restoreAll($this->projectCategory);
                                  if(is_string($projectCategorys)){
            return response()->json(['status'=>false,'message'=>$projectCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategorys],200);

        
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
    public function destroy(DeleteProjectRequest $request,$id)
    {
           try{
       $projectCategory= $this->projectCategoryRepo->destroy($id,$this->projectCategory);
                          if(is_string($projectCategory)){
            return response()->json(['status'=>false,'message'=>$projectCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projectCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteProjectCategoryRequest $request,$id)
    {
          try{
        //to make force destroy for a ProjectCategory must be this ProjectCategory  not found in ProjectCategorys table  , must be found in trash ProjectCategorys
        $projectCategory=$this->projectCategoryRepo->forceDelete($id,$this->projectCategory);
                          if(is_string($projectCategory)){
            return response()->json(['status'=>false,'message'=>$projectCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    


}
