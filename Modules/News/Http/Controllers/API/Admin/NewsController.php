<?php

namespace Modules\News\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Entities\News;
use Modules\News\Http\Requests\DeleteNewsRequest;
use Modules\News\Http\Requests\StoreNewsRequest;
use Modules\News\Http\Requests\UpdateNewsRequest;
use Modules\News\Repositories\Admin\NewsRepository;

class NewsController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var NewsRepository
     */
    protected $newsRepo;
    /**
     * @var News
     */
    protected $news;
   

    /**
     * NewssController constructor.
     *
     * @param NewsRepository $newss
     */
    public function __construct(BaseRepository $baseRepo, News $news,NewsRepository $newsRepo)
    {
        // $this->middleware(['permission:news_read'])->only('index');
        // $this->middleware(['permission:news_trash'])->only('trash');
        // $this->middleware(['permission:news_restore'])->only('restore');
        // $this->middleware(['permission:news_restore-all'])->only('restore-all');
        // $this->middleware(['permission:news_show'])->only('show');
        // $this->middleware(['permission:news_store'])->only('store');
        // $this->middleware(['permission:news_update'])->only('update');
        // $this->middleware(['permission:news_destroy'])->only('destroy');
        // $this->middleware(['permission:news_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->news = $news;
        $this->newsRepo = $newsRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $newss=$this->newsRepo->all($this->news,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newss],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $newss=$this->newsRepo->getAllPaginates($this->news,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newss],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $newss=$this->newsRepo->trash($this->news,$request);
                if(is_string($newss)){
            return response()->json(['status'=>false,'message'=>$newss],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newss],200);

        
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
    public function store(StoreNewsRequest $request)
    {
        // try{
       $news= $this->newsRepo->store($request,$this->news);

          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['NewsCategory','image'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
    
      public function storeTrans(StoreNewsRequest $request,$id,$lang)
    {
        // try{
       $news= $this->newsRepo->storeTrans($request,$this->news,$id,$lang);

          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['NewsCategory','image'])],200);

        
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
        $news=$this->newsRepo->find($id,$this->news);
                          if(is_string($news)){
            return response()->json(['status'=>false,'message'=>$news],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['NewsCategory','image'])],200);

        
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
    public function update(UpdateNewsRequest $request,$id)
    {
          try{
       $news= $this->newsRepo->update($request,$id,$this->news);
                                 if(is_string($news)){
            return response()->json(['status'=>false,'message'=>$news],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['NewsCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $news =  $this->newsRepo->restore($id,$this->news);
                                  if(is_string($news)){
            return response()->json(['status'=>false,'message'=>$news],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['NewsCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $newss =  $this->newsRepo->restoreAll($this->news);
                                  if(is_string($newss)){
            return response()->json(['status'=>false,'message'=>$newss],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newss],200);

        
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
    public function destroy(DeleteNewsRequest $request,$id)
    {
           try{
       $news= $this->newsRepo->destroy($id,$this->news);
                          if(is_string($news)){
            return response()->json(['status'=>false,'message'=>$news],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['NewsCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteNewsRequest $request,$id)
    {
          try{
        //to make force destroy for a News must be this News  not found in Newss table  , must be found in trash Newss
        $news=$this->newsRepo->forceDelete($id,$this->news);
                          if(is_string($news)){
            return response()->json(['status'=>false,'message'=>$news],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
