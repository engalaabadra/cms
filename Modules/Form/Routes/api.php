<?php

use Illuminate\Support\Facades\Route;
use Modules\Form\Http\Controllers\API\Admin\FormController as FormControllerAdmin;
use Modules\Form\Http\Controllers\API\User\FormController as FormControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('forms')->group(function(){
        Route::get('/all/{lang?}', [FormControllerAdmin::class,'index'])->name('api.admin.forms.index');    
        Route::get('/get-all-paginates/{lang?}', [FormControllerAdmin::class,'getAllPaginates'])->name('api.admin.forms.get-all-forms-paginate');        
        Route::get('trash', [FormControllerAdmin::class,'trash'])->name('api.admin.forms.trash');
        Route::get('restore-all', [FormControllerAdmin::class,'restoreAll'])->name('api.admin.forms.restore-all');
        Route::get('restore/{id}', [FormControllerAdmin::class,'restore'])->name('api.admin.forms.restore');
        Route::post('store', [FormControllerAdmin::class,'store'])->name('api.admin.forms.store');
        Route::get('show/{id}', [FormControllerAdmin::class,'show'])->name('api.admin.forms.show');
        Route::post('update/{id}', [FormControllerAdmin::class,'update'])->name('api.admin.forms.update');
        Route::get('destroy/{id}', [FormControllerAdmin::class,'destroy'])->name('api.admin.forms.destroy');        
        Route::get('force-delete/{id}', [FormControllerAdmin::class,'forceDelete'])->name('api.admin.forms.force-delete');

    });

 });


Route::prefix('newsletters')->group(function(){
        Route::post('send', [NewsletterControllerUser::class,'send'])->name('api.user.newsletters.send');

    });