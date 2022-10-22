<?php
namespace Modules\Audio\Repositories\Admin;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Audio\Repositories\Admin\AudioRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class AudioRepository extends EloquentRepository implements AudioRepositoryInterface
{


        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['locale'=>$lang])->with(['audioCategory'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['audioCategory'])->paginate($request->total);
            
        }
       return  $modelData;
   }
    public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['audioCategory'])->paginate($request->total);
         return $modelData;
     }
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['thumb','audio']);
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
                $path=$this->storeImage($request,'thumb','audios-thumbs');
            $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Audio\Entities\Audio']);

            }
        }else{
            $data['thumb']=$item->thumb;

        }
        if(!empty($data['audio'])){
            if($request->hasFile('audio')){
                $path=$this->storeImage($request,'audio','audios-files');
            $item->media()->create(['url'=>$path,'mediaable_id'=>$item->id,'mediaable_type'=>'Modules\Audio\Entities\Audio']);

            }
        }else{
            $data['media']=$item->media;

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
        $enteredData=  Arr::except($data ,['thumb','audio']);
        $item->update($enteredData);
        if(!empty($data['thumb'])){
            if($request->hasFile('thumb')){
              $path=  $this->storeImage($request,'thumb','audios-thumbs');

                if($item->thumb){
                    $item->thumb()->update(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Audio\Entities\Audio']);
                }else{
                    $item->thumb()->create(['url'=>$path,'thumbable_id'=>$item->id,'thumbable_type'=>'Modules\Audio\Entities\Audio']);
                }
            }else{
            $data['thumb']=$item->thumb;
            }
        }else{
            $data['thumb']=$item->thumb;
        }
        
        
                if(!empty($data['audio'])){
            if($request->hasFile('audio')){
              $path=  $this->storeImage($request,'audio','audios-files');

                if($item->audio){
                    $item->media()->update(['url'=>$path,'mediaable_id'=>$item->id,'mediaable_type'=>'Modules\Audio\Entities\Audio']);
                }else{
                    $item->media()->create(['url'=>$path,'mediaable_id'=>$item->id,'mediaable_type'=>'Modules\Audio\Entities\Audio']);
                }
            }else{
            $data['audio']=$item->audio;
            }
        }else{
            $data['audio']=$item->audio;
        }
                if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }

    // public function forceDelete($id,$model){
    //     //to make force destroy for an item must be this item  not found in items table  , must be found in trash items
    //     $itemInTableitems = $this->find($id,$model);//find this item from  table items
    //     if(!empty($itemInTableitems)){//this item not found in items table
    //         $itemInTrash= $this->findItemOnlyTrashed($id,$model);//find this item from trash 
    //         if(empty($itemInTrash)){//this item not found in trash items
    //             return trans('messages.this item not found in trash');
    //         }else{
    //             MediaClass::delete($itemInTrash->image);
    //             $itemInTrash->forceDelete();
    //             return 200;
    //         }
    //     }else{
    //         return trans('messages.this item not found in system');
    //     }


    // }
    
}
