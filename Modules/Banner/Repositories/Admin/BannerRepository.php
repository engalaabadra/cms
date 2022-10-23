<?php
namespace Modules\Banner\Repositories\Admin;

use App\Repositories\EloquentRepository;

use Modules\Banner\Repositories\Admin\BannerRepositoryInterface;
use Illuminate\Support\Arr;
use App\GeneralClasses\MediaClass;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
class BannerRepository extends EloquentRepository implements BannerRepositoryInterface
{
 

        public function getAllPaginates($model,$request,$lang){
        $result=array_key_exists($lang, config('languages'));
        if($lang&&$result){
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->where(['main_lang'=>$lang])->with('image')->paginate($request->total);
          
        }else{
            $modelData=$model->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->with('image')->paginate($request->total);
            
        }
       return  $modelData;
   }
    // methods overrides
    public function store($request,$model){
        $data=$request->all();

        $enteredData=  Arr::except($data ,['image']);

        $Banner= $model->create($enteredData);



            if(!empty($data['image'])){
                if($request->hasFile('image')){
                    $file_path_original_image_Banner= MediaClass::store($request->file('image'),'banner-images');//store Banner image
                    
                                                        $file_path_original_without_public= str_replace("public/","",$file_path_original_image_Banner);

                $data['image']=$file_path_original_without_public;
                }else{
                    $data['image']=$Banner->image;
                }
                $Banner->image()->create(['url'=>$data['image'],'imageable_id'=>$Banner->id,'imageable_type'=>'Modules\Banner\Entities\Banner']);
            }
             if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
            return $Banner;
    }


    public function storeTrans($request,$model,$id,$lang){
        $data=$request->all();

        $enteredData=  Arr::except($data ,['image']);
                $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
        $Banner= $model->create($enteredData);



            if(!empty($data['image'])){
                if($request->hasFile('image')){
                    $file_path_original_image_Banner= MediaClass::store($request->file('image'),'banner-images');//store Banner image
                    
                                                        $file_path_original_without_public= str_replace("public/","",$file_path_original_image_Banner);

                $data['image']=$file_path_original_without_public;
                }else{
                    $data['image']=$Banner->image;
                }
                $Banner->image()->create(['url'=>$data['image'],'imageable_id'=>$Banner->id,'imageable_type'=>'Modules\Banner\Entities\Banner']);
            }
              if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
            return $Banner;
    }



        public function update($request,$id,$model){
        $Banner=$this->find($id,$model);
                if(is_string($Banner)){
            return trans('messages.this item not found in system');

        }

            $data= $request->all();
    
            $enteredData=  Arr::except($data ,['image']);
              $enteredData['translate_id']=$id;
        $enteredData['main_lang']=$lang;
            $Banner->update($enteredData);
            
    
    
         if(!empty($data['image'])){
               if($request->hasFile('image')){
                   $file_path_original= MediaClass::store($request->file('image'),'banner-images');//store Banner image
                                                                           $file_path_original_without_public= str_replace("public/","",$file_path_original);

                $data['image']=$file_path_original_without_public;

               }else{
                   $data['image']=$Banner->image;
               }
             if($Banner->image){
                 $Banner->image()->update(['url'=>$data['image'],'imageable_id'=>$Banner->id,'imageable_type'=>'Modules\Banner\Entities\Banner']);
       
             }else{
       
                 $Banner->image()->create(['url'=>$data['image'],'imageable_id'=>$Banner->id,'imageable_type'=>'Modules\Banner\Entities\Banner']);
             }
         }

        
  if(auth()->user()->id){
            $action='Update';
            activity($model,$action);
        }
        return $Banner;
    }


    
}
