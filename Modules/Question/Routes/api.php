<?php

use Illuminate\Support\Facades\Route;
use Modules\Question\Http\Controllers\API\Admin\QuestionController as QuestionControllerAdmin;
use Modules\Question\Http\Controllers\API\User\QuestionController as QuestionControllerUser;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('questions')->group(function(){
        Route::get('/all/{lang?}', [QuestionControllerAdmin::class,'index'])->name('api.admin.questions.index');    
        Route::get('/get-all-paginates/{lang?}', [QuestionControllerAdmin::class,'getAllPaginates'])->name('api.admin.questions.get-all-questions-paginate');        
        Route::get('trash', [QuestionControllerAdmin::class,'trash'])->name('api.admin.questions.trash');
        Route::get('restore-all', [QuestionControllerAdmin::class,'restoreAll'])->name('api.admin.questions.restore-all');
        Route::get('restore/{id}', [QuestionControllerAdmin::class,'restore'])->name('api.admin.questions.restore');
        Route::post('store', [QuestionControllerAdmin::class,'store'])->name('api.admin.questions.store');
        Route::post('store-trans/{id}/{lang}', [QuestionControllerAdmin::class,'storeTrans'])->name('api.admin.questions.store-trans');
        Route::get('show/{id}', [QuestionControllerAdmin::class,'show'])->name('api.admin.questions.show');
        Route::post('update/{id}', [QuestionControllerAdmin::class,'update'])->name('api.admin.questions.update');
        Route::get('destroy/{id}', [QuestionControllerAdmin::class,'destroy'])->name('api.admin.questions.destroy');        
        Route::get('force-delete/{id}', [QuestionControllerAdmin::class,'forceDelete'])->name('api.admin.questions.force-delete');

    });

 });
