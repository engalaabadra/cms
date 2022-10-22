<?php
namespace Modules\Client\Repositories\Admin\Infos;

interface ClientCategoryRepositoryInterface
{
      public function store($request,$model,$clientId){
        $data=$request->validated();
        $data['locale']=config('app.locale');
        $data['client_id']=$clientId;
        $item= $model->create($data);
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }
}
