<?php

namespace Modules\Article\Http\Controllers\API\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Modules\Article\Entities\ArticleCategory;
use Modules\Article\Http\Requests\Categories\StoreArticleRequest;
use Modules\Article\Http\Requests\Categories\UpdateArticleRequest;
use Modules\Article\Http\Requests\Categories\DeleteArticleRequest;
use Modules\Article\Repositories\Admin\Categories\ArticleRepository;

class ArticleController extends Controller
{
       /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ArticleRepository
     */
    protected $articleRepo;
    /**
     * @var ArticleCategory
     */
    protected $articleCategory;
   

    /**
     * ArticleCategorysController constructor.
     *
     * @param ArticleCategoryRepository $articleCategorys
     */
    public function __construct(BaseRepository $baseRepo, ArticleCategory $articleCategory,ArticleRepository $articleCategoryRepo)
    {
        $this->middleware(['permission:articles-categories_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:articles-categories_trash'])->only('trash');
        $this->middleware(['permission:articles-categories_restore'])->only('restore');
        $this->middleware(['permission:articles-categories_restore-all'])->only('restore-all');
        $this->middleware(['permission:articles-categories_show'])->only('show');
        $this->middleware(['permission:articles-categories_store'])->only('store');
        $this->middleware(['permission:articles-categories_update'])->only('update');
        $this->middleware(['permission:articles-categories_destroy'])->only('destroy');
        $this->middleware(['permission:articles-categories_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->articleCategory = $articleCategory;
        $this->articleCategoryRepo = $articleCategoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
//          try{
        $articleCategorys=$this->articleCategoryRepo->all($this->articleCategory,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategorys],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request,$lang=null){
        
         try{
        $articleCategorys=$this->articleCategoryRepo->getAllPaginates($this->articleCategory,$request,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategorys],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $articleCategorys=$this->articleCategoryRepo->trash($this->articleCategory,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategorys],200);

        
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
    public function store(StoreArticleRequest $request)
    {
        // try{
       $articleCategory= $this->articleCategoryRepo->store($request,$this->articleCategory);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategory->load('image')],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }
  public function storeTrans(StoreArticleRequest $request,$id,$lang)
    {
        // try{
       $articleCategory= $this->articleCategoryRepo->store($request,$this->articleCategory,$id,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategory->load('image')],200);

        
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
        $articleCategory=$this->articleCategoryRepo->find($id,$this->articleCategory);
                          if(is_string($articleCategory)){
            return response()->json(['status'=>false,'message'=>$articleCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategory->load('image')],200);

        
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
    public function update(UpdateArticleRequest $request,$id)
    {
        //   try{
       $articleCategory= $this->articleCategoryRepo->update($request,$id,$this->articleCategory);
                                 if(is_string($articleCategory)){
            return response()->json(['status'=>false,'message'=>$articleCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategory->load('image')],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $articleCategory =  $this->articleCategoryRepo->restore($id,$this->articleCategory);
                                  if(is_string($articleCategory)){
            return response()->json(['status'=>false,'message'=>$articleCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategory->load('image')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $articleCategorys =  $this->articleCategoryRepo->restoreAll($this->articleCategory);
                                  if(is_string($articleCategorys)){
            return response()->json(['status'=>false,'message'=>$articleCategorys],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategorys],200);

        
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
    public function destroy(DeleteArticleRequest $request,$id)
    {
           try{
       $articleCategory= $this->articleCategoryRepo->destroy($id,$this->articleCategory);
                          if(is_string($articleCategory)){
            return response()->json(['status'=>false,'message'=>$articleCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$articleCategory],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteArticleRequest $request,$id)
    {
          try{
        //to make force destroy for a ArticleCategory must be this ArticleCategory  not found in ArticleCategorys table  , must be found in trash ArticleCategorys
        $articleCategory=$this->articleCategoryRepo->forceDelete($id,$this->articleCategory);
                          if(is_string($articleCategory)){
            return response()->json(['status'=>false,'message'=>$articleCategory],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    


}
