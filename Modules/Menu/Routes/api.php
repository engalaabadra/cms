<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\API\Admin\MenuController as MenuControllerAdmin;
use Modules\Menu\Http\Controllers\API\User\MenuController as MenuControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('menus')->group(function(){
        Route::get('/all/{lang?}', [MenuControllerAdmin::class,'index'])->name('api.admin.menus.index');    
        Route::get('/get-all-paginates/{lang?}', [MenuControllerAdmin::class,'getAllPaginates'])->name('api.admin.menus.get-all-menus-paginate');        
        Route::get('/get-main-menus', [MenuControllerAdmin::class,'getMainMenus'])->name('api.admin.menus.get-main-menus');        
                Route::get('/get-sub-menus-for-main/{id}', [MenuControllerAdmin::class,'getSubMenusForMain'])->name('api.admin.categories.get-sub-menus-for-main');        

        Route::get('trash', [MenuControllerAdmin::class,'trash'])->name('api.admin.menus.trash');
        Route::get('restore-all', [MenuControllerAdmin::class,'restoreAll'])->name('api.admin.menus.restore-all');
        Route::get('restore/{id}', [MenuControllerAdmin::class,'restore'])->name('api.admin.menus.restore');
        Route::post('store', [MenuControllerAdmin::class,'store'])->name('api.admin.menus.store');
        Route::post('store-trans/{id}/{lang}', [MenuControllerAdmin::class,'storeTrans'])->name('api.admin.menus.store-trans');
        Route::get('show/{id}', [MenuControllerAdmin::class,'show'])->name('api.admin.menus.show');
        Route::post('update/{id}', [MenuControllerAdmin::class,'update'])->name('api.admin.menus.update');
        Route::get('destroy/{id}', [MenuControllerAdmin::class,'destroy'])->name('api.admin.menus.destroy');        
        Route::get('force-delete/{id}', [MenuControllerAdmin::class,'forceDelete'])->name('api.admin.menus.force-delete');

    });

 });
/**************************Routes User***************************** */

    Route::prefix('menus')->group(function(){
           Route::get('/get-main-menus/{lang?}', [MenuControllerUser::class,'getMainMenus'])->name('api.menus.get-main-menus');        
        Route::get('/all/{lang?}', [MenuControllerUser::class,'index'])->name('api.menus.index');   
                Route::get('/get-sub-menus-for-main/{id}/{lang?}', [MenuControllerUser::class,'getSubMenusForMain'])->name('api.categories.get-sub-menus-for-main');        

    });