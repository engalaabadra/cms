<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\API\Admin\NewsController as NewsControllerAdmin;
use Modules\News\Http\Controllers\API\Admin\Categories\NewsController as NewsCategoryControllerAdmin;

    use Modules\News\Http\Controllers\API\Admin\NewsController as NewsControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){
    // Route::prefix('admin')->group(function(){

    Route::prefix('news')->group(function(){
        Route::get('/all/{lang?}', [NewsControllerAdmin::class,'index'])->name('api.admin.news.index');    
        Route::get('/get-all-paginates/{lang?}', [NewsControllerAdmin::class,'getAllPaginates'])->name('api.admin.news.get-all-news-paginate');        
        Route::get('trash', [NewsControllerAdmin::class,'trash'])->name('api.admin.news.trash');
        Route::get('restore-all', [NewsControllerAdmin::class,'restoreAll'])->name('api.admin.news.restore-all');
        Route::get('restore/{id}', [NewsControllerAdmin::class,'restore'])->name('api.admin.news.restore');
        Route::post('store', [NewsControllerAdmin::class,'store'])->name('api.admin.news.store');
        Route::post('store-trans/{id}/{lang}', [NewsControllerAdmin::class,'storeTrans'])->name('api.admin.news.store-trans');
        Route::get('show/{id}', [NewsControllerAdmin::class,'show'])->name('api.admin.news.show');
        Route::post('update/{id}', [NewsControllerAdmin::class,'update'])->name('api.admin.news.update');
        Route::get('destroy/{id}', [NewsControllerAdmin::class,'destroy'])->name('api.admin.news.destroy');        
        Route::get('force-delete/{id}', [NewsControllerAdmin::class,'forceDelete'])->name('api.admin.news.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [NewsCategoryControllerAdmin::class,'index'])->name('api.admin.news-categories.index');    
            Route::get('/get-all-paginates/{lang?}', [NewsCategoryControllerAdmin::class,'getAllPaginates'])->name('api.admin.news-categories.get-all-news-categories-paginate');        
            Route::get('trash', [NewsCategoryControllerAdmin::class,'trash'])->name('api.admin.news-categories.trash');
            Route::get('restore-all', [NewsCategoryControllerAdmin::class,'restoreAll'])->name('api.admin.news-categories.restore-all');
            Route::get('restore/{id}', [NewsCategoryControllerAdmin::class,'restore'])->name('api.admin.news-categories.restore');
            Route::post('store', [NewsCategoryControllerAdmin::class,'store'])->name('api.admin.news-categories.store');
            Route::post('store-trans/{id}/{lang}', [NewsCategoryControllerAdmin::class,'storeTrans'])->name('api.admin.news-categories.store-trans');
            Route::get('show/{id}', [NewsCategoryControllerAdmin::class,'show'])->name('api.admin.news-categories.show');
            Route::post('update/{id}', [NewsCategoryControllerAdmin::class,'update'])->name('api.admin.news-categories.update');
            Route::get('destroy/{id}', [NewsCategoryControllerAdmin::class,'destroy'])->name('api.admin.news-categories.destroy');        
            Route::get('force-delete/{id}', [NewsCategoryControllerAdmin::class,'forceDelete'])->name('api.admin.news-categories.force-delete');
        });
    });

 });
     Route::prefix('news')->group(function(){

         Route::get('/get-all-paginates', [NewsControllerUser::class,'getAllPaginates'])->name('api.user.news.get-all-news-paginate');        
        Route::get('show/{id}', [NewsControllerUser::class,'show'])->name('api.user.news.show');

         
     });
