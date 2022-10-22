<?php
namespace Modules\Video\Repositories\Admin;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Video\Repositories\Admin\VideoRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class VideoRepository extends EloquentRepository implements VideoRepositoryInterface
{


     public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['videoCategory'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['videoCategory'])->paginate($request->total);
            
        }
       return  $modelData;
   }
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['thumb']);
        $item= $model->create($enteredData);
        //for thumb
        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
              $path=  $this->storeImage($request,'thumb','videos-thumbs');
                                  $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Video\Entities\Video']);

            }
        }else{
            $data['thumb']=$item->thumb;

        }
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }
        public function storeTrans($request,$model,$id,$lang){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['thumb']);
                $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
        $item= $model->create($enteredData);
        //for thumb
        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
               $path= $this->storeImage($request,'thumb','videos-thumbs');
                                   $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Video\Entities\Video']);

            }
        }else{
            $data['thumb']=$item->thumb;

        }
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }
    
   
    public function update($request,$id,$model){
        $data= $request->validated();
        $item=$this->find($id,$model);
        if(is_string($item)){
            return trans('messages.this item not found in system');

        }
        //for thumb
        $enteredData=  Arr::except($data ,['thumb']);
        $item->update($enteredData);
        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
               $path= $this->storeImage($request,'thumb','videos-thumbs');
                if($item->thumb){
                    $item->thumb()->update(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Video\Entities\Video']);
                }else{
                    $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Video\Entities\Video']);
                }
            }else{
            $data['thumb']=$item->thumb;
            }
        }else{
            $data['thumb']=$item->thumb;
        }
        if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }

    
}
