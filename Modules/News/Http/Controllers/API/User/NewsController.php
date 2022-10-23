<?php

namespace Modules\News\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Entities\News;
use Modules\News\Repositories\User\NewsRepository;

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
        $this->baseRepo = $baseRepo;
        $this->news = $news;
        $this->newsRepo = $newsRepo;
    }
    
        public function getAllPaginates(Request $request){
        
        //  try{
        $newss=$this->newsRepo->getAllPaginates($this->news,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newss],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
    
    
        public function show($id)
    {
              try{
        $news=$this->newsRepo->findForUser($id,$this->news);
        // dd($news);
                          if(is_string($news)){
            return response()->json(['status'=>false,'message'=>$news],404);
        }
        
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$news->load(['newsCategory','image'])],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

  
}
