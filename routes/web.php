<?php

use Illuminate\Support\Facades\Route;
use Ameth\Diamanka\Http\Controllers\RoleController;
use Ameth\Diamanka\Http\Controllers\PermissionController;

Route::prefix('diamanka')->middleware(['web', 'auth'])->group(function () {
    Route::resource('roles', RoleController::class)->names('diamanka.roles');
    Route::resource('permissions', PermissionController::class)->names('diamanka.permissions');
});