<?php

use Illuminate\Support\Facades\Route;
use Modules\ContactUs\Http\Controllers\API\Admin\ContactController as ContactControllerAdmin;
use Modules\ContactUs\Http\Controllers\API\User\ContactController as ContactControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('contacts')->group(function(){
        Route::get('/all/{lang?}', [ContactControllerAdmin::class,'index'])->name('api.admin.contacts.index');    
        Route::get('/get-all-paginates/{lang?}', [ContactControllerAdmin::class,'getAllPaginates'])->name('api.admin.contacts.get-all-contacts-paginate');        
        Route::get('trash', [ContactControllerAdmin::class,'trash'])->name('api.admin.contacts.trash');
        Route::get('restore-all', [ContactControllerAdmin::class,'restoreAll'])->name('api.admin.contacts.restore-all');
        Route::get('restore/{id}', [ContactControllerAdmin::class,'restore'])->name('api.admin.contacts.restore');
        
        Route::get('show/{id}', [ContactControllerAdmin::class,'show'])->name('api.admin.contacts.show');
        Route::get('destroy/{id}', [ContactControllerAdmin::class,'destroy'])->name('api.admin.contacts.destroy');        
        Route::get('force-delete/{id}', [ContactControllerAdmin::class,'forceDelete'])->name('api.admin.contacts.force-delete');

    });

 });


Route::prefix('contacts')->group(function(){
        Route::post('send', [ContactControllerUser::class,'send'])->name('api.user.contacts.send');

    });