<?php

namespace Modules\Project\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Project\Entities\Project;
use Modules\Project\Http\Requests\Category\DeleteProjectRequest;
use Modules\Project\Http\Requests\StoreProjectRequest;
use Modules\Project\Http\Requests\UpdateProjectRequest;
use Modules\Project\Repositories\Admin\ProjectRepository;

class ProjectController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ProjectRepository
     */
    protected $projectRepo;
    /**
     * @var Project
     */
    protected $project;
   

    /**
     * ProjectsController constructor.
     *
     * @param ProjectRepository $projects
     */
    public function __construct(BaseRepository $baseRepo, Project $project,ProjectRepository $projectRepo)
    {
        $this->middleware(['permission:projects_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:projects_trash'])->only('trash');
        $this->middleware(['permission:projects_restore'])->only('restore');
        $this->middleware(['permission:projects_restore-all'])->only('restore-all');
        $this->middleware(['permission:projects_show'])->only('show');
        $this->middleware(['permission:projects_store'])->only('store');
        $this->middleware(['permission:projects_update'])->only('update');
        $this->middleware(['permission:projects_destroy'])->only('destroy');
        $this->middleware(['permission:projects_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->project = $project;
        $this->projectRepo = $projectRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $projects=$this->projectRepo->all($this->project,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projects],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $projects=$this->projectRepo->getAllPaginates($this->project,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projects],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $projects=$this->projectRepo->trash($this->project,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projects],200);

        
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
        // try{
       $project= $this->projectRepo->store($request,$this->project);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$project->load(['projectCategory','image'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

    public function storeTrans(StoreProjectRequest $request,$id,$lang)
    {
        try{
       $project= $this->projectRepo->storeTrans($request,$this->project,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$project->load(['projectCategory','image'])],200);

        
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
        $project=$this->projectRepo->find($id,$this->project);
                          if(is_string($project)){
            return response()->json(['status'=>false,'message'=>$project],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$project->load(['projectCategory','image'])],200);

        
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
       $project= $this->projectRepo->update($request,$id,$this->project);
                                 if(is_string($project)){
            return response()->json(['status'=>false,'message'=>$project],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$project->load(['projectCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $project =  $this->projectRepo->restore($id,$this->project);
                                  if(is_string($project)){
            return response()->json(['status'=>false,'message'=>$project],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$project],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $projects =  $this->projectRepo->restoreAll($this->project);
                                  if(is_string($projects)){
            return response()->json(['status'=>false,'message'=>$projects],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$projects],200);

        
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
       $project= $this->projectRepo->destroy($id,$this->project);
                          if(is_string($project)){
            return response()->json(['status'=>false,'message'=>$project],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$project->load(['projectCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteProjectRequest $request,$id)
    {
          try{
        //to make force destroy for a Project must be this Project  not found in Projects table  , must be found in trash Projects
        $project=$this->projectRepo->forceDelete($id,$this->project);
                          if(is_string($project)){
            return response()->json(['status'=>false,'message'=>$project],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
