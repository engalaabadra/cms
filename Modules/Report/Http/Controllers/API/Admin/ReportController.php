<?php

namespace Modules\Report\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Entities\Report;
use Modules\Report\Http\Requests\DeleteReportRequest;
use Modules\Report\Http\Requests\StoreReportRequest;
use Modules\Report\Http\Requests\UpdateReportRequest;
use Modules\Report\Repositories\Admin\ReportRepository;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
            /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ReportRepository
     */
    protected $reportRepo;
    /**
     * @var Report
     */
    protected $report;
   

    /**
     * ReportsController constructor.
     *
     * @param ReportRepository $reports
     */
    public function __construct(BaseRepository $baseRepo, Report $report,ReportRepository $reportRepo)
    {
        $this->middleware(['permission:reports_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:reports_trash'])->only('trash');
        $this->middleware(['permission:reports_restore'])->only('restore');
        $this->middleware(['permission:reports_restore-all'])->only('restore-all');
        $this->middleware(['permission:reports_show'])->only('show');
        $this->middleware(['permission:reports_store'])->only('store');
        $this->middleware(['permission:reports_update'])->only('update');
        $this->middleware(['permission:reports_destroy'])->only('destroy');
        $this->middleware(['permission:reports_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->report = $report;
        $this->reportRepo = $reportRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){

        try{
        $reports=$this->reportRepo->all($this->report,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reports],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $reports=$this->reportRepo->getAllPaginates($this->report,$request,$lang);
        // app()->setLocale(Storage::get('applocale'));
                    // dd(Storage::get('applocale'));

                    // dd(config('app.locale'));

          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reports],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
//   try{
        $reports=$this->reportRepo->trash($this->report,$request);
                if(is_string($reports)){
            return response()->json(['status'=>false,'message'=>$reports],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reports],200);

        
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
    public function storeTrans(StoreReportRequest $request,$id,$lang)
    {
        // try{
       $report= $this->reportRepo->storeTrans($request,$this->report,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$report->load(['reportCategory','image','thumb'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function store(StoreReportRequest $request)
    {
        // try{
       $report= $this->reportRepo->store($request,$this->report);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$report->load(['reportCategory','image','thumb'])],200);

        
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
        $report=$this->reportRepo->find($id,$this->report);
                          if(is_string($report)){
            return response()->json(['status'=>false,'message'=>$report],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$report->load(['reportCategory','image','thumb'])],200);

        
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

        //   try{
       $report= $this->reportRepo->update($request,$id,$this->report);
                                 if(is_string($report)){
            return response()->json(['status'=>false,'message'=>$report],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$report->load(['reportCategory','image','thumb'])],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $report =  $this->reportRepo->restore($id,$this->report);
                                  if(is_string($report)){
            return response()->json(['status'=>false,'message'=>$report],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$report->load(['reportCategory','image','thumb'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $reports =  $this->reportRepo->restoreAll($this->report);
                                  if(is_string($reports)){
            return response()->json(['status'=>false,'message'=>$reports],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$reports],200);

        
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
    public function destroy(DeleteReportRequest $request,$id)
    {
           try{
       $report= $this->reportRepo->destroy($id,$this->report);
                          if(is_string($report)){
            return response()->json(['status'=>false,'message'=>$report],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$report->load(['reportCategory','image','thumb'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteReportRequest $request,$id)
    {
          // try{
        //to make force destroy for a Report must be this Report  not found in Reports table  , must be found in trash Reports
        $report=$this->reportRepo->forceDelete($id,$this->report);
                          if(is_string($report)){
            return response()->json(['status'=>false,'message'=>$report],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
    


}
