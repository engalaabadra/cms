<?php
namespace Modules\Project\Repositories\Admin\Categories;

use App\Repositories\EloquentRepository;

use Modules\Project\Repositories\Admin\Categories\ProjectRepositoryInterface;
use Illuminate\Support\Arr;

class ProjectRepository extends EloquentRepository implements ProjectRepositoryInterface
{

 public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['projects'])->paginate($request->total);
         return $modelData;
     }
        public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['image']);
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
                
              $path=  $this->storeImage($request,'image','projects-categories-images');
            
                                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\ProjectCategory']);

            }
        }else{
            $data['image']=$item->image;

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
                
              $path=  $this->storeImage($request,'image','projects-categories-images');
            
                                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\ProjectCategory']);

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
        if(empty($item)){
            return trans('messages.this item not found in system');

        }
        //for image
        $enteredData=  Arr::except($data ,['image']);
        $item->update($enteredData);
        if(!empty($data['image'])){
            if($request->hasFile('image')){
               $path= $this->storeImage($request,'image','projects-categories-images');
                if($item->image){
                    $item->image()->update(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\ProjectCategory']);
                }else{
                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Project\Entities\ProjectCategory']);
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
