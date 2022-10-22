<?php

namespace Modules\Article\Http\Controllers\API\User\Similars;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\Entities\Article;
use Modules\Article\Repositories\User\ArticleRepository;

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
        $this->baseRepo = $baseRepo;
        $this->article = $article;
        $this->articleRepo = $articleRepo;
    }
    
        public function getAllPaginates(Request $request){
        
        //  try{
        $articles=$this->articleRepo->getAllPaginates($this->article,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articles],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
    




  
}
