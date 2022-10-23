<?php
namespace Modules\Report\Repositories\Admin;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Report\Repositories\Admin\ReportRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class ReportRepository extends EloquentRepository implements ReportRepositoryInterface
{

  
        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['reportCategory'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['reportCategory'])->paginate($request->total);
            
        }
       return  $modelData;
   }

    public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['reportCategory'])->paginate($request->total);
         return $modelData;
     }
    
     public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['image','thumb']);
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
               $path= $this->storeImage($request,'image','reports-images');
                                                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Report\Entities\Report']);

            }
        }else{
            $data['image']=$item->image;
        }
        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
               $path= $this->storeImage($request,'thumb','reports-thumbs');
             $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Report\Entities\Report']);

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
        $enteredData=  Arr::except($data ,['image']);
                $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
               $path= $this->storeImage($request,'image','reports-images');
                 $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Report\Entities\Report']);

            }
        }else{
            $data['image']=$item->image;

        }
           if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
               $path= $this->storeImage($request,'thumb','reports-thumbs');
             $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Report\Entities\Report']);

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
        //for image
        $enteredData=  Arr::except($data ,['image']);
        $item->update($enteredData);
        if(!empty($data['image'])){
            if($request->hasFile('image')){
              $path=  $this->storeImage($request,'image','reports-images');

                if($item->image){
                    $item->image()->update(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Report\Entities\Report']);
                }else{
                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Report\Entities\Report']);
                }
            }else{
            $data['image']=$item->image;
            }
        }else{
            $data['image']=$item->image;
        }

        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
              $pathT= $this->storeThumb($request,'thumb','reports-thumbs');
                if($item->thumb){
                    $item->thumb()->update(['url'=>$pathT,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Report\Entities\Report']);
                }else{
                    $item->thumb()->create(['url'=>$pathT,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Report\Entities\Report']);
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
