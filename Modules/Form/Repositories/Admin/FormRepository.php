<?php
namespace Modules\Form\Repositories\Admin;

use App\Repositories\EloquentRepository;

use Modules\Form\Repositories\Admin\FormRepositoryInterface;
use Illuminate\Support\Arr;
use App\GeneralClasses\MediaClass;
use Modules\Client\Entities\Client;

class FormRepository extends EloquentRepository implements FormRepositoryInterface
{
   public function store($request,$model){
        $data=$request->validated();
        $data['main_lang']=config('app.locale');
        $item= $model->create($data);
        
        $client=new Client();
        $client->save();
        
        $item->client_id=$client->id;
        $item->save();
        
        if(auth()->user()->id){
            $action='Store';
            activity($model,$action);
        }
        return $item;
    }

    
}
