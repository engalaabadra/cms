<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\API\Admin\ReportController as ReportControllerAdmin;
use Modules\Report\Http\Controllers\API\Admin\Categories\ReportController as ReportCategoriesControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('reports')->group(function(){
        Route::get('/all/{lang?}', [ReportControllerAdmin::class,'index'])->name('api.admin.reports.index');    
        Route::get('/get-all-paginates/{lang?}', [ReportControllerAdmin::class,'getAllPaginates'])->name('api.admin.reports.get-all-reports-paginate');        
        Route::get('trash', [ReportControllerAdmin::class,'trash'])->name('api.admin.reports.trash');
        Route::get('restore-all', [ReportControllerAdmin::class,'restoreAll'])->name('api.admin.reports.restore-all');
        Route::get('restore/{id}', [ReportControllerAdmin::class,'restore'])->name('api.admin.reports.restore');
        Route::post('store', [ReportControllerAdmin::class,'store'])->name('api.admin.reports.store');
        Route::post('store-trans/{id}/{lang}', [ReportControllerAdmin::class,'storeTrans'])->name('api.admin.reports.store-tans');
        Route::get('show/{id}', [ReportControllerAdmin::class,'show'])->name('api.admin.reports.show');
        Route::post('update/{id}', [ReportControllerAdmin::class,'update'])->name('api.admin.reports.update');
        Route::get('destroy/{id}', [ReportControllerAdmin::class,'destroy'])->name('api.admin.reports.destroy');        
        Route::get('force-delete/{id}', [ReportControllerAdmin::class,'forceDelete'])->name('api.admin.reports.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [ReportCategoriesControllerAdmin::class,'index'])->name('api.admin.reports-categories.index');    
            Route::get('/get-all-paginates', [ReportCategoriesControllerAdmin::class,'getAllPaginates'])->name('api.admin.reports-categories.get-all-reports-categories-paginate');        
            Route::get('trash', [ReportCategoriesControllerAdmin::class,'trash'])->name('api.admin.reports-categories.trash');
            Route::get('restore-all', [ReportCategoriesControllerAdmin::class,'restoreAll'])->name('api.admin.reports-categories.restore-all');
            Route::get('restore/{id}', [ReportCategoriesControllerAdmin::class,'restore'])->name('api.admin.reports-categories.restore');
            Route::post('store', [ReportCategoriesControllerAdmin::class,'store'])->name('api.admin.reports-categories.store');
            Route::post('store-trans/{id}/{lang}', [ReportCategoriesControllerAdmin::class,'storeTrans'])->name('api.admin.reports-categories.store-trans');
            Route::get('show/{id}', [ReportCategoriesControllerAdmin::class,'show'])->name('api.admin.reports-categories.show');
            Route::post('update/{id}', [ReportCategoriesControllerAdmin::class,'update'])->name('api.admin.reports-categories.update');
            Route::get('destroy/{id}', [ReportCategoriesControllerAdmin::class,'destroy'])->name('api.admin.reports-categories.destroy');        
            Route::get('force-delete/{id}', [ReportCategoriesControllerAdmin::class,'forceDelete'])->name('api.admin.reports-categories.force-delete');
        });
    });

 });
