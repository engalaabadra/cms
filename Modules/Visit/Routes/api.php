<?php

use Illuminate\Support\Facades\Route;
use Modules\Visit\Http\Controllers\API\Admin\VisitController as VisitControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('visits')->group(function(){
        Route::get('/all/{lang?}', [VisitControllerAdmin::class,'index'])->name('api.admin.visits.index');    
        Route::get('/get-all-paginates/{lang?}', [VisitControllerAdmin::class,'getAllPaginates'])->name('api.admin.visits.get-all-visits-paginate');        
        Route::get('trash', [VisitControllerAdmin::class,'trash'])->name('api.admin.visits.trash');
        Route::get('restore-all', [VisitControllerAdmin::class,'restoreAll'])->name('api.admin.visits.restore-all');
        Route::get('restore/{id}', [VisitControllerAdmin::class,'restore'])->name('api.admin.visits.restore');
        Route::post('store', [VisitControllerAdmin::class,'store'])->name('api.admin.visits.store');
        Route::post('store-trans/{id}/{lang}', [VisitControllerAdmin::class,'storeTrans'])->name('api.admin.visits.store-trans/{id}/{lang}');
        Route::get('show/{id}', [VisitControllerAdmin::class,'show'])->name('api.admin.visits.show');
        Route::post('update/{id}', [VisitControllerAdmin::class,'update'])->name('api.admin.visits.update');
        Route::get('destroy/{id}', [VisitControllerAdmin::class,'destroy'])->name('api.admin.visits.destroy');        
        Route::get('force-delete/{id}', [VisitControllerAdmin::class,'forceDelete'])->name('api.admin.visits.force-delete');
  
    });

 });
