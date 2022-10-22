<?php

use Illuminate\Support\Facades\Route;
use Modules\Newsletter\Http\Controllers\API\Admin\NewsletterController as NewsletterControllerAdmin;
use Modules\Newsletter\Http\Controllers\API\User\NewsletterController as NewsletterControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('newsletters')->group(function(){
        Route::get('/all/{lang?}', [NewsletterControllerAdmin::class,'index'])->name('api.admin.newsletters.index');    
        Route::get('/get-all-paginates/{lang?}', [NewsletterControllerAdmin::class,'getAllPaginates'])->name('api.admin.newsletters.get-all-newsletters-paginate');        
        Route::get('trash', [NewsletterControllerAdmin::class,'trash'])->name('api.admin.newsletters.trash');
        Route::get('restore-all', [NewsletterControllerAdmin::class,'restoreAll'])->name('api.admin.newsletters.restore-all');
        Route::get('restore/{id}', [NewsletterControllerAdmin::class,'restore'])->name('api.admin.newsletters.restore');
        Route::post('store', [NewsletterControllerAdmin::class,'store'])->name('api.admin.newsletters.store');
        Route::post('store-trans/{id}/{lang}', [NewsletterControllerAdmin::class,'storeTrans'])->name('api.admin.newsletters.store-trans');
        Route::get('show/{id}', [NewsletterControllerAdmin::class,'show'])->name('api.admin.newsletters.show');
        Route::post('update/{id}', [NewsletterControllerAdmin::class,'update'])->name('api.admin.newsletters.update');
        Route::get('destroy/{id}', [NewsletterControllerAdmin::class,'destroy'])->name('api.admin.newsletters.destroy');        
        Route::get('force-delete/{id}', [NewsletterControllerAdmin::class,'forceDelete'])->name('api.admin.newsletters.force-delete');

    });

 });
