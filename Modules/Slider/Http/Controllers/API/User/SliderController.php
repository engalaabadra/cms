<?php

namespace Modules\Slider\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\User\SliderRepository;

class SliderController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var SliderRepository
     */
    protected $sliderRepo;
    /**
     * @var Slider
     */
    protected $slider;
   

    /**
     * SlidersController constructor.
     *
     * @param SliderRepository $sliders
     */
    public function __construct(BaseRepository $baseRepo, Slider $slider,SliderRepository $sliderRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->slider = $slider;
        $this->sliderRepo = $sliderRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $sliders=$this->sliderRepo->all($this->slider,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$sliders],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
}
