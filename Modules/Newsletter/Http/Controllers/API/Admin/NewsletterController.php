<?php

namespace Modules\Newsletter\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\Entities\Newsletter;
use Modules\Newsletter\Http\Requests\DeleteNewsletterRequest;
use Modules\Newsletter\Http\Requests\StoreNewsletterRequest;
use Modules\Newsletter\Http\Requests\UpdateNewsletterRequest;
use Modules\Newsletter\Repositories\Admin\NewsletterRepository;

class NewsletterController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var NewsletterRepository
     */
    protected $newslatterRepo;
    /**
     * @var Newsletter
     */
    protected $newslatter;
   

    /**
     * NewslettersController constructor.
     *
     * @param NewsletterRepository $newslatters
     */
    public function __construct(BaseRepository $baseRepo, Newsletter $newslatter,NewsletterRepository $newslatterRepo)
    {
        $this->middleware(['permission:newsletters_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:newsletters_trash'])->only('trash');
        $this->middleware(['permission:newsletters_restore'])->only('restore');
        $this->middleware(['permission:newsletters_restore-all'])->only('restore-all');
        $this->middleware(['permission:newsletters_show'])->only('show');
        $this->middleware(['permission:newsletters_store'])->only('store');
        $this->middleware(['permission:newsletters_update'])->only('update');
        $this->middleware(['permission:newsletters_destroy'])->only('destroy');
        $this->middleware(['permission:newsletters_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->newslatter = $newslatter;
        $this->newslatterRepo = $newslatterRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $newslatters=$this->newslatterRepo->all($this->newslatter,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatters],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $newslatters=$this->newslatterRepo->getAllPaginates($this->newslatter,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatters],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $newslatters=$this->newslatterRepo->trash($this->newslatter,$request);
              if(is_string($newslatters)){
            return response()->json(['status'=>false,'message'=>$newslatters],404);
        }
          return response()->json(['status'=>true,'message'=>$newslatters],200);

        
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
    public function store(StoreNewsletterRequest $request)
    {
        // try{
       $newslatter= $this->newslatterRepo->store($request,$this->newslatter);
       if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatter],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

    public function storeTrans(StoreNewsletterRequest $request,$id,$lang)
    {
        // try{
       $newslatter= $this->newslatterRepo->storeTrans($request,$this->newslatter,$id,$lang);
       if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatter],200);

        
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
        $newslatter=$this->newslatterRepo->find($id,$this->newslatter);
                          if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatter],200);

        
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
    public function update(UpdateNewsletterRequest $request,$id)
    {
          try{
       $newslatter= $this->newslatterRepo->update($request,$id,$this->newslatter);
                                 if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatter],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $newslatter =  $this->newslatterRepo->restore($id,$this->newslatter);
                                  if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatter],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
        //   try{
        $newslatters =  $this->newslatterRepo->restoreAll($this->newslatter);
                                  if(is_string($newslatters)){
            return response()->json(['status'=>false,'message'=>$newslatters],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatters],200);

        
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
    public function destroy(DeleteNewsletterRequest $request,$id)
    {
           try{
       $newslatter= $this->newslatterRepo->destroy($id,$this->newslatter);
                          if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newslatter],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteNewsletterRequest $request,$id)
    {
          try{
        //to make force destroy for a Newsletter must be this Newsletter  not found in Newsletters table  , must be found in trash Newsletters
        $newslatter=$this->newslatterRepo->forceDelete($id,$this->newslatter);
                          if(is_string($newslatter)){
            return response()->json(['status'=>false,'message'=>$newslatter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
