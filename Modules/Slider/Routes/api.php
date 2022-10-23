<?php

use Illuminate\Support\Facades\Route;
use Modules\Slider\Http\Controllers\API\Admin\SliderController as SliderControllerAdmin;
use Modules\Slider\Http\Controllers\API\User\SliderController as SliderControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('sliders')->group(function(){
        Route::get('/all/{lang?}', [SliderControllerAdmin::class,'index'])->name('api.admin.sliders.index');    
        Route::get('/get-all-paginates/{lang?}', [SliderControllerAdmin::class,'getAllPaginates'])->name('api.admin.sliders.get-all-sliders-paginate');        
        Route::get('trash', [SliderControllerAdmin::class,'trash'])->name('api.admin.sliders.trash');
        Route::get('restore-all', [SliderControllerAdmin::class,'restoreAll'])->name('api.admin.sliders.restore-all');
        Route::get('restore/{id}', [SliderControllerAdmin::class,'restore'])->name('api.admin.sliders.restore');
        Route::post('store', [SliderControllerAdmin::class,'store'])->name('api.admin.sliders.store');
        Route::post('store-trans/{id}/{lang}', [SliderControllerAdmin::class,'storeTrans'])->name('api.admin.sliders.store-trans');
        Route::get('show/{id}', [SliderControllerAdmin::class,'show'])->name('api.admin.sliders.show');
        Route::post('update/{id}', [SliderControllerAdmin::class,'update'])->name('api.admin.sliders.update');
        Route::get('destroy/{id}', [SliderControllerAdmin::class,'destroy'])->name('api.admin.sliders.destroy');        
        Route::get('force-delete/{id}', [SliderControllerAdmin::class,'forceDelete'])->name('api.admin.sliders.force-delete');

    });

 });
    /**************************Routes User***************************** */

    Route::prefix('sliders')->group(function(){
        Route::get('/all/{lang?}', [SliderControllerUser::class,'index'])->name('api.sliders.index');    
    });
