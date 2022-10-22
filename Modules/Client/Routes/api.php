<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Controllers\API\Admin\ClientController as ClientControllerAdmin;
use Modules\Client\Http\Controllers\API\Admin\Infos\ClientController as ClientInfoControllerAdmin;

/**************************Routes Admin***************************** */
Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){

    Route::prefix('clients')->group(function(){
        Route::get('/all/{lang?}', [ClientControllerAdmin::class,'index'])->name('api.admin.clients.index');    
        Route::get('/get-all-clients-paginate', [ClientControllerAdmin::class,'getAllclientsPaginate'])->name('api.admin.clients.get-all-clients-paginate');        
        Route::get('trash', [ClientControllerAdmin::class,'trash'])->name('api.admin.clients.trash');
        Route::get('restore-all', [ClientControllerAdmin::class,'restoreAll'])->name('api.admin.clients.restore-all');
        Route::get('restore/{id}', [ClientControllerAdmin::class,'restore'])->name('api.admin.clients.restore');
        Route::post('store', [ClientControllerAdmin::class,'store'])->name('api.admin.clients.store');
        Route::get('show/{id}', [ClientControllerAdmin::class,'show'])->name('api.admin.clients.show');
        Route::post('update/{id}', [ClientControllerAdmin::class,'update'])->name('api.admin.clients.update');
        Route::get('destroy/{id}', [ClientControllerAdmin::class,'destroy'])->name('api.admin.clients.destroy');        
        Route::get('force-delete/{id}', [ClientControllerAdmin::class,'forceDelete'])->name('api.admin.clients.force-delete');
       
       
        Route::prefix('infos')->group(function(){
            Route::get('/', [ClientInfoControllerAdmin::class,'index'])->name('api.admin.clients-infos.index');    
            Route::get('/get-all-paginates', [ClientInfoControllerAdmin::class,'getAllPaginates'])->name('api.admin.clients-infos.get-all-clients-infos-paginate');        
            Route::get('/get-all-infos-client-paginates/{clientId}', [ClientInfoControllerAdmin::class,'getAllInfosClientPaginates'])->name('api.admin.clients-infos.get-all-infos-client-paginate');        
            Route::get('trash', [ClientInfoControllerAdmin::class,'trash'])->name('api.admin.clients-infos.trash');
            Route::get('restore-all', [ClientInfoControllerAdmin::class,'restoreAll'])->name('api.admin.clients-infos.restore-all');
            Route::get('restore/{id}', [ClientInfoControllerAdmin::class,'restore'])->name('api.admin.clients-infos.restore');
            Route::post('store/{clientId}', [ClientInfoControllerAdmin::class,'store'])->name('api.admin.clients-infos.store');
            Route::get('show/{id}', [ClientInfoControllerAdmin::class,'show'])->name('api.admin.clients-infos.show');
            Route::post('update/{id}', [ClientInfoControllerAdmin::class,'update'])->name('api.admin.clients-infos.update');
            Route::get('destroy/{id}', [ClientInfoControllerAdmin::class,'destroy'])->name('api.admin.clients-infos.destroy');        
            Route::get('force-delete/{id}', [ClientInfoControllerAdmin::class,'forceDelete'])->name('api.admin.clients-infos.force-delete');
        });
    });

 });
