<?php
namespace Modules\News\Repositories\User;

use App\Repositories\EloquentRepository;

use Modules\News\Repositories\User\NewsRepositoryInterface;
use App\Scopes\ActiveScope;

class NewsRepository extends EloquentRepository implements NewsRepositoryInterface
{
       public function getAllPaginates($model,$request){
    $modelData=$model->with(['image','newsCategory'])->paginate($request->total);
       return  $modelData;
   }
}
