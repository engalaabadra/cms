<?php

namespace Modules\Gallery\Http\Controllers\API\User\Images;

use Modules\Gallery\Entities\GalleryImage;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Http\Requests\Images\DeleteGalleryRequest;
use Modules\Gallery\Http\Requests\Images\StoreGalleryRequest;
use Modules\Gallery\Http\Requests\Images\UpdateGalleryRequest;
use Modules\Gallery\Repositories\User\Images\GalleryRepository;

class GalleryController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var GalleryImageRepository
     */
    protected $galleryImageRepo;
    /**
     * @var Page
     */
    protected $galleryImage;
   

    /**
     * PagesController constructor.
     *
     * @param GalleryImageRepository $galleyAlbums
     */
    public function __construct(BaseRepository $baseRepo, GalleryImage $galleryImage,GalleryRepository $galleryImageRepo)
    {

        $this->baseRepo = $baseRepo;
        $this->galleryImage = $galleryImage;
        $this->galleryImageRepo = $galleryImageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $galleyAlbums=$this->galleryImageRepo->all($this->galleryImage,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$galleyAlbums],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    
}
