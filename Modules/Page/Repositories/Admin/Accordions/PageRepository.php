<?php
namespace Modules\Page\Repositories\Admin\Accordions;

use App\GeneralClasses\MediaClass;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Arr;
use Modules\Page\Repositories\Admin\Accordions\PageRepositoryInterface;
use App\Scopes\ActiveScope;

class PageRepository extends EloquentRepository implements PageRepositoryInterface
{

    public function getAllPaginates($model,$request){
    $modelData=$model->withoutGlobalScope(ActiveScope::class)->with(['page'])->paginate($request->total);
       return  $modelData;
   
    }
        public  function trash($model,$request){
        $data=$this->findAllItemsOnlyTrashed($model);
                if(is_string($data)){
                    return $data;
        }
       $modelData= $data->with(['page'])->paginate($request->total);
         return $modelData;
     }
    

}
