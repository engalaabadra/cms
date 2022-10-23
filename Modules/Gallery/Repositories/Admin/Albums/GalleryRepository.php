<?php
namespace Modules\Gallery\Repositories\Admin\Albums;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Gallery\Repositories\Admin\Albums\GalleryRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class GalleryRepository extends EloquentRepository implements GalleryRepositoryInterface
{


        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['galleryCategory'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['galleryCategory'])->paginate($request->total);
            
        }
       return  $modelData;
   }
        public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['galleryCategory'])->paginate($request->total);
         return $modelData;
     }
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['image']);
        $enteredData['main_lang']=config('app.locale');
        $enteredData['status']=1;
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
                $path=$this->storeImage($request,'image','galary-albums-images');
                                                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Galary\Entities\GalleryAlbum']);

            }
        }else{
            $data['image']=$item->image;

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
               $path= $this->storeImage($request,'image','galary-albums-images');
                if($item->image){
                    $item->image()->update(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Galary\Entities\GalleryAlbum']);
                }else{
                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Galary\Entities\GalleryAlbum']);
                }
            }else{
            $data['image']=$item->image;
            }
        }else{
            $data['image']=$item->image;
        }
          if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }
    
}
