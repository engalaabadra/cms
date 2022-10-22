<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\API\PermissionController;
use Modules\Auth\Http\Controllers\API\RoleController;
use Modules\Auth\Http\Controllers\API\UserController;


/**************************Routes Admin***************************** */

Route::prefix('admin')->middleware(['auth:api'])->namespace('API')->group(function(){
    Route::prefix('users')->group(function(){
        Route::get('/all/{lang?}', [UserController::class,'index'])->name('api.admin.users.index');    
                Route::get('search/{word}', [UserController::class,'search'])->name('api.admin.users.search');    

        Route::get('/get-all-paginates/{lang?}', [UserController::class,'getAllPaginates'])->name('api.admin.users.get-all-users-paginate');
        Route::get('trash', [UserController::class,'trash'])->name('api.admin.users.trash');
        Route::get('restore-all', [UserController::class,'restoreAll'])->name('api.admin.users.restore-all');
        Route::get('restore/{id}', [UserController::class,'restore'])->name('api.admin.users.restore');
        Route::post('store', [UserController::class,'store'])->name('api.admin.users.store');
        Route::post('store-trans/{id}/{lang}', [UserController::class,'storeTrans'])->name('api.admin.users.store-trans');
        Route::get('show/{id}', [UserController::class,'show'])->name('api.admin.users.show');
        Route::post('update/{id}', [UserController::class,'update'])->name('api.admin.users.update');
        Route::get('destroy/{id}', [UserController::class,'destroy'])->name('api.admin.users.destroy');        
        Route::get('force-delete/{id}', [UserController::class,'forceDelete'])->name('api.admin.users.force-delete');
        Route::post('activation/{id}',[UserController::class,'activation']);
    });
    Route::prefix('roles')->group(function(){
        Route::get('/all/{lang?}', [RoleController::class,'index'])->name('api.admin.roles.index');
        Route::get('/get-all-paginates/{lang?}', [RoleController::class,'getAllPaginates'])->name('api.admin.roles.get-all-roles-paginate');
        Route::get('trash', [RoleController::class,'trash'])->name('api.admin.roles.trash');
        Route::get('roles-permission-by-name/{permissionId}', [RoleController::class,'rolesPermissionByName'])->name('api.admin.permissions.roles-permission-by-name');
        Route::get('restore-all', [RoleController::class,'restoreAll'])->name('api.admin.roles.restore-all');
        Route::get('restore/{id}', [RoleController::class,'restore'])->name('api.admin.roles.restore');
        Route::get('/roles-user-by-name/{userId}', [RoleController::class,'rolesUserByName'])->name('api.admin.roles.roles-user-by-name'); 
        Route::post('store', [RoleController::class,'store'])->name('api.admin.roles.store');
        Route::post('store-trans/{id}/{lang}', [RoleController::class,'storeTrans'])->name('api.admin.roles.store-trans');
        Route::get('show/{id}', [RoleController::class,'show'])->name('api.admin.roles.show');
        Route::post('update/{id}', [RoleController::class,'update'])->name('api.admin.roles.update');
        Route::get('destroy/{id}', [RoleController::class,'destroy'])->name('api.admin.roles.destroy');
        Route::get('force-delete/{id}', [RoleController::class,'forceDelete'])->name('api.admin.roles.force-delete');
    });
    Route::prefix('permissions')->group(function(){
        Route::get('/all/{lang?}', [PermissionController::class,'index'])->name('api.admin.permissions.index');
        Route::get('/get-all-paginates/{lang?}', [PermissionController::class,'getAllPaginates'])->name('api.admin.roles.get-all-permissions-paginate');
        Route::get('trash', [PermissionController::class,'trash'])->name('api.admin.permissions.trash');
        Route::get('permissions-role-by-name/{roleId}', [PermissionController::class,'permissionsRoleByName'])->name('api.admin.permissions.permissions-role-by-name');
        Route::get('restore-all', [PermissionController::class,'restoreAll'])->name('api.admin.permissions.restore-all');
        Route::get('restore/{id}', [PermissionController::class,'restore'])->name('api.admin.permissions.restore');
        Route::post('store', [PermissionController::class,'store'])->name('api.admin.permissions.store');
        Route::post('store-trans/{id}/{lang}', [PermissionController::class,'storeTrans'])->name('api.admin.permissions.store-trans');
        Route::get('show/{id}', [PermissionController::class,'show'])->name('api.admin.permissions.show');
        Route::post('update/{id}', [PermissionController::class,'update'])->name('api.admin.permissions.update');
        Route::get('destroy/{id}', [PermissionController::class,'destroy'])->name('api.admin.permissions.destroy');
        Route::get('force-delete/{id}', [PermissionController::class,'forceDelete'])->name('api.admin.permissions.force-delete');
    });

});


