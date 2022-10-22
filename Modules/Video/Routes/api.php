<?php

use Illuminate\Support\Facades\Route;
use Modules\Video\Http\Controllers\API\Admin\VideoController as VideoControllerAdmin;
use Modules\Video\Http\Controllers\API\User\VideoController as VideoControllerUser;
use Modules\Video\Http\Controllers\API\Admin\Categories\VideoController as VideoCategoriesControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('videos')->group(function(){
        Route::get('/all/{lang?}', [VideoControllerAdmin::class,'index'])->name('api.admin.videos.index');    
        Route::get('/get-all-paginates/{lang?}', [VideoControllerAdmin::class,'getAllPaginates'])->name('api.admin.videos.get-all-videos-paginate');        
        Route::get('trash', [VideoControllerAdmin::class,'trash'])->name('api.admin.videos.trash');
        Route::get('restore-all', [VideoControllerAdmin::class,'restoreAll'])->name('api.admin.videos.restore-all');
        Route::get('restore/{id}', [VideoControllerAdmin::class,'restore'])->name('api.admin.videos.restore');
        Route::post('store', [VideoControllerAdmin::class,'store'])->name('api.admin.videos.store');
        Route::post('store-trans/{id}/{lang}', [VideoControllerAdmin::class,'storeTrans'])->name('api.admin.videos.store-trans/{id}/{lang}');
        Route::get('show/{id}', [VideoControllerAdmin::class,'show'])->name('api.admin.videos.show');
        Route::post('update/{id}', [VideoControllerAdmin::class,'update'])->name('api.admin.videos.update');
        Route::get('destroy/{id}', [VideoControllerAdmin::class,'destroy'])->name('api.admin.videos.destroy');        
        Route::get('force-delete/{id}', [VideoControllerAdmin::class,'forceDelete'])->name('api.admin.videos.force-delete');
  
            Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [VideoCategoriesControllerAdmin::class,'index'])->name('api.admin.video-categories.index');    
            Route::get('/get-all-paginates', [VideoCategoriesControllerAdmin::class,'getAllPaginates'])->name('api.admin.video-categories.get-all-video-categories-paginate');        
            Route::get('trash', [VideoCategoriesControllerAdmin::class,'trash'])->name('api.admin.video-categories.trash');
            Route::get('restore-all', [VideoCategoriesControllerAdmin::class,'restoreAll'])->name('api.admin.video-categories.restore-all');
            Route::get('restore/{id}', [VideoCategoriesControllerAdmin::class,'restore'])->name('api.admin.video-categories.restore');
            Route::post('store', [VideoCategoriesControllerAdmin::class,'store'])->name('api.admin.video-categories.store');
            Route::post('store-trans/{id}/{lang}', [VideoCategoriesControllerAdmin::class,'storeTrans'])->name('api.admin.video-categories.store-trans/{id}/{lang}');
            Route::get('show/{id}', [VideoCategoriesControllerAdmin::class,'show'])->name('api.admin.video-categories.show');
            Route::post('update/{id}', [VideoCategoriesControllerAdmin::class,'update'])->name('api.admin.video-categories.update');
            Route::get('destroy/{id}', [VideoCategoriesControllerAdmin::class,'destroy'])->name('api.admin.video-categories.destroy');        
            Route::get('force-delete/{id}', [VideoCategoriesControllerAdmin::class,'forceDelete'])->name('api.admin.video-categories.force-delete');
      
        });
    });


 });


    Route::prefix('videos')->namespace('API')->group(function(){
        Route::get('/all/{lang?}', [VideoControllerUser::class,'index'])->name('api.videos.index');  
    });