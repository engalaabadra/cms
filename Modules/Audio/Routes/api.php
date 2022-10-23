<?php

use Illuminate\Support\Facades\Route;
use Modules\Audio\Http\Controllers\API\Admin\AudioController as AudioControllerAdmin;
use Modules\Audio\Http\Controllers\API\Admin\Categories\AudioController as AudioCategoryControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('audios')->group(function(){
        Route::get('/{lang?}', [AudioControllerAdmin::class,'index'])->name('api.admin.audios.index');    
        Route::get('/get-all-paginates', [AudioControllerAdmin::class,'getAllPaginates'])->name('api.admin.audios.get-all-audios-paginate');        
        Route::get('trash', [AudioControllerAdmin::class,'trash'])->name('api.admin.audios.trash');
        Route::get('restore-all', [AudioControllerAdmin::class,'restoreAll'])->name('api.admin.audios.restore-all');
        Route::get('restore/{id}', [AudioControllerAdmin::class,'restore'])->name('api.admin.audios.restore');
        Route::post('store', [AudioControllerAdmin::class,'store'])->name('api.admin.audios.store');
        Route::post('store-trans/{id}/{lang}', [AudioControllerAdmin::class,'storeTrans'])->name('api.admin.audios.store-trans');
        Route::get('show/{id}', [AudioControllerAdmin::class,'show'])->name('api.admin.audios.show');
        Route::post('update/{id}', [AudioControllerAdmin::class,'update'])->name('api.admin.audios.update');
        Route::get('destroy/{id}', [AudioControllerAdmin::class,'destroy'])->name('api.admin.audios.destroy');        
        Route::get('force-delete/{id}', [AudioControllerAdmin::class,'forceDelete'])->name('api.admin.audios.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/{lang?}', [AudioCategoryControllerAdmin::class,'index'])->name('api.admin.audios-categories.index');    
            Route::get('/get-all-paginates', [AudioCategoryControllerAdmin::class,'getAllPaginates'])->name('api.admin.audios-categories.get-all-audios-categories-paginate');        
            Route::get('trash', [AudioCategoryControllerAdmin::class,'trash'])->name('api.admin.audios-categories.trash');
            Route::get('restore-all', [AudioCategoryControllerAdmin::class,'restoreAll'])->name('api.admin.audios-categories.restore-all');
            Route::get('restore/{id}', [AudioCategoryControllerAdmin::class,'restore'])->name('api.admin.audios-categories.restore');
            Route::post('store', [AudioCategoryControllerAdmin::class,'store'])->name('api.admin.audios-categories.store');
            Route::post('store-trans/{id}/{lang}', [AudioCategoryControllerAdmin::class,'storeTrans'])->name('api.admin.audios-categories.store-trans');
            Route::get('show/{id}', [AudioCategoryControllerAdmin::class,'show'])->name('api.admin.audios-categories.show');
            Route::post('update/{id}', [AudioCategoryControllerAdmin::class,'update'])->name('api.admin.audios-categories.update');
            Route::get('destroy/{id}', [AudioCategoryControllerAdmin::class,'destroy'])->name('api.admin.audios-categories.destroy');        
            Route::get('force-delete/{id}', [AudioCategoryControllerAdmin::class,'forceDelete'])->name('api.admin.audios-categories.force-delete');
        });
    });

 });
