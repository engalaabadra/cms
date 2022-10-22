<?php

use Illuminate\Support\Facades\Route;
use Modules\Activity\Http\Controllers\API\Admin\ActivityController as ActivityControllerAdmin;
use Modules\Activity\Http\Controllers\API\User\ActivityController as ActivityControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('activities')->group(function(){
        Route::get('/all/{lang?}', [ActivityControllerAdmin::class,'index'])->name('api.admin.activities.index');    
        Route::get('/get-all-paginates/{lang?}', [ActivityControllerAdmin::class,'getAllPaginates'])->name('api.admin.activities.get-all-activities-paginate');        
        Route::get('trash', [ActivityControllerAdmin::class,'trash'])->name('api.admin.activities.trash');
        Route::get('restore-all', [ActivityControllerAdmin::class,'restoreAll'])->name('api.admin.activities.restore-all');
        Route::get('restore/{id}', [ActivityControllerAdmin::class,'restore'])->name('api.admin.activities.restore');
        // Route::post('store', [ActivityControllerAdmin::class,'store'])->name('api.admin.activities.store');
        Route::get('show/{id}', [ActivityControllerAdmin::class,'show'])->name('api.admin.activities.show');
        // Route::post('update/{id}', [ActivityControllerAdmin::class,'update'])->name('api.admin.activities.update');
        Route::get('destroy/{id}', [ActivityControllerAdmin::class,'destroy'])->name('api.admin.activities.destroy');        
        Route::get('force-delete/{id}', [ActivityControllerAdmin::class,'forceDelete'])->name('api.admin.activities.force-delete');

    });

 });
