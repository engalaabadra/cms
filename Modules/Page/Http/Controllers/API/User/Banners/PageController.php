<?php

namespace Modules\Page\Http\Controllers\API\User\Banners;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\PageBanner;
use Modules\Page\Repositories\User\Banners\PageRepository;

class PageController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var PageBannerRepository
     */
    protected $pageBannerRepo;
    /**
     * @var Page
     */
    protected $pageBanner;
   

    /**
     * PagesController constructor.
     *
     * @param PageBannerRepository $pageCategories
     */
    public function __construct(BaseRepository $baseRepo, PageBanner $pageBanner,PageRepository $pageBannerRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->pageBanner = $pageBanner;
        $this->pageBannerRepo = $pageBannerRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $pageCategories=$this->pageBannerRepo->all($this->pageBanner,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$pageCategories],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
    
}
