<?php

use Illuminate\Support\Facades\Route;
use Modules\Constant\Http\Controllers\API\Admin\ConstantController as ConstantControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('constants')->group(function(){
        Route::get('/all/{lang?}', [ConstantControllerAdmin::class,'index'])->name('api.admin.constants.index');    
        Route::get('/get-all-paginates/{lang?}', [ConstantControllerAdmin::class,'getAllPaginates'])->name('api.admin.constants.get-all-constants-paginate');        
        Route::get('trash', [ConstantControllerAdmin::class,'trash'])->name('api.admin.constants.trash');
        Route::get('restore-all', [ConstantControllerAdmin::class,'restoreAll'])->name('api.admin.constants.restore-all');
        Route::get('restore/{id}', [ConstantControllerAdmin::class,'restore'])->name('api.admin.constants.restore');
        Route::post('store', [ConstantControllerAdmin::class,'store'])->name('api.admin.constants.store');
        Route::post('store-trans/{id}/{lang}', [ConstantControllerAdmin::class,'storeTrans'])->name('api.admin.constants.store-trans');
        Route::get('show/{id}', [ConstantControllerAdmin::class,'show'])->name('api.admin.constants.show');
        Route::post('update/{id}', [ConstantControllerAdmin::class,'update'])->name('api.admin.constants.update');
        Route::get('destroy/{id}', [ConstantControllerAdmin::class,'destroy'])->name('api.admin.constants.destroy');        
        Route::get('force-delete/{id}', [ConstantControllerAdmin::class,'forceDelete'])->name('api.admin.constants.force-delete');

    });

 });
