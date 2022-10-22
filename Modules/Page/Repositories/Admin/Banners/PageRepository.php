<?php
namespace Modules\Page\Repositories\Admin\Banners;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Page\Repositories\Admin\Banners\PageRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class PageRepository extends EloquentRepository implements PageRepositoryInterface
{


    public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['page','pageBannerPhotos'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['page','pageBannerPhotos'])->paginate($request->total);
            
        }
       return  $modelData;
   }
        public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['page','pageBannerPhotos'])->paginate($request->total);
         return $modelData;
     }
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['images']);
        $arrImages= $this->storeImages($request,'images','page-banners-images');
        
        $item= $model->create($enteredData);
        $item->pageBannerPhotos()->createMany($arrImages);
          if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }
        public function storeTrans($request,$model,$id,$lang){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['images']);
                        $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
        $arrImages= $this->storeImages($request,'images','page-banners-images');
        
        $item= $model->create($enteredData);
        
        $item->pageBannerPhotos()->createMany($arrImages);
          if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }
    public function update($request,$id,$model){
        $data=$request->validated();
        $item=$this->find($id,$model);
        if(empty($item)){
            return trans('messages.this item not found in system');
        }
        $enteredData=  Arr::except($data ,['images']);
        $item->update($enteredData);
        $arrImages= $this->storeImages($request,'images','page-banners-images');
        $item->pageBannerPhotos()->createMany($arrImages);
            
        
        //delete prev. images
        MediaClass::delete($item->pageBannerPhotos);
          if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }


      public function forceDelete($id,$model){
        //to make force destroy for an item must be this item  not found in items table  , must be found in trash items
        $itemInTableitems = $this->find($id,$model);//find this item from  table items
        if(!empty($itemInTableitems)){//this item not found in items table
            $itemInTrash= $this->findItemOnlyTrashed($id,$model);//find this item from trash 
            
            if(is_string($itemInTrash)){//this item not found in trash items
                return trans('messages.this item not found in trash');
            }else{
                                MediaClass::delete($itemInTrash->pageBannerPhotos);

                $itemInTrash->forceDelete();
                
                if(auth()->user()->id){
                    $action='Destroy Forcely';
                    activity($model,$action);
                }
                return 200;
            }
        }else{
            return trans('messages.this item not found in system');
        }


    }

}
