<?php
namespace Modules\Client\Repositories\Admin\Infos;

use App\Repositories\EloquentRepository;

use Modules\Client\Repositories\Admin\Infos\ClientCategoryRepositoryInterface;

class ClientRepository extends EloquentRepository implements ClientCategoryRepositoryInterface
{

    public function getAllPaginates($model,$request){
    $modelData=$model->with(['client'])->paginate($request->total);
       return  $modelData;
   
    }
    
    public function getAllInfosClientPaginates($model,$request,$clientId){
        $client=$model->where(['id'=>$clientId])->first();
        return  $client->infos;
    }

    
}
