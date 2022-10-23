<?php

namespace Modules\Template\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Template\Entities\Template;
use Modules\Template\Http\Requests\DeleteTemplateRequest;
use Modules\Template\Http\Requests\StoreTemplateRequest;
use Modules\Template\Http\Requests\UpdateTemplateRequest;
use Modules\Template\Repositories\Admin\TemplateRepository;

class TemplateController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var TemplateRepository
     */
    protected $templateRepo;
    /**
     * @var Template
     */
    protected $template;
   

    /**
     * TemplatesController constructor.
     *
     * @param TemplateRepository $templates
     */
    public function __construct(BaseRepository $baseRepo, Template $template,TemplateRepository $templateRepo)
    {
        $this->middleware(['permission:templates_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:templates_trash'])->only('trash');
        $this->middleware(['permission:templates_restore'])->only('restore');
        $this->middleware(['permission:templates_restore-all'])->only('restore-all');
        $this->middleware(['permission:templates_show'])->only('show');
        $this->middleware(['permission:templates_store'])->only('store');
        $this->middleware(['permission:templates_update'])->only('update');
        $this->middleware(['permission:templates_destroy'])->only('destroy');
        $this->middleware(['permission:templates_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->template = $template;
        $this->templateRepo = $templateRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $templates=$this->templateRepo->all($this->template,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$templates],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request){
        
         try{
        $templates=$this->templateRepo->getAllPaginates($this->template,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$templates],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $templates=$this->templateRepo->trash($this->template,$request);
          return response()->json(['status'=>true,'message'=>$templates],200);

        
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
    public function store(StoreTemplateRequest $request)
    {
        // try{
       $template= $this->templateRepo->store($request,$this->template);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$template],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    public function storeTrans(StoreTemplateRequest $request,$id,$lang)
    {
        // try{
       $template= $this->templateRepo->storeTrans($request,$this->template,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$template],200);

        
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
        $template=$this->templateRepo->find($id,$this->template);
        if(is_string($template)){
            return response()->json(['status'=>false,'message'=>$template],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$template],200);

        
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
    public function update(UpdateTemplateRequest $request,$id)
    {
          try{
       $template= $this->templateRepo->update($request,$id,$this->template);
                                 if(is_string($template)){
            return response()->json(['status'=>false,'message'=>$template],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$template],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $template =  $this->templateRepo->restore($id,$this->template);
                                  if(is_string($template)){
            return response()->json(['status'=>false,'message'=>$template],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$template],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $templates =  $this->templateRepo->restoreAll($this->template);
                                  if(is_string($templates)){
            return response()->json(['status'=>false,'message'=>$templates],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$templates],200);

        
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
    public function destroy(DeleteTemplateRequest $request,$id)
    {
           try{
       $template= $this->templateRepo->destroy($id,$this->template);
                          if(is_string($template)){
            return response()->json(['status'=>false,'message'=>$template],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$template],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteTemplateRequest $request,$id)
    {
          try{
        //to make force destroy for a Template must be this Template  not found in Templates table  , must be found in trash Templates
        $template=$this->templateRepo->forceDelete($id,$this->template);
                          if(is_string($template)){
            return response()->json(['status'=>false,'message'=>$template],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
