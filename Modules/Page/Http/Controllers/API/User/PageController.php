<?php

namespace Modules\Page\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\User\PageRepository;

class PageController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var PageRepository
     */
    protected $pageRepo;
    /**
     * @var Page
     */
    protected $page;
   

    /**
     * PagesController constructor.
     *
     * @param PageRepository $pages
     */
    public function __construct(BaseRepository $baseRepo, Page $page,PageRepository $pageRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->page = $page;
        $this->pageRepo = $pageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $pages=$this->pageRepo->all($this->page,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pages],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
      
}
