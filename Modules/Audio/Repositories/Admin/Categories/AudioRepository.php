<?php
namespace Modules\Audio\Repositories\Admin\Categories;

use App\Repositories\EloquentRepository;

use Modules\Audio\Repositories\Admin\Categories\AudioRepositoryInterface;

class AudioRepository extends EloquentRepository implements AudioRepositoryInterface
{

    public function getAllPaginates($model,$request){
    $modelData=$model->with(['audios'])->paginate($request->total);
       return  $modelData;
   
    }

    
}
