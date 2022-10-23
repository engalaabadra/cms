<?php

namespace Modules\Article\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\Entities\Article;
use Modules\Article\Http\Requests\DeleteArticleRequest;
use Modules\Article\Http\Requests\StoreArticleRequest;
use Modules\Article\Http\Requests\UpdateArticleRequest;
use Modules\Article\Repositories\Admin\ArticleRepository;

class ArticleController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ArticleRepository
     */
    protected $articleRepo;
    /**
     * @var Article
     */
    protected $article;
   

    /**
     * ArticlesController constructor.
     *
     * @param ArticleRepository $articles
     */
    public function __construct(BaseRepository $baseRepo, Article $article,ArticleRepository $articleRepo)
    {
        $this->middleware(['permission:articles_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:articles_trash'])->only('trash');
        $this->middleware(['permission:articles_restore'])->only('restore');
        $this->middleware(['permission:articles_restore-all'])->only('restore-all');
        $this->middleware(['permission:articles_show'])->only('show');
        $this->middleware(['permission:articles_store'])->only('store');
        $this->middleware(['permission:articles_update'])->only('update');
        $this->middleware(['permission:articles_destroy'])->only('destroy');
        $this->middleware(['permission:articles_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->article = $article;
        $this->articleRepo = $articleRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        try{
        $articles=$this->articleRepo->all($this->article,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articles],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
    }
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $articles=$this->articleRepo->getAllPaginates($this->article,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articles],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $articles=$this->articleRepo->trash($this->article,$request);
                if(is_string($articles)){
            return response()->json(['status'=>false,'message'=>$articles],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articles],200);

        
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
    public function store(StoreArticleRequest $request)
    {
        // try{
       $article= $this->articleRepo->store($request,$this->article);

          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
       public function storeTrans(StoreArticleRequest $request,$id,$lang)
    {
        // try{
       $article= $this->articleRepo->storeTrans($request,$this->article,$id,$lang);

          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
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
        $article=$this->articleRepo->find($id,$this->article);
                          if(is_string($article)){
            return response()->json(['status'=>false,'message'=>$article],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
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
    public function update(UpdateArticleRequest $request,$id)
    {
          try{
       $article= $this->articleRepo->update($request,$id,$this->article);
                                 if(is_string($article)){
            return response()->json(['status'=>false,'message'=>$article],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $article =  $this->articleRepo->restore($id,$this->article);
                                  if(is_string($article)){
            return response()->json(['status'=>false,'message'=>$article],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $articles =  $this->articleRepo->restoreAll($this->article);
                                  if(is_string($articles)){
            return response()->json(['status'=>false,'message'=>$articles],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articles],200);

        
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
    public function destroy(DeleteArticleRequest $request,$id)
    {
           try{
       $article= $this->articleRepo->destroy($id,$this->article);
                          if(is_string($article)){
            return response()->json(['status'=>false,'message'=>$article],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteArticleRequest $request,$id)
    {
          try{
        //to make force destroy for a Article must be this Article  not found in Articles table  , must be found in trash Articles
        $article=$this->articleRepo->forceDelete($id,$this->article);
                          if(is_string($article)){
            return response()->json(['status'=>false,'message'=>$article],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
