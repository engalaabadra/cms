<?php
namespace Modules\Project\Repositories\Admin;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Project\Repositories\Admin\ProjectRepositoryInterface;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class ProjectRepository extends EloquentRepository implements ProjectRepositoryInterface
{


        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with(['projectCategory'])->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with(['projectCategory'])->paginate($request->total);
            
        }
       return  $modelData;
   }
 public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['projectCategory'])->paginate($request->total);
         return $modelData;
     }
        
         public function store($request,$model){
            $data=$request->validated();
            $enteredData=  Arr::except($data ,['image']);
            $item= $model->create($enteredData);
            //for image
            if(!empty($data['image'])){
                if($request->hasFile('image')){
                 $path=   $this->storeImage($request,'image','projects-images');
                                                     $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\Project']);

                }
            }else{
                $data['image']=$item->image;
    
            }
            if(!empty($data['logo'])){
                if($request->hasFile('logo')){
                    $this->storeImage($request,'logo','projects-logos');
                }
            }else{
                $data['logo']=$item->logo;
    
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
                 $path=   $this->storeImage($request,'image','projects-images');
                                                     $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\Project']);

                }
            }else{
                $data['image']=$item->image;
    
            }
            if(!empty($data['logo'])){
                if($request->hasFile('logo')){
                    $this->storeImage($request,'logo','projects-logos');
                }
            }else{
                $data['logo']=$item->logo;
    
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
                   $path= $this->storeImage($request,'image','projects-images');
                    if($item->image){
                        $item->image()->update(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\Project']);
                    }else{
                        $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\Project']);
                    }
                }else{
                $data['image']=$item->image;
                }
            }else{
                $data['image']=$item->image;
            }

            if(!empty($data['logo'])){
                if($request->hasFile('logo')){
                    $this->storeImage($request,'logo','projects-logos');
                    if($item->image){
                        $item->image()->update(['url'=>$data['logo'],'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\Project']);
                    }else{
                        $item->image()->create(['url'=>$data['logo'],'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\Project']);
                    }
                }else{
                $data['logo']=$item->image;
                }
            }else{
                $data['logo']=$item->image;
            }
            if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
            return $item;
        }

    
}
