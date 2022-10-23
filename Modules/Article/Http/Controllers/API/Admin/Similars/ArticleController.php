<?php

namespace Modules\Article\Http\Controllers\API\Admin\Similars;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Modules\Article\Entities\ArticleSimilar;
use Modules\Article\Entities\Article;
use Modules\Article\Http\Requests\Similars\StoreArticleRequest;
use Modules\Article\Http\Requests\Similars\DeleteArticleRequest;
use Modules\Article\Repositories\Admin\Similars\ArticleRepository;

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
     * @var ArticleSimilar
     */
    protected $articleSimilar;
    
        /**
     * @var Article
     */
    protected $article;
   

    /**
     * ArticleSimilarsController constructor.
     *
     * @param ArticleSimilarRepository $articleSimilars
     */
    public function __construct(BaseRepository $baseRepo, ArticleSimilar $articleSimilar, Article $article,ArticleRepository $articleSimilarRepo)
    {
        $this->middleware(['permission:articles-similars_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:articles-similars_trash'])->only('trash');
        $this->middleware(['permission:articles-similars_restore'])->only('restore');
        $this->middleware(['permission:articles-similars_restore-all'])->only('restore-all');
        $this->middleware(['permission:articles-similars_show'])->only('show');
        $this->middleware(['permission:articles-similars_store'])->only('store');
        $this->middleware(['permission:articles-similars_update'])->only('update');
        $this->middleware(['permission:articles-similars_destroy'])->only('destroy');
        $this->middleware(['permission:articles-similars_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->articleSimilar = $articleSimilar;
        $this->article = $article;
        $this->articleSimilarRepo = $articleSimilarRepo;
    }


    public function articleSimilarsPaginates($id,Request $request){
        $articleSimilars=$this->articleSimilarRepo->articleSimilarsPaginates($this->article,$id,$request);
                                  if(is_string($articleSimilars)){
            return response()->json(['status'=>false,'message'=>$articleSimilars],404);
        }
        return response()->json([
            'status'=>true,
            'code' => 200,
            'message' => 'articleSimilars  has been getten successfully',
            'data'=> $articleSimilars
        ]);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request,$articleId)
    {
        // try{
       $articleSimilar= $this->articleSimilarRepo->save($request,$this->articleSimilar,$articleId);
        if(is_string($articleSimilar)){
            return response()->json(['status'=>false,'message'=>$articleSimilar],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleSimilar],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteArticleRequest $request,$articleId,$similarId)
    {
        //   try{
       $articleSimilar= $this->articleSimilarRepo->destroySimilar($this->articleSimilar,$articleId,$similarId);
                          if(is_string($articleSimilar)){
            return response()->json(['status'=>false,'message'=>$articleSimilar],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleSimilar],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
       
    }



}
