<?php

use Illuminate\Support\Facades\Route;
use Modules\Add\Http\Controllers\API\Admin\AddController as AddControllerAdmin;
use Modules\Add\Http\Controllers\API\User\AddController as AddControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('adds')->group(function(){
        // Route::get('/all/{lang?}', [AddControllerAdmin::class,'index'])->name('api.admin.adds.index');    
        // Route::get('/get-all-paginates/{lang?}', [AddControllerAdmin::class,'getAllPaginates'])->name('api.admin.adds.get-all-adds-paginate');        
        Route::get('/paginates/{lang}', [AddControllerAdmin::class,'paginates'])->name('api.admin.adds.adds-paginate');        
        Route::get('trash', [AddControllerAdmin::class,'trash'])->name('api.admin.adds.trash');
        Route::get('restore-all', [AddControllerAdmin::class,'restoreAll'])->name('api.admin.adds.restore-all');
        Route::get('restore/{id}', [AddControllerAdmin::class,'restore'])->name('api.admin.adds.restore');
        Route::post('store', [AddControllerAdmin::class,'store'])->name('api.admin.adds.store');
        Route::post('store-trans/{id}/{lang}', [AddControllerAdmin::class,'storeTrans'])->name('api.admin.adds.store-trans');
        Route::get('show/{id}', [AddControllerAdmin::class,'show'])->name('api.admin.adds.show');
        Route::post('update/{id}', [AddControllerAdmin::class,'update'])->name('api.admin.adds.update');
        Route::get('destroy/{id}', [AddControllerAdmin::class,'destroy'])->name('api.admin.adds.destroy');        
        Route::get('force-delete/{id}', [AddControllerAdmin::class,'forceDelete'])->name('api.admin.adds.force-delete');
       
       
    });

 });
 /**************************Routes User***************************** */
    Route::prefix('adds')->group(function(){
               Route::get('/all/{lang?}', [AddControllerUser::class,'index'])->name('api.user.adds.get-all-data');        
 
    });
