<?php

namespace Modules\ContactUs\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContactUs\Entities\ContactUs;
use Modules\ContactUs\Http\Requests\DeleteContactRequest;
use Modules\ContactUs\Http\Requests\StoreContactRequest;
use Modules\ContactUs\Http\Requests\UpdateContactRequest;
use Modules\ContactUs\Repositories\Admin\ContactRepository;

class ContactController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ContactRepository
     */
    protected $contactUsRepo;
    /**
     * @var Contact
     */
    protected $contactUs;
   

    /**
     * ContactsController constructor.
     *
     * @param ContactRepository $contactUss
     */
    public function __construct(BaseRepository $baseRepo, ContactUs $contactUs,ContactRepository $contactUsRepo)
    {
        $this->middleware(['permission:contacts_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:contacts_trash'])->only('trash');
        $this->middleware(['permission:contacts_restore'])->only('restore');
        $this->middleware(['permission:contacts_restore-all'])->only('restore-all');
        $this->middleware(['permission:contacts_show'])->only('show');
        $this->middleware(['permission:contacts_store'])->only('store');
        $this->middleware(['permission:contacts_update'])->only('update');
        $this->middleware(['permission:contacts_destroy'])->only('destroy');
        $this->middleware(['permission:contacts_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->contactUs = $contactUs;
        $this->contactUsRepo = $contactUsRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $contactUss=$this->contactUsRepo->all($this->contactUs,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUss],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $contactUss=$this->contactUsRepo->getAllPaginates($this->contactUs,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUss],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
//   try{
        $contactUss=$this->contactUsRepo->trash($this->contactUs,$request);
                                  if(is_string($contactUss)){
            return response()->json(['status'=>false,'message'=>$contactUss],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUss],200);

        
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
        $contactUs=$this->contactUsRepo->find($id,$this->contactUs);
                          if(is_string($contactUs)){
            return response()->json(['status'=>false,'message'=>$contactUs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUs],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

 


    //methods for restoring
    public function restore($id){
        
          try{
        $contactUs =  $this->contactUsRepo->restore($id,$this->contactUs);
                                  if(is_string($contactUs)){
            return response()->json(['status'=>false,'message'=>$contactUs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUs],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $contactUss =  $this->contactUsRepo->restoreAll($this->contactUs);
                                  if(is_string($contactUss)){
            return response()->json(['status'=>false,'message'=>$contactUss],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUss],200);

        
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
    public function destroy(DeleteContactRequest $request,$id)
    {
           try{
       $contactUs= $this->contactUsRepo->destroy($id,$this->contactUs);
                          if(is_string($contactUs)){
            return response()->json(['status'=>false,'message'=>$contactUs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUs],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteContactRequest $request,$id)
    {
          try{
        //to make force destroy for a Contact must be this Contact  not found in Contacts table  , must be found in trash Contacts
        $contactUs=$this->contactUsRepo->forceDelete($id,$this->contactUs);
                          if(is_string($contactUs)){
            return response()->json(['status'=>false,'message'=>$contactUs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
