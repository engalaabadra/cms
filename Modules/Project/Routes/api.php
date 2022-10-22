<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\API\Admin\ProjectController as ProjectControllerAdmin;
use Modules\Project\Http\Controllers\API\Admin\Categories\ProjectController as ProjectCategoriesControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('projects')->group(function(){
        Route::get('/all/{lang?}', [ProjectControllerAdmin::class,'index'])->name('api.admin.projects.index');    
        Route::get('/get-all-paginates/{lang?}', [ProjectControllerAdmin::class,'getAllPaginates'])->name('api.admin.projects.get-all-projects-paginate');        
        Route::get('trash', [ProjectControllerAdmin::class,'trash'])->name('api.admin.projects.trash');
        Route::get('restore-all', [ProjectControllerAdmin::class,'restoreAll'])->name('api.admin.projects.restore-all');
        Route::get('restore/{id}', [ProjectControllerAdmin::class,'restore'])->name('api.admin.projects.restore');
        Route::post('store', [ProjectControllerAdmin::class,'store'])->name('api.admin.projects.store');
        Route::post('store-trans/{id}/{lang}', [ProjectControllerAdmin::class,'storeTrans'])->name('api.admin.projects.store-trans');
        Route::get('show/{id}', [ProjectControllerAdmin::class,'show'])->name('api.admin.projects.show');
        Route::post('update/{id}', [ProjectControllerAdmin::class,'update'])->name('api.admin.projects.update');
        Route::get('destroy/{id}', [ProjectControllerAdmin::class,'destroy'])->name('api.admin.projects.destroy');        
        Route::get('force-delete/{id}', [ProjectControllerAdmin::class,'forceDelete'])->name('api.admin.projects.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [ProjectCategoriesControllerAdmin::class,'index'])->name('api.admin.projects-categories.index');    
            Route::get('/get-all-paginates/{lang?}',[ProjectCategoriesControllerAdmin::class,'getAllPaginates'])->name('api.admin.projects-categories.get-all-projects-categories-paginate');        
            Route::get('trash', [ProjectCategoriesControllerAdmin::class,'trash'])->name('api.admin.projects-categories.trash');
            Route::get('restore-all', [ProjectCategoriesControllerAdmin::class,'restoreAll'])->name('api.admin.projects-categories.restore-all');
            Route::get('restore/{id}', [ProjectCategoriesControllerAdmin::class,'restore'])->name('api.admin.projects-categories.restore');
            Route::post('store', [ProjectCategoriesControllerAdmin::class,'store'])->name('api.admin.projects-categories.store');
            Route::post('store-trans/{id}/{lang}', [ProjectCategoriesControllerAdmin::class,'storeTrans'])->name('api.admin.projects-categories.store-trans');
            Route::get('show/{id}', [ProjectCategoriesControllerAdmin::class,'show'])->name('api.admin.projects-categories.show');
            Route::post('update/{id}', [ProjectCategoriesControllerAdmin::class,'update'])->name('api.admin.projects-categories.update');
            Route::get('destroy/{id}', [ProjectCategoriesControllerAdmin::class,'destroy'])->name('api.admin.projects-categories.destroy');        
            Route::get('force-delete/{id}', [ProjectCategoriesControllerAdmin::class,'forceDelete'])->name('api.admin.projects-categories.force-delete');
        });
    });

 });
