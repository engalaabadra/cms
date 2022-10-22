<?php

use Illuminate\Support\Facades\Route;
use Modules\Gallery\Http\Controllers\API\Admin\GalleryController as GalleryControllerAdmin;
use Modules\Gallery\Http\Controllers\API\Admin\Categories\GalleryController as GalleryCategoriesControllerAdmin;
use Modules\Gallery\Http\Controllers\API\Admin\Albums\GalleryController as GalleryAlbumsControllerAdmin;
use Modules\Gallery\Http\Controllers\API\Admin\Images\GalleryController as GalleryImagesControllerAdmin;
use Modules\Gallery\Http\Controllers\API\User\Images\GalleryController as GalleryImagesControllerUser;
/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('galleries')->group(function(){
        Route::get('/all/{lang?}', [GalleryControllerAdmin::class,'index'])->name('api.admin.galleries.index');    
        Route::get('/get-all-paginates/{lang?}', [GalleryControllerAdmin::class,'getAllPaginates'])->name('api.admin.galleries.get-all-galleries-paginate');        
        Route::get('trash', [GalleryControllerAdmin::class,'trash'])->name('api.admin.galleries.trash');
        Route::get('restore-all', [GalleryControllerAdmin::class,'restoreAll'])->name('api.admin.galleries.restore-all');
        Route::get('restore/{id}', [GalleryControllerAdmin::class,'restore'])->name('api.admin.galleries.restore');
        Route::post('store', [GalleryControllerAdmin::class,'store'])->name('api.admin.galleries.store');
        Route::post('store-trans/{id}/{lang}', [GalleryControllerAdmin::class,'storeTrans'])->name('api.admin.galleries.store-trans');
        Route::get('show/{id}', [GalleryControllerAdmin::class,'show'])->name('api.admin.galleries.show');
        Route::post('update/{id}', [GalleryControllerAdmin::class,'update'])->name('api.admin.galleries.update');
        Route::get('destroy/{id}', [GalleryControllerAdmin::class,'destroy'])->name('api.admin.galleries.destroy');        
        Route::get('force-delete/{id}', [GalleryControllerAdmin::class,'forceDelete'])->name('api.admin.galleries.force-delete');
       
       

        Route::prefix('categories')->group(function(){
            Route::get('/all/{lang?}', [GalleryCategoriesControllerAdmin::class,'index'])->name('api.admin.gallery-categories.index');    
            Route::get('/get-all-paginates/{lang?}', [GalleryCategoriesControllerAdmin::class,'getAllPaginates'])->name('api.admin.gallery-categories.get-all-gallery-categories-paginate');        
            Route::get('trash', [GalleryCategoriesControllerAdmin::class,'trash'])->name('api.admin.gallery-categories.trash');
            Route::get('restore-all', [GalleryCategoriesControllerAdmin::class,'restoreAll'])->name('api.admin.gallery-categories.restore-all');
            Route::get('restore/{id}', [GalleryCategoriesControllerAdmin::class,'restore'])->name('api.admin.gallery-categories.restore');
            Route::post('store', [GalleryCategoriesControllerAdmin::class,'store'])->name('api.admin.gallery-categories.store');
            Route::get('show/{id}', [GalleryCategoriesControllerAdmin::class,'show'])->name('api.admin.gallery-categories.show');
            Route::post('update/{id}', [GalleryCategoriesControllerAdmin::class,'update'])->name('api.admin.gallery-categories.update');
            Route::get('destroy/{id}', [GalleryCategoriesControllerAdmin::class,'destroy'])->name('api.admin.gallery-categories.destroy');        
            Route::get('force-delete/{id}', [GalleryCategoriesControllerAdmin::class,'forceDelete'])->name('api.admin.gallery-categories.force-delete');
        });

        Route::prefix('albums')->group(function(){
            Route::get('/all/{lang?}', [GalleryAlbumsControllerAdmin::class,'index'])->name('api.admin.gallery-albums.index');    
            Route::get('/get-all-paginates/{lang?}', [GalleryAlbumsControllerAdmin::class,'getAllPaginates'])->name('api.admin.gallery-albums.get-all-gallery-albums-paginate');        
            Route::get('trash', [GalleryAlbumsControllerAdmin::class,'trash'])->name('api.admin.gallery-albums.trash');
            Route::get('restore-all', [GalleryAlbumsControllerAdmin::class,'restoreAll'])->name('api.admin.gallery-albums.restore-all');
            Route::get('restore/{id}', [GalleryAlbumsControllerAdmin::class,'restore'])->name('api.admin.gallery-albums.restore');
            Route::post('store', [GalleryAlbumsControllerAdmin::class,'store'])->name('api.admin.gallery-albums.store');
            Route::get('show/{id}', [GalleryAlbumsControllerAdmin::class,'show'])->name('api.admin.gallery-albums.show');
            Route::post('update/{id}', [GalleryAlbumsControllerAdmin::class,'update'])->name('api.admin.gallery-albums.update');
            Route::get('destroy/{id}', [GalleryAlbumsControllerAdmin::class,'destroy'])->name('api.admin.gallery-albums.destroy');        
            Route::get('force-delete/{id}', [GalleryAlbumsControllerAdmin::class,'forceDelete'])->name('api.admin.gallery-albums.force-delete');
        });

        Route::prefix('images')->group(function(){
            Route::get('/all/{lang?}', [GalleryImagesControllerAdmin::class,'index'])->name('api.admin.gallery-images.index');    
            Route::get('/get-all-paginates/{lang?}', [GalleryImagesControllerAdmin::class,'getAllPaginates'])->name('api.admin.gallery-images.get-all-gallery-images-paginate');        
            Route::get('trash', [GalleryImagesControllerAdmin::class,'trash'])->name('api.admin.gallery-images.trash');
            Route::get('restore-all', [GalleryImagesControllerAdmin::class,'restoreAll'])->name('api.admin.gallery-images.restore-all');
            Route::get('restore/{id}', [GalleryImagesControllerAdmin::class,'restore'])->name('api.admin.gallery-images.restore');
            Route::post('store', [GalleryImagesControllerAdmin::class,'store'])->name('api.admin.gallery-images.store');
            Route::get('show/{id}', [GalleryImagesControllerAdmin::class,'show'])->name('api.admin.gallery-images.show');
            Route::post('update/{id}', [GalleryImagesControllerAdmin::class,'update'])->name('api.admin.gallery-images.update');
            Route::get('destroy/{id}', [GalleryImagesControllerAdmin::class,'destroy'])->name('api.admin.gallery-images.destroy');        
            Route::get('force-delete/{id}', [GalleryImagesControllerAdmin::class,'forceDelete'])->name('api.admin.gallery-images.force-delete');
        });
    });

 });
    Route::prefix('galleries')->group(function(){

        Route::prefix('images')->group(function(){
                    Route::get('/all/{lang?}', [GalleryImagesControllerUser::class,'index'])->name('api.gallery-images.index');    
        });    
    
    });