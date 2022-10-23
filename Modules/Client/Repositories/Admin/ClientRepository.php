<?php
namespace Modules\Client\Repositories\Admin;

use App\Repositories\EloquentRepository;

use Modules\Client\Repositories\Admin\ClientRepositoryInterface;

class ClientRepository extends EloquentRepository implements ClientRepositoryInterface
{


    public function getAllPaginates($model,$request){
        $modelData=$model->where('main_lang',config('app.locale'))->with(['clientCategory'])->paginate($request->total);
           return  $modelData;
       
        }
    
        public  function trash($model,$request){
            $modelData=$this->findAllItemsOnlyTrashed($model)->where('main_lang',config('app.locale'))->with(['clientCategory'])->paginate($request->total);
             return $modelData;
         }
        
    
}
