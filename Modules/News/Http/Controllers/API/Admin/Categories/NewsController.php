<?php

namespace Modules\News\Http\Controllers\API\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Modules\News\Entities\NewsCategory;
use Modules\News\Http\Requests\Categories\StoreNewsRequest;
use Modules\News\Http\Requests\Categories\UpdateNewsRequest;
use Modules\News\Http\Requests\Categories\DeleteNewsRequest;
use Modules\News\Repositories\Admin\Categories\NewsRepository;

class NewsController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var NewsRepository
     */
    protected $newsRepo;
    /**
     * @var NewsCategory
     */
    protected $newCategory;
   

    /**
     * NewsCategorysController constructor.
     *
     * @param NewsCategoryRepository $newCategorys
     */
    public function __construct(BaseRepository $baseRepo, NewsCategory $newCategory,NewsRepository $newCategoryRepo)
    {
        $this->middleware(['permission:news-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:news-categories_trash'])->only('trash');
        $this->middleware(['permission:news-categories_restore'])->only('restore');
        $this->middleware(['permission:news-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:news-categories_show'])->only('show');
        $this->middleware(['permission:news-categories_store'])->only('store');
        $this->middleware(['permission:news-categories_update'])->only('update');
        $this->middleware(['permission:news-categories_destroy'])->only('destroy');
        $this->middleware(['permission:news-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->newCategory = $newCategory;
        $this->newCategoryRepo = $newCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
//          try{
        $newCategorys=$this->newCategoryRepo->all($this->newCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategorys],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $newCategorys=$this->newCategoryRepo->getAllCategoriesPaginate($this->newCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategorys],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $newCategorys=$this->newCategoryRepo->trash($this->newCategory,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategorys],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        // try{
       $newCategory= $this->newCategoryRepo->store($request,$this->newCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategory],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
    
        public function storeTrans(StoreNewsRequest $request,$id,$lang)
    {
        // try{
       $newCategory= $this->newCategoryRepo->storeTrans($request,$this->newCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategory],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              try{
        $newCategory=$this->newCategoryRepo->find($id,$this->newCategory);
                          if(is_string($newCategory)){
            return response()->json(['status'=>false,'message'=>$newCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsRequest $request,$id)
    {
          try{
       $newCategory= $this->newCategoryRepo->update($request,$id,$this->newCategory);
                                 if(is_string($newCategory)){
            return response()->json(['status'=>false,'message'=>$newCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $newCategory =  $this->newCategoryRepo->restore($id,$this->newCategory);
                                  if(is_string($newCategory)){
            return response()->json(['status'=>false,'message'=>$newCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $newCategorys =  $this->newCategoryRepo->restoreAll($this->newCategory);
                                  if(is_string($newCategorys)){
            return response()->json(['status'=>false,'message'=>$newCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategorys],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
        
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteNewsRequest $request,$id)
    {
           try{
       $newCategory= $this->newCategoryRepo->destroy($id,$this->newCategory);
                          if(is_string($newCategory)){
            return response()->json(['status'=>false,'message'=>$newCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteNewsRequest $request,$id)
    {
          try{
        //to make force destroy for a NewsCategory must be this NewsCategory  not found in NewsCategorys table  , must be found in trash NewsCategorys
        $newCategory=$this->newCategoryRepo->forceDelete($id,$this->newCategory);
                          if(is_string($newCategory)){
            return response()->json(['status'=>false,'message'=>$newCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    


}
