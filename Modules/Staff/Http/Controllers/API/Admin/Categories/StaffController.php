<?php

namespace Modules\Staff\Http\Controllers\API\Admin\Categories;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Staff\Entities\StaffCategory;
use Modules\Staff\Http\Requests\Categories\DeleteStaffRequest;
use Modules\Staff\Http\Requests\Categories\StoreStaffRequest;
use Modules\Staff\Http\Requests\Categories\UpdateStaffRequest;
use Modules\Staff\Repositories\Admin\Categories\StaffRepository;

class StaffController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var StaffCategoryRepository
     */
    protected $staffCategoryRepo;
    /**
     * @var StaffCategory
     */
    protected $staffCategory;
   

    /**
     * StaffsController constructor.
     *
     * @param StaffCategoryRepository $staffCategories
     */
    public function __construct(BaseRepository $baseRepo, StaffCategory $staffCategory,StaffRepository $staffCategoryRepo)
    {
        $this->middleware(['permission:staff-categories_read'])->only(['index','getAllPaginates']);
        $this->middleware(['permission:staff-categories_trash'])->only('trash');
        $this->middleware(['permission:staff-categories_restore'])->only('restore');
        $this->middleware(['permission:staff-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:staff-categories_show'])->only('show');
        $this->middleware(['permission:staff-categories_store'])->only('store');
        $this->middleware(['permission:staff-categories_update'])->only('update');
        $this->middleware(['permission:staff-categories_destroy'])->only('destroy');
        $this->middleware(['permission:staff-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->staffCategory = $staffCategory;
        $this->staffCategoryRepo = $staffCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $staffCategories=$this->staffCategoryRepo->all($this->staffCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategories],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $staffCategories=$this->staffCategoryRepo->getAllPaginates($this->staffCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategories],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $staffCategories=$this->staffCategoryRepo->trash($this->staffCategory,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategories],200);

        
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
    public function store(StoreStaffRequest $request)
    {
        try{
       $staffCategory= $this->staffCategoryRepo->store($request,$this->staffCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategory],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }
        public function storeTrans(StoreStaffRequest $request,$id,$lang)
    {
        try{
       $staffCategory= $this->staffCategoryRepo->storeTrans($request,$this->staffCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategory],200);

        
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
        $staffCategory=$this->staffCategoryRepo->find($id,$this->staffCategory);
                          if(is_string($staffCategory)){
            return response()->json(['status'=>false,'message'=>$staffCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategory->load('StaffCategory')],200);

        
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
    public function update(UpdateStaffRequest $request,$id)
    {
        //   try{
       $staffCategory= $this->staffCategoryRepo->update($request,$id,$this->staffCategory);
                                 if(is_string($staffCategory)){
            return response()->json(['status'=>false,'message'=>$staffCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategory],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $staffCategory =  $this->staffCategoryRepo->restore($id,$this->staffCategory);
                                  if(is_string($staffCategory)){
            return response()->json(['status'=>false,'message'=>$staffCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $staffCategories =  $this->staffCategoryRepo->restoreAll($this->staffCategory);
                                  if(is_string($staffCategories)){
            return response()->json(['status'=>false,'message'=>$staffCategories],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategories],200);

        
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
    public function destroy(DeleteStaffRequest $request,$id)
    {
           try{
       $staffCategory= $this->staffCategoryRepo->destroy($id,$this->staffCategory);
                          if(is_string($staffCategory)){
            return response()->json(['status'=>false,'message'=>$staffCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteStaffRequest $request,$id)
    {
          try{
        //to make force destroy for a Staff must be this Staff  not found in Staffs table  , must be found in trash Staffs
        $staffCategory=$this->staffCategoryRepo->forceDelete($id,$this->staffCategory);
                          if(is_string($staffCategory)){
            return response()->json(['status'=>false,'message'=>$staffCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
