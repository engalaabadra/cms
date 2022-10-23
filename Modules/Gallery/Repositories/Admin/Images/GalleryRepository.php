<?php
namespace Modules\Gallery\Repositories\Admin\Images;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Gallery\Repositories\Admin\Images\GalleryRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class GalleryRepository extends EloquentRepository implements GalleryRepositoryInterface
{


        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['galleryAlbum','galleryPhotos'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['galleryAlbum','galleryPhotos'])->paginate($request->total);
            
        }
       return  $modelData;
   }
    public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['galleryAlbum'])->paginate($request->total);
         return $modelData;
     }
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['images']);
        $arrImages= $this->storeImages($request,'images','galaries-images');
        $item= $model->create($enteredData);
        $item->galleryPhotos()->createMany($arrImages);
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }


    public function storeTrans($request,$model,$id,$lang){
        $data=$request->validated();
        $data['translate_id']=$id;
        $data['main_lang']=$lang;
        $item= $model->create($data);
        $arrImages= $this->storeImages($request,'images','galaries-images');
        if($arrImages){
        $item->galleryPhotos()->createMany($arrImages);
            
        }
        if(auth()->user()&&auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }


    public function update($request,$id,$model){
        $data=$request->validated();
        $item=$this->find($id,$model);
        if(is_string($item)){
            return trans('messages.this item not found in system');
        }
        $enteredData=  Arr::except($data ,['images']);
        $item->update($enteredData);
        $arrImages= $this->storeImages($request,'images','galaries-images');
        if($arrImages){
            
        $item->galleryPhotos()->createMany($arrImages);
        //delete prev. images
        MediaClass::delete($item->galleryPhotos);
        }
        if(auth()->user()&&auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }
    
}
