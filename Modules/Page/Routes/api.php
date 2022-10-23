<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\API\Admin\PageController as PageControllerAdmin;
use Modules\Page\Http\Controllers\API\User\PageController as PageControllerUser;
use Modules\Page\Http\Controllers\API\Admin\Banners\PageController as PageBannerControllerAdmin;
use Modules\Page\Http\Controllers\API\User\Banners\PageController as PageBannerControllerUser;
use Modules\Page\Http\Controllers\API\Admin\Accordions\PageController as PageAccordionControllerAdmin;


/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('pages')->group(function(){
        Route::get('/all/{lang?}', [PageControllerAdmin::class,'index'])->name('api.admin.pages.index');    
        Route::get('/get-all-paginates/{lang?}', [PageControllerAdmin::class,'getAllPaginates'])->name('api.admin.pages.get-all-pages-paginate');        
        Route::get('trash', [PageControllerAdmin::class,'trash'])->name('api.admin.pages.trash');
        Route::get('restore-all', [PageControllerAdmin::class,'restoreAll'])->name('api.admin.pages.restore-all');
        Route::get('restore/{id}', [PageControllerAdmin::class,'restore'])->name('api.admin.pages.restore');
        Route::post('store', [PageControllerAdmin::class,'store'])->name('api.admin.pages.store');
        Route::post('store-trans/{id}/{lang}', [PageControllerAdmin::class,'storeTrans'])->name('api.admin.pages.stor-transe');
        Route::get('show/{id}', [PageControllerAdmin::class,'show'])->name('api.admin.pages.show');
        Route::post('update/{id}', [PageControllerAdmin::class,'update'])->name('api.admin.pages.update');
        Route::get('destroy/{id}', [PageControllerAdmin::class,'destroy'])->name('api.admin.pages.destroy');        
        Route::get('force-delete/{id}', [PageControllerAdmin::class,'forceDelete'])->name('api.admin.pages.force-delete');
       
       
        Route::prefix('banners')->group(function(){
            Route::get('/all/{lang?}', [PageBannerControllerAdmin::class,'index'])->name('api.admin.pages-banners.index');    
            Route::get('/get-all-paginates/{lang?}', [PageBannerControllerAdmin::class,'getAllPaginates'])->name('api.admin.pages-banners.get-all-pages-banners-paginate');        
            Route::get('trash', [PageBannerControllerAdmin::class,'trash'])->name('api.admin.pages-banners.trash');
            Route::get('restore-all', [PageBannerControllerAdmin::class,'restoreAll'])->name('api.admin.pages-banners.restore-all');
            Route::get('restore/{id}', [PageBannerControllerAdmin::class,'restore'])->name('api.admin.pages-banners.restore');
            Route::post('store', [PageBannerControllerAdmin::class,'store'])->name('api.admin.pages-banners.store');
            Route::post('store-trans/{id}/{lang}', [PageBannerControllerAdmin::class,'storeTrans'])->name('api.admin.pages-banners.store-trans/{id}/{lang}');
            Route::get('show/{id}', [PageBannerControllerAdmin::class,'show'])->name('api.admin.pages-banners.show');
            Route::post('update/{id}', [PageBannerControllerAdmin::class,'update'])->name('api.admin.pages-banners.update');
            Route::get('destroy/{id}', [PageBannerControllerAdmin::class,'destroy'])->name('api.admin.pages-banners.destroy');        
            Route::get('force-delete/{id}', [PageBannerControllerAdmin::class,'forceDelete'])->name('api.admin.pages-banners.force-delete');
        });

        Route::prefix('accordions')->group(function(){
            Route::get('/all/{lang?}', [PageAccordionControllerAdmin::class,'index'])->name('api.admin.pages-accordions.index');    
            Route::get('/get-all-paginates/{lang?}', [PageAccordionControllerAdmin::class,'getAllPaginates'])->name('api.admin.pages-accordions.get-all-pages-accordions-paginate');        
            Route::get('trash', [PageAccordionControllerAdmin::class,'trash'])->name('api.admin.pages-accordions.trash');
            Route::get('restore-all', [PageAccordionControllerAdmin::class,'restoreAll'])->name('api.admin.pages-accordions.restore-all');
            Route::get('restore/{id}', [PageAccordionControllerAdmin::class,'restore'])->name('api.admin.pages-accordions.restore');
            Route::post('store', [PageAccordionControllerAdmin::class,'store'])->name('api.admin.pages-accordions.store');
            Route::post('store-trans/{id}/{lang}', [PageAccordionControllerAdmin::class,'storeTrans'])->name('api.admin.pages-accordions.store-trans/{id}/{lang}');
            Route::get('show/{id}', [PageAccordionControllerAdmin::class,'show'])->name('api.admin.pages-accordions.show');
            Route::post('update/{id}', [PageAccordionControllerAdmin::class,'update'])->name('api.admin.pages-accordions.update');
            Route::get('destroy/{id}', [PageAccordionControllerAdmin::class,'destroy'])->name('api.admin.pages-accordions.destroy');        
            Route::get('force-delete/{id}', [PageAccordionControllerAdmin::class,'forceDelete'])->name('api.admin.pages-accordions.force-delete');
        });
    });

 });
    /**************************Routes User***************************** */

 Route::prefix('pages')->group(function(){
        Route::get('/all/{lang?}', [PageControllerUser::class,'index'])->name('api.pages.get-all-data');
        
        Route::prefix('banners')->group(function(){
            Route::get('/all/{lang?}', [PageBannerControllerUser::class,'index'])->name('api.pages-banners.get-all-data');    

        });
 });