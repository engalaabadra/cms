<?php

use Illuminate\Support\Facades\Route;
use Modules\Staff\Http\Controllers\API\Admin\StaffController as StaffControllerAdmin;
use Modules\Staff\Http\Controllers\API\Admin\Categories\StaffController as staffCategoriesControllerAdmin;
use Modules\Staff\Http\Controllers\API\User\StaffController as StaffControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('staffs')->group(function(){
        Route::get('/all/{lang?}', [StaffControllerAdmin::class,'index'])->name('api.admin.staffs.index');    
        Route::get('/get-all-paginates/{lang?}', [StaffControllerAdmin::class,'getAllPaginates'])->name('api.admin.staffs.get-all-staffs-paginate');        
        Route::get('trash', [StaffControllerAdmin::class,'trash'])->name('api.admin.staffs.trash');
        Route::get('restore-all', [StaffControllerAdmin::class,'restoreAll'])->name('api.admin.staffs.restore-all');
        Route::get('restore/{id}', [StaffControllerAdmin::class,'restore'])->name('api.admin.staffs.restore');
        Route::post('store', [StaffControllerAdmin::class,'store'])->name('api.admin.staffs.store');
        Route::post('store-trans/{id}/{lang}', [StaffControllerAdmin::class,'storeTrans'])->name('api.admin.staffs.store-trans');
        Route::get('show/{id}', [StaffControllerAdmin::class,'show'])->name('api.admin.staffs.show');
        Route::post('update/{id}', [StaffControllerAdmin::class,'update'])->name('api.admin.staffs.update');
        Route::get('destroy/{id}', [StaffControllerAdmin::class,'destroy'])->name('api.admin.staffs.destroy');        
        Route::get('force-delete/{id}', [StaffControllerAdmin::class,'forceDelete'])->name('api.admin.staffs.force-delete');
       
       
        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [StaffCategoriesControllerAdmin::class,'index'])->name('api.admin.staffs-categories.index');    
            Route::get('/get-all-paginates', [StaffCategoriesControllerAdmin::class,'getAllPaginates'])->name('api.admin.staffs-categories.get-all-staffs-categories-paginate');        
            Route::get('trash', [StaffCategoriesControllerAdmin::class,'trash'])->name('api.admin.staffs-categories.trash');
            Route::get('restore-all', [StaffCategoriesControllerAdmin::class,'restoreAll'])->name('api.admin.staffs-categories.restore-all');
            Route::get('restore/{id}', [StaffCategoriesControllerAdmin::class,'restore'])->name('api.admin.staffs-categories.restore');
            Route::post('store', [StaffCategoriesControllerAdmin::class,'store'])->name('api.admin.staffs-categories.store');
            Route::post('store-trans/{id}/{lang}', [StaffCategoriesControllerAdmin::class,'storeTrans'])->name('api.admin.staffs-categories.store-trans');
            Route::get('show/{id}', [StaffCategoriesControllerAdmin::class,'show'])->name('api.admin.staffs-categories.show');
            Route::post('update/{id}', [StaffCategoriesControllerAdmin::class,'update'])->name('api.admin.staffs-categories.update');
            Route::get('destroy/{id}', [StaffCategoriesControllerAdmin::class,'destroy'])->name('api.admin.staffs-categories.destroy');        
            Route::get('force-delete/{id}', [StaffCategoriesControllerAdmin::class,'forceDelete'])->name('api.admin.staffs-categories.force-delete');
        });
    });

 });
    Route::prefix('staffs')->group(function(){
        Route::get('/all/{lang?}', [StaffControllerUser::class,'index'])->name('api.staffs.index');   
    });