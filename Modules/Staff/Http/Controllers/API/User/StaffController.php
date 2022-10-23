<?php

namespace Modules\Staff\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Staff\Entities\Staff;
use Modules\Staff\Repositories\User\StaffRepository;

class StaffController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var StaffRepository
     */
    protected $staffRepo;
    /**
     * @var Staff
     */
    protected $staff;
   

    /**
     * StaffsController constructor.
     *
     * @param StaffRepository $staffs
     */
    public function __construct(BaseRepository $baseRepo, Staff $staff,StaffRepository $staffRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->staff = $staff;
        $this->staffRepo = $staffRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $staffs=$this->staffRepo->all($this->staff,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffs],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);
        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $staffs=$this->staffRepo->getAllPaginates($this->staff,$request,$lang);
        
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffs],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $staffs=$this->staffRepo->trash($this->staff,$request);
        if(is_string($staffs)){
            return response()->json(['status'=>false,'message'=>$staffs],404);
        }
          return response()->json(['status'=>true,'message'=>$staffs],200);

        
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
        // try{
       $staff= $this->staffRepo->store($request,$this->staff);
       if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
        
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staff->load('StaffCategory')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreStaffRequest $request,$id,$lang)
    {
        // try{
       $staff= $this->staffRepo->storeTrans($request,$this->staff,$id,$lang);
       if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
        
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staff->load('StaffCategory')],200);

        
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
        $staff=$this->staffRepo->find($id,$this->staff);
                          if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staff->load('StaffCategory')],200);

        
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
          try{
       $staff= $this->staffRepo->update($request,$id,$this->staff);
                                 if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staff->load('StaffCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $staff =  $this->staffRepo->restore($id,$this->staff);
                                  if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staff->load('StaffCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $staffs =  $this->staffRepo->restoreAll($this->staff);
                                  if(is_string($staffs)){
            return response()->json(['status'=>false,'message'=>$staffs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staffs],200);

        
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
       $staff= $this->staffRepo->destroy($id,$this->staff);
                          if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$staff->load('StaffCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteStaffRequest $request,$id)
    {
          try{
        //to make force destroy for a Staff must be this Staff  not found in Staffs table  , must be found in trash Staffs
        $staff=$this->staffRepo->forceDelete($id,$this->staff);
                          if(is_string($staff)){
            return response()->json(['status'=>false,'message'=>$staff],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
