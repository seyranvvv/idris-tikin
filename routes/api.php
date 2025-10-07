<?php

use App\Http\Controllers\Api\MaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('materials', [MaterialController::class, 'index']);
Route::get('materials/{id}', [MaterialController::class, 'show']);
Route::get('materials/search', 'Api\MaterialController@search')->name('materials.search');
Route::get('materials/category/{categoryId}', [MaterialController::class, 'byCategory']);





