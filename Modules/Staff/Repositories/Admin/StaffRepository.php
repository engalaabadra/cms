<?php
namespace Modules\Staff\Repositories\Admin;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Staff\Repositories\Admin\StaffRepositoryInterface;
use Image;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class StaffRepository extends EloquentRepository implements StaffRepositoryInterface
{

 
    public function store($request,$model){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['image']);
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
               $path= $this->storeImage($request,'image','staff-images');
                         $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Staff\Entities\Staff']);

                
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
            public function storeTrans($request,$model,$id,$lang){
        $data=$request->validated();
        $enteredData=  Arr::except($data ,['image']);
                $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
        $item= $model->create($enteredData);
        //for image
        if(!empty($data['image'])){
            if($request->hasFile('image')){
               $path= $this->storeImage($request,'image','staff-images');
               $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Staff\Entities\Staff']);

                
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
               $path= $this->storeImage($request,'image','staff-images');
                if($item->image){
                    $item->image()->update(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Staff\Entities\Staff']);
                }else{
               $item->image()->create(['url'=>$path,'imageable_id'=>$item->id,'imageable_type'=>'Modules\Staff\Entities\Staff']);
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
