<?php

use Illuminate\Support\Facades\Route;
use Modules\Template\Http\Controllers\API\Admin\TemplateController as TemplateControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('templates')->group(function(){
        Route::get('/all/{lang?}', [TemplateControllerAdmin::class,'index'])->name('api.admin.templates.index');    
        Route::get('/get-all-paginates/{lang?}', [TemplateControllerAdmin::class,'getAllPaginates'])->name('api.admin.templates.get-all-templates-paginate');        
        Route::get('trash', [TemplateControllerAdmin::class,'trash'])->name('api.admin.templates.trash');
        Route::get('restore-all', [TemplateControllerAdmin::class,'restoreAll'])->name('api.admin.templates.restore-all');
        Route::get('restore/{id}', [TemplateControllerAdmin::class,'restore'])->name('api.admin.templates.restore');
        Route::post('store', [TemplateControllerAdmin::class,'store'])->name('api.admin.templates.store');
        Route::post('store-trans/{id}/{lang}', [TemplateControllerAdmin::class,'storeTrans'])->name('api.admin.templates.store-trans');
        Route::get('show/{id}', [TemplateControllerAdmin::class,'show'])->name('api.admin.templates.show');
        Route::post('update/{id}', [TemplateControllerAdmin::class,'update'])->name('api.admin.templates.update');
        Route::get('destroy/{id}', [TemplateControllerAdmin::class,'destroy'])->name('api.admin.templates.destroy');        
        Route::get('force-delete/{id}', [TemplateControllerAdmin::class,'forceDelete'])->name('api.admin.templates.force-delete');

    });

 });
