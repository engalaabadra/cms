<?php

namespace Modules\Search\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Search\Entities\Search;
use Modules\Search\Http\Requests\SendSearchRequest;
use Modules\Search\Repositories\User\SearchRepository;

class SearchController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var SearchRepository
     */
    protected $searchRepo;
    /**
     * @var Search
     */
    protected $search;
   

    /**
     * SearchsController constructor.
     *
     * @param SearchRepository $searchs
     */
    public function __construct(BaseRepository $baseRepo, Search $search,SearchRepository $searchRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->search = $search;
        $this->searchRepo = $searchRepo;
    }

public function getResultsSearch($word){
        
        //  try{
        $searchs=$this->searchRepo->getResultsSearch($this->search,$word);
        if(is_string($searchs)){
            return response()->json(['status'=>false,'message'=>$searchs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$searchs],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       
  
}
