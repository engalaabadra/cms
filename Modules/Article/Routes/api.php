<?php

use Illuminate\Support\Facades\Route;
use Modules\Article\Http\Controllers\API\Admin\ArticleController as ArticleControllerAdmin;
use Modules\Article\Http\Controllers\API\Admin\Categories\ArticleController as ArticleCategoryControllerAdmin;
use Modules\Article\Http\Controllers\API\Admin\Similars\ArticleController as ArticleSimilarControllerAdmin;
use Modules\Article\Http\Controllers\API\User\ArticleController as ArticleControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){
    // Route::prefix('admin')->group(function(){

    Route::prefix('articles')->group(function(){
        Route::get('/all/{lang?}', [ArticleControllerAdmin::class,'index'])->name('api.admin.articles.index');    
        Route::get('/get-all-paginates/{lang?}', [ArticleControllerAdmin::class,'getAllPaginates'])->name('api.admin.articles.get-all-articles-paginate');        
        Route::get('trash', [ArticleControllerAdmin::class,'trash'])->name('api.admin.articles.trash');
        Route::get('restore-all', [ArticleControllerAdmin::class,'restoreAll'])->name('api.admin.articles.restore-all');
        Route::get('restore/{id}', [ArticleControllerAdmin::class,'restore'])->name('api.admin.articles.restore');
        Route::post('store', [ArticleControllerAdmin::class,'store'])->name('api.admin.articles.store');
        Route::post('store-trans/{id}/{lang}', [ArticleControllerAdmin::class,'storeTrans'])->name('api.admin.articles.store-trans');
        Route::get('show/{id}', [ArticleControllerAdmin::class,'show'])->name('api.admin.articles.show');
        Route::post('update/{id}', [ArticleControllerAdmin::class,'update'])->name('api.admin.articles.update');
        Route::get('destroy/{id}', [ArticleControllerAdmin::class,'destroy'])->name('api.admin.articles.destroy');        
        Route::get('force-delete/{id}', [ArticleControllerAdmin::class,'forceDelete'])->name('api.admin.articles.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [ArticleCategoryControllerAdmin::class,'index'])->name('api.admin.articles-categories.index');    
            Route::get('/get-all-paginates/{lang?}', [ArticleCategoryControllerAdmin::class,'getAllPaginates'])->name('api.admin.articles-categories.get-all-articles-categories-paginate');        
            Route::get('trash', [ArticleCategoryControllerAdmin::class,'trash'])->name('api.admin.articles-categories.trash');
            Route::get('restore-all', [ArticleCategoryControllerAdmin::class,'restoreAll'])->name('api.admin.articles-categories.restore-all');
            Route::get('restore/{id}', [ArticleCategoryControllerAdmin::class,'restore'])->name('api.admin.articles-categories.restore');
            Route::post('store', [ArticleCategoryControllerAdmin::class,'store'])->name('api.admin.articles-categories.store');
            Route::post('store-trans/{id}/{lang}', [ArticleCategoryControllerAdmin::class,'storeTrans'])->name('api.admin.articles-categories.store-trans');
            Route::get('show/{id}', [ArticleCategoryControllerAdmin::class,'show'])->name('api.admin.articles-categories.show');
            Route::post('update/{id}', [ArticleCategoryControllerAdmin::class,'update'])->name('api.admin.articles-categories.update');
            Route::get('destroy/{id}', [ArticleCategoryControllerAdmin::class,'destroy'])->name('api.admin.articles-categories.destroy');        
            Route::get('force-delete/{id}', [ArticleCategoryControllerAdmin::class,'forceDelete'])->name('api.admin.articles-categories.force-delete');
        });
        
        
        Route::prefix('similars')->group(function(){
                    Route::get('article-similars-paginates/{id}', [ArticleSimilarControllerAdmin::class,'articleSimilarsPaginates'])->name('api.admin.article-similars.article-similars');

            Route::get('trash', [ArticleSimilarControllerAdmin::class,'trash'])->name('api.admin.articles-similars.trash');
            Route::get('restore-all', [ArticleSimilarControllerAdmin::class,'restoreAll'])->name('api.admin.articles-similars.restore-all');
            Route::get('restore/{id}', [ArticleSimilarControllerAdmin::class,'restore'])->name('api.admin.articles-similars.restore');
            Route::post('store/{articleId}', [ArticleSimilarControllerAdmin::class,'store'])->name('api.admin.articles-similars.store');
            Route::get('destroy/{articleId}/{similarId}', [ArticleSimilarControllerAdmin::class,'destroy'])->name('api.admin.articles-similars.destroy');        
        });

    });

 });
     Route::prefix('articles')->group(function(){

         Route::get('/all/{lang?}', [ArticleControllerUser::class,'index'])->name('api.user.articles.get-all-data');        
        Route::get('show/{id}', [ArticleControllerUser::class,'show'])->name('api.user.articles.show');
                Route::prefix('similars')->group(function(){
                    Route::get('article-similars-paginates/{id}', [ArticleSimilarControllerUser::class,'articleSimilarsPaginates'])->name('api.admin.article-similars.article-similars');

});

});
