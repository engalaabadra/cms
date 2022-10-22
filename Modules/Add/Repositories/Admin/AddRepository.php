<?php
namespace Modules\Add\Repositories\Admin;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Add\Repositories\Admin\AddRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class AddRepository extends EloquentRepository implements AddRepositoryInterface
{


        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['media'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['media'])->paginate($request->total);
            
        }
       return  $modelData;
   }
    public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['addCategory'])->paginate($request->total);
         return $modelData;
     }
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['file']);
        $item= $model->create($enteredData);
        //for file
        if(!empty($data['file'])){
            if($request->hasFile('file')){
                $path=$this->storeImage($request,'file','adds-files');
            $item->media()->create(['url'=>$path,'mediaable_id'=>$item->id,'mediaable_type'=>'Modules\Add\Entities\Add']);

            }
        }else{
            $data['file']=$item->media;

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
        $enteredData=  Arr::except($data ,['file']);
        $item->update($enteredData);
        if(!empty($data['file'])){
            if($request->hasFile('file')){
              $path=  $this->storeImage($request,'file','adds-files');

                if($item->media){
                    $item->media()->update(['url'=>$path,'mediaable_id'=>$item->id,'mediaable_type'=>'Modules\Add\Entities\Add']);
                }else{
                    $item->media()->create(['url'=>$path,'mediaable_id'=>$item->id,'mediaable_type'=>'Modules\Add\Entities\Add']);
                }
            }else{
            $data['file']=$item->media;
            }
        }else{
            $data['file']=$item->media;
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
