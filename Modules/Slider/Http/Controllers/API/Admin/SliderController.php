<?php

namespace Modules\Slider\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\DeleteSliderRequest;
use Modules\Slider\Http\Requests\StoreSliderRequest;
use Modules\Slider\Http\Requests\UpdateSliderRequest;
use Modules\Slider\Repositories\Admin\SliderRepository;

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
        $this->middleware(['permission:sliders_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:sliders_trash'])->only('trash');
        $this->middleware(['permission:sliders_restore'])->only('restore');
        $this->middleware(['permission:sliders_restore-all'])->only('restore-all');
        $this->middleware(['permission:sliders_show'])->only('show');
        $this->middleware(['permission:sliders_store'])->only('store');
        $this->middleware(['permission:sliders_update'])->only('update');
        $this->middleware(['permission:sliders_destroy'])->only('destroy');
        $this->middleware(['permission:sliders_destroy-force'])->only('destroy-force');
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
        public function getAllPaginates(Request $request,$lang=null){
        
        //  try{
        $sliders=$this->sliderRepo->getAllPaginates($this->slider,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$sliders],200);

               
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $sliders=$this->sliderRepo->trash($this->slider,$request);
        if(is_string($sliders)){
            return response()->json(['status'=>false,'message'=>$sliders],404);
        }
          return response()->json(['status'=>true,'message'=>$sliders],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSliderRequest $request)
    {
        // try{
       $slider= $this->sliderRepo->store($request,$this->slider);
       if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$slider->load('image')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreSliderRequest $request,$id,$lang)
    {
        try{
       $slider= $this->sliderRepo->storeTrans($request,$this->slider,$id,$lang);
       if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$slider->load('image')],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              try{
        $slider=$this->sliderRepo->find($id,$this->slider);
                          if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$slider->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSliderRequest $request,$id)
    {
          try{
       $slider= $this->sliderRepo->update($request,$id,$this->slider);
                                 if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$slider->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $slider =  $this->sliderRepo->restore($id,$this->slider);
                                  if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$slider->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $sliders =  $this->sliderRepo->restoreAll($this->slider);
                                  if(is_string($sliders)){
            return response()->json(['status'=>false,'message'=>$sliders],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$sliders],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
        
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteSliderRequest $request,$id)
    {
           try{
       $slider= $this->sliderRepo->destroy($id,$this->slider);
                          if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$slider->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteSliderRequest $request,$id)
    {
          try{
        //to make force destroy for a Slider must be this Slider  not found in Sliders table  , must be found in trash Sliders
        $slider=$this->sliderRepo->forceDelete($id,$this->slider);
                          if(is_string($slider)){
            return response()->json(['status'=>false,'message'=>$slider],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
