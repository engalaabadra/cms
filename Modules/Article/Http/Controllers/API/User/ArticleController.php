<?php

namespace Modules\Article\Http\Controllers\API\User;

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
    
        public function index($lang=null){
        
        //  try{
        $articles=$this->articleRepo->all($this->article,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articles],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
    
        public function show($id)
    {
              try{
        $article=$this->articleRepo->findForUser($id,$this->article);
        // dd($article);
                          if(is_string($article)){
            return response()->json(['status'=>false,'message'=>$article],404);
        }
        
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$article->load(['articleCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }



  
}
