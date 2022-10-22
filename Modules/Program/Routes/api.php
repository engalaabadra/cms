<?php

use Illuminate\Support\Facades\Route;
use Modules\Program\Http\Controllers\API\Admin\ProgramController as ProgramControllerAdmin;
use Modules\Program\Http\Controllers\API\Admin\Categories\ProgramController as ProgramCategoriesControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('programs')->group(function(){
        Route::get('/all/{lang?}', [ProgramControllerAdmin::class,'index'])->name('api.admin.programs.index');    
        Route::get('/get-all-paginates/{lang?}', [ProgramControllerAdmin::class,'getAllPaginates'])->name('api.admin.programs.get-all-programs-paginate');        
        Route::get('trash', [ProgramControllerAdmin::class,'trash'])->name('api.admin.programs.trash');
        Route::get('restore-all', [ProgramControllerAdmin::class,'restoreAll'])->name('api.admin.programs.restore-all');
        Route::get('restore/{id}', [ProgramControllerAdmin::class,'restore'])->name('api.admin.programs.restore');
        Route::post('store', [ProgramControllerAdmin::class,'store'])->name('api.admin.programs.store');
        Route::post('store-trans/{id}/{lang}', [ProgramControllerAdmin::class,'storeTrans'])->name('api.admin.programs.store-trans');
         Route::get('show/{id}', [ProgramControllerAdmin::class,'show'])->name('api.admin.programs.show');
        Route::post('update/{id}', [ProgramControllerAdmin::class,'update'])->name('api.admin.programs.update');
        Route::get('destroy/{id}', [ProgramControllerAdmin::class,'destroy'])->name('api.admin.programs.destroy');        
        Route::get('force-delete/{id}', [ProgramControllerAdmin::class,'forceDelete'])->name('api.admin.programs.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [ProgramCategoriesControllerAdmin::class,'index'])->name('api.admin.programs-categories.index');    
            Route::get('/get-all-paginates/{lang?}', [ProgramCategoriesControllerAdmin::class,'getAllPaginates'])->name('api.admin.programs-categories.get-all-programs-categories-paginate');        
            Route::get('trash', [ProgramCategoriesControllerAdmin::class,'trash'])->name('api.admin.programs-categories.trash');
            Route::get('restore-all', [ProgramCategoriesControllerAdmin::class,'restoreAll'])->name('api.admin.programs-categories.restore-all');
            Route::get('restore/{id}', [ProgramCategoriesControllerAdmin::class,'restore'])->name('api.admin.programs-categories.restore');
            Route::post('store', [ProgramCategoriesControllerAdmin::class,'store'])->name('api.admin.programs-categories.store');
            Route::post('store-trans/{id}/{lang}', [ProgramCategoriesControllerAdmin::class,'storeTrans'])->name('api.admin.programs-categories.store-trans');
            Route::get('show/{id}', [ProgramCategoriesControllerAdmin::class,'show'])->name('api.admin.programs-categories.show');
            Route::post('update/{id}', [ProgramCategoriesControllerAdmin::class,'update'])->name('api.admin.programs-categories.update');
            Route::get('destroy/{id}', [ProgramCategoriesControllerAdmin::class,'destroy'])->name('api.admin.programs-categories.destroy');        
            Route::get('force-delete/{id}', [ProgramCategoriesControllerAdmin::class,'forceDelete'])->name('api.admin.programs-categories.force-delete');
        });
    });

 });
