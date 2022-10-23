<?php
namespace Modules\Program\Repositories\Admin\Categories;

use App\Repositories\EloquentRepository;

use Modules\Program\Repositories\Admin\Categories\ProgramRepositoryInterface;

class ProgramRepository extends EloquentRepository implements ProgramRepositoryInterface
{


        
    
        public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['programs'])->paginate($request->total);
         return $modelData;
     }
         public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['image']);
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
                
              $path=  $this->storeImage($request,'image','programs-categories-images');
            
                                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Program\Entities\ProgramCategory']);

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
                
              $path=  $this->storeImage($request,'image','programs-categories-images');
            
                                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Program\Entities\ProgramCategory']);

            }
        }else{
            $data['image']=$item->image;

        }
        if(auth()->user()&&auth()->user()->id){
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
               $path= $this->storeImage($request,'image','programs-categories-images');
                if($item->image){
                    $item->image()->update(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Program\Entities\ProgramCategory']);
                }else{
                    $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Program\Entities\ProgramCategory']);
                }
            }else{
            $data['image']=$item->image;
            }
        }else{
            $data['image']=$item->image;
        }
        if(auth()->user()&&auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }

    
}
