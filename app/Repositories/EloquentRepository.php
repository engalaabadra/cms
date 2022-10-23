<?php

namespace App\Repositories;

use App\GeneralClasses\MediaClass;
use Illuminate\Support\Arr;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;

class EloquentRepository
{

    public function all($model,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->where(['main_lang'=>$lang])->get();
          
        }else{
            $modelData=$model->withoutGlobalScope(LanguageScope::class)->get();
            
        }
      return  $modelData;
  }

    public function getAllPaginates($model,$request,$lang){
       // dd(6);
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->paginate($request->total);
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->paginate($request->total);
        }
       return  $modelData;
   }
   public  function trash($model,$request){
       if(is_string($this->findAllItemsOnlyTrashed($model))){
           return $this->findAllItemsOnlyTrashed($model);
       }
       $modelData=$this->findAllItemsOnlyTrashed($model)->paginate($request->total);
        return $modelData;
    }
    public function find($id,$model){
        
        $item=$model->withoutGlobalScope(ActiveScope::class)->withTrashed()->where('id',$id)->first();
            //  dd($item);
                if(empty($item)){
            return trans('messages.this item not found in system');

        }
        return $item;
    }
    public function findForUser($id,$model){
        
        $item=$model->withTrashed()->where('id',$id)->first();
                if(empty($item)){
            return trans('messages.this item not found in system');

        }
        return $item;
    }
    public function findItemOnlyTrashed($id,$model){        
        $itemInTrash=$model->onlyTrashed()->where('id',$id)->first();//item in trash
        if(empty($itemInTrash)){
                return trans('messages.this item not exist in trash');
        }else{
            $item=$model->onlyTrashed()->findOrFail($id);//find this item from trash
            return $item;
       }
    }
    public function findAllItemsOnlyTrashed($model){      
        $itemsInTrash=$model->onlyTrashed()->get();//items in trash
        // dd($itemsInTrash);
       if(count($itemsInTrash)==0){
                return trans('messages.there is not found any items in trash');
       }else{

           $items=$model->onlyTrashed();//get items from trash
           return $items;
       }
    }
    public function store($request,$model){
        $data=$request->validated();
        $data['main_lang']=config('app.locale');
        $item= $model->create($data);
        if(auth()->guard('api')->user()&&auth()->guard('api')->user()->id){
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
        if(auth()->guard('api')->user()&&auth()->guard('api')->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }
    
    public function storeImages($request,$dataImages,$folderName){
        $data=$request->validated();
        if(!empty($data[$dataImages])){
            if($request->hasFile($dataImages)){
                $arrImages=[];
                $files= $request->file($dataImages); //upload files 
                foreach($files as $file){
                    $file_path_original= MediaClass::store($file,$folderName);//store  images
                    $file_path_original= str_replace("public/","",$file_path_original);
                    $data[$dataImages]=$file_path_original;
                    array_push($arrImages,['filename'=>$file_path_original]);
                }
                
                return $arrImages;

            }
        }

    }
    public function storeImage($request,$dataImage,$folderName){
        $data=$request->validated();
        $file_path_original= MediaClass::store($request->file($dataImage),$folderName);//store image
        $file_path_original_without_public= str_replace("public/","",$file_path_original);
        $data[$dataImage]=$file_path_original_without_public;
        return $data[$dataImage];
    }
    
        public function storeThumb($request,$dataImage,$folderName){
        $data=$request->validated();
        $file_path_original= MediaClass::store($request->file($dataImage),$folderName);//store image
        $file_path_original_without_public= str_replace("public/","",$file_path_original);
        $data[$dataImage]=$file_path_original_without_public;
        return $data[$dataImage];
    }

    public function update($request,$id,$model){
        $item=$this->find($id,$model);
        if(is_string($item)){
            return trans('messages.this item not found in system');

        }
        $item->update($request->validated());
        
        if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $item;
    }

    //methods for restoring
    public function restore($id,$model){
        $item = $this->findItemOnlyTrashed($id,$model);//get this item from trash 
        if(is_string($item)){
            return $item;
        }else{
            
        if(!empty($item)){//this item not found in trash to restore it
            $item->restore();
        }
        
        if(auth()->user()->id){
            $action='Restore an item ';
            activity($model,$action);
        }
        return $item;
        }
    }
    public function restoreAll($model){
        $items = $this->findAllItemsOnlyTrashed($model);//get  items  from trash
        if(is_string($items)){
            
            return $items;
        }else{
            if(!empty($items)){//there is not found any item in trash
                $items = $items->restore();//restore all items from trash into items table
                
                if(auth()->user()->id){
                    $action='Restore All';
                    activity($model,$action);
                }
                return $items;
            }
        }
        
        
    }
    //methods for deleting
    public function destroy($id,$model){
        $item=$this->find($id,$model);
        if(is_string($item)){
            return $item;
        }
        if($item->deleted_at!==null){

            return trans('messages.this item already deleted permenetly');
        }
        $item->delete($item);
        
        
        if(auth()->user()->id){
            $action='Destroy Permenetly';
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
