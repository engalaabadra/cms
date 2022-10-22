<?php
namespace Modules\Search\Repositories\User;

use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Storage;
use Modules\Search\Repositories\User\SearchRepositoryInterface;
class SearchRepository extends EloquentRepository implements SearchRepositoryInterface
{

    public function getResultsSearch($model,$word){
        
        //generate session id
       // $session_id=Storage::get('session_id');
         //       dd($session_id);
        if(isset(Storage::get('session_id'))){
            $session_id= Str::random(30);
            Storage::put('session_id',$session_id);
            Search::insert(['word'=>$word,'session_id'=>$session_id]);

        }else{
            Search::insert(['word'=>$words,'session_id'=>$session_id]);
            
                        
        }
                    
                    
        $modelData=$model->where(function ($query) use ($word) {
              $query->where('name', 'like', '%' . $word . '%');
         })->get();
        if(count($modelData)==0){
            return trans('there is not found any results');
        }
        return $modelData;
    }
}
