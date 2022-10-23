<?php

namespace Modules\Report\Http\Controllers\API\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Modules\Report\Entities\ReportCategory;
use Modules\Report\Http\Requests\Categories\StoreReportRequest;
use Modules\Report\Http\Requests\Categories\UpdateReportRequest;
use Modules\Report\Http\Requests\Categories\DeleteReportRequest;
use Modules\Report\Repositories\Admin\Categories\ReportRepository;

class ReportController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ReportRepository
     */
    protected $reportCategoryRepo;
    /**
     * @var ReportCategory
     */
    protected $reportCategory;
   

    /**
     * ReportCategorysController constructor.
     *
     * @param ReportCategoryRepository $reportCategorys
     */
    public function __construct(BaseRepository $baseRepo, ReportCategory $reportCategory,ReportRepository $reportCategoryRepo)
    {
        $this->middleware(['permission:report-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:report-categories_trash'])->only('trash');
        $this->middleware(['permission:report-categories_restore'])->only('restore');
        $this->middleware(['permission:report-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:report-categories_show'])->only('show');
        $this->middleware(['permission:report-categories_store'])->only('store');
        $this->middleware(['permission:report-categories_update'])->only('update');
        $this->middleware(['permission:report-categories_destroy'])->only('destroy');
        $this->middleware(['permission:report-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->reportCategory = $reportCategory;
        $this->reportCategoryRepo = $reportCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
         try{
        $reportCategorys=$this->reportCategoryRepo->all($this->reportCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategorys],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $reportCategorys=$this->reportCategoryRepo->getAllPaginates($this->reportCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategorys],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $reportCategorys=$this->reportCategoryRepo->trash($this->reportCategory,$request);
                if(is_string($reportCategorys)){
            return response()->json(['status'=>false,'message'=>$reportCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategorys],200);

        
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
    public function store(StoreReportRequest $request)
    {
        // try{
       $reportCategory= $this->reportCategoryRepo->store($request,$this->reportCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategory],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
    
        public function storeTrans(StoreReportRequest $request,$id,$lang)
    {
        try{
       $reportCategory= $this->reportCategoryRepo->storeTrans($request,$this->reportCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategory],200);

        
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
        $reportCategory=$this->reportCategoryRepo->find($id,$this->reportCategory);
        if(is_string($reportCategory)){
            return response()->json(['status'=>false,'message'=>$reportCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategory],200);

        
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
    public function update(UpdateReportRequest $request,$id)
    {
          try{
       $reportCategory= $this->reportCategoryRepo->update($request,$id,$this->reportCategory);
        if(is_string($reportCategory)){
            return response()->json(['status'=>false,'message'=>$reportCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $reportCategory =  $this->reportCategoryRepo->restore($id,$this->reportCategory);
        if(is_string($reportCategory)){
            return response()->json(['status'=>false,'message'=>$reportCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          //try{
        $reportCategorys =  $this->reportCategoryRepo->restoreAll($this->reportCategory);
         if(is_string($reportCategorys)){
            return response()->json(['status'=>false,'message'=>$reportCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategorys],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // }
        
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteReportRequest $request,$id)
    {
           try{
       $reportCategory= $this->reportCategoryRepo->destroy($id,$this->reportCategory);
                          if(is_string($reportCategory)){
            return response()->json(['status'=>false,'message'=>$reportCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reportCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteReportRequest $request,$id)
    {
          try{
        //to make force destroy for a ReportCategory must be this ReportCategory  not found in ReportCategorys table  , must be found in trash ReportCategorys
        $reportCategory=$this->reportCategoryRepo->forceDelete($id,$this->reportCategory);
                          if(is_string($reportCategory)){
            return response()->json(['status'=>false,'message'=>$reportCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    


}
