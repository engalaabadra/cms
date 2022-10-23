<?php

namespace Modules\Banner\Http\Controllers\API\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\BaseRepository;

use Modules\Banner\Repositories\User\BannerRepository;
use Modules\Banner\Entities\Banner;
class BannerController extends Controller
{
     /**
     * @var BannerRepository
     */
    protected $bannerRepo;
        /**
     * @var Banner
     */
    protected $banner;
   

    /**
     * BannersController constructor.
     *
     * @param BannerRepository $favorites
     */
    public function __construct(BaseRepository $baseRepo, Banner $banner,BannerRepository $bannerRepo)
    {

        $this->baseRepo = $baseRepo;
        $this->banner = $banner;
        $this->bannerRepo = $bannerRepo;
    }
 public function index($lang=null){
        $banners=$this->bannerRepo->all($this->banner,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$banners],200);

    } 
}
