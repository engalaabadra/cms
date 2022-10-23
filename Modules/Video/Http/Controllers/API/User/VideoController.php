<?php

namespace Modules\Video\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Video\Entities\Video;
use Modules\Video\Repositories\User\VideoRepository;

class VideoController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var VideoRepository
     */
    protected $videoRepo;
    /**
     * @var Video
     */
    protected $video;
   

    /**
     * VideosController constructor.
     *
     * @param VideoRepository $videos
     */
    public function __construct(BaseRepository $baseRepo, Video $video,VideoRepository $videoRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->video = $video;
        $this->videoRepo = $videoRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $videos=$this->videoRepo->all($this->video,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$videos],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

}
