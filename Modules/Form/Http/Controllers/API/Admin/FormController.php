<?php

namespace Modules\Form\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Form\Entities\Form;
use Modules\Form\Http\Requests\DeleteFormRequest;
use Modules\Form\Http\Requests\StoreFormRequest;
use Modules\Form\Http\Requests\UpdateFormRequest;
use Modules\Form\Repositories\Admin\FormRepository;

class FormController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var FormRepository
     */
    protected $formRepo;
    /**
     * @var Form
     */
    protected $form;
   

    /**
     * FormsController constructor.
     *
     * @param FormRepository $forms
     */
    public function __construct(BaseRepository $baseRepo, Form $form,FormRepository $formRepo)
    {
        // $this->middleware(['permission:forms_read'])->only('index');
        // $this->middleware(['permission:forms_trash'])->only('trash');
        // $this->middleware(['permission:forms_restore'])->only('restore');
        // $this->middleware(['permission:forms_restore-all'])->only('restore-all');
        // $this->middleware(['permission:forms_show'])->only('show');
        // $this->middleware(['permission:forms_store'])->only('store');
        // $this->middleware(['permission:forms_destroy'])->only('destroy');
        // $this->middleware(['permission:forms_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->form = $form;
        $this->formRepo = $formRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $forms=$this->formRepo->all($this->form,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$forms],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $forms=$this->formRepo->getAllPaginates($this->form,$request,$lang,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$forms],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
//   try{
        $forms=$this->formRepo->trash($this->form,$request);
                                  if(is_string($forms)){
            return response()->json(['status'=>false,'message'=>$forms],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$forms],200);

        
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
        $form=$this->formRepo->find($id,$this->form);
                          if(is_string($form)){
            return response()->json(['status'=>false,'message'=>$form],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$form],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    public function store(StoreFormRequest $request){
        
        //   try{
        $form =  $this->formRepo->store($request,$this->form);
                                  if(is_string($form)){
            return response()->json(['status'=>false,'message'=>$form],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$form],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 

    }
 

 

    //methods for restoring
    public function restore($id){
        
          try{
        $form =  $this->formRepo->restore($id,$this->form);
                                  if(is_string($form)){
            return response()->json(['status'=>false,'message'=>$form],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$form],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $forms =  $this->formRepo->restoreAll($this->form);
                                  if(is_string($forms)){
            return response()->json(['status'=>false,'message'=>$forms],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$forms],200);

        
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
    public function destroy(DeleteFormRequest $request,$id)
    {
           try{
       $form= $this->formRepo->destroy($id,$this->form);
                          if(is_string($form)){
            return response()->json(['status'=>false,'message'=>$form],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$form],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteFormRequest $request,$id)
    {
          try{
        //to make force destroy for a Form must be this Form  not found in Forms table  , must be found in trash Forms
        $form=$this->formRepo->forceDelete($id,$this->form);
                          if(is_string($form)){
            return response()->json(['status'=>false,'message'=>$form],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
