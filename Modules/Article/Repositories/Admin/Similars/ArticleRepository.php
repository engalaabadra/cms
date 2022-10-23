<?php
namespace Modules\Article\Repositories\Admin\Similars;

use App\Repositories\EloquentRepository;

use Modules\Article\Repositories\Admin\Similars\ArticleRepositoryInterface;
use App\Scopes\ActiveScope;
use Modules\Article\Entities\Article;
class ArticleRepository extends EloquentRepository implements ArticleRepositoryInterface
{


   
        public function articleSimilarsPaginates($model,$id,$request){
        $article=$model->withoutGlobalScope(ActiveScope::class)->find($id);
        
        if(empty($article)){
            return trans(' this article not found to show similars');
        }
      return $article->articleSimilars()->with(['similar','similar.image'])->paginate($request->total);
        
        
    }
    
        public function save($request,$model,$articleId){
        $data=$request->all();
      $article= Article::where(['id'=>$articleId])->withoutGlobalScope(ActiveScope::class)->first();
      if(!empty($data['similar'])){

              $explodeSimilars=explode(',', $data['similar'][0]);
              foreach($explodeSimilars as $simi){
                  $similarArticleCount=$model->where(['similar'=>$simi,'article_id'=>$articleId])->count();
                  if($similarArticleCount!==0){
                      return trans('cannt add this similar to this article again');
                  }
              $similar=new $model;
              $similar->article_id=$articleId;
              $similar->similar=$simi;
                $similar->save();
                  
              }
              
      
      }
      return $article;
    
    }
    public function destroySimilar($model,$articleId,$similarId){
      $articleSimilar= $model->where(['article_id'=>$articleId,'similar'=>$similarId])->first();
      if($articleSimilar===null){
          return trans('this item not found');
      }else{
          
     $r= $model->find($articleSimilar->id);
     
      $r->delete();

    return 200;
      }
    }
}
