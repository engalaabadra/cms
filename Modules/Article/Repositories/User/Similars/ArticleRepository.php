<?php
namespace Modules\Article\Repositories\User\Similars;

use App\Repositories\EloquentRepository;

use Modules\Article\Repositories\User\ArticleRepositoryInterface;
use App\Scopes\ActiveScope;

class ArticleRepository extends EloquentRepository implements ArticleRepositoryInterface
{
       public function getAllPaginates($model,$request){
    $modelData=$model->with(['image','articleCategory'])->paginate($request->total);
       return  $modelData;
   }

}
