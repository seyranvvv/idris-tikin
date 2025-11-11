
<?php

use App\Http\Controllers\Api\MaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DeliveryLocationController;




Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

Route::get('sliders', [SliderController::class, 'index']);

Route::get('pages', [PageController::class, 'index']);
Route::get('pages/{slug}', [PageController::class, 'show']);

Route::get('products/new/latest', [ProductController::class, 'latest']); // Последние 10 новых продуктов
Route::get('products/popular/random', [ProductController::class, 'popular']); // 10 случайных популярных продуктов
Route::get('products/filter/recommended', [ProductController::class, 'recommended']); // Рекомендуемые (20 случайных)
Route::get('products/filter/views', [ProductController::class, 'views']); // По популярности (20 случайных)
Route::get('products/filter/cheap', [ProductController::class, 'cheap']); // От дешевых к дорогим (20 шт)
Route::get('products/filter/expensive', [ProductController::class, 'expensive']); // От дорогих к дешевым (20 шт)
Route::get('products/filter/latest', [ProductController::class, 'filterLatest']); // Новинки (20 последних)
Route::get('products/search', [ProductController::class, 'search']); // Поиск продуктов ?q=текст
Route::get('products', [ProductController::class, 'index']); // с поддержкой ?category_id={id}
Route::get('products/{id}', [ProductController::class, 'show']);

Route::post('orders', [OrderController::class, 'store']); // Создание заказа
Route::get('orders/{id}', [OrderController::class, 'show']); // Информация о заказе

Route::get('delivery-locations', [DeliveryLocationController::class, 'index']); // Список активных локаций
Route::get('delivery-locations/{id}', [DeliveryLocationController::class, 'show']); // Информация о локации

Route::get('materials', [MaterialController::class, 'index']);
Route::get('materials/{id}', [MaterialController::class, 'show']);
Route::get('materials/search', 'Api\MaterialController@search')->name('materials.search');
Route::get('materials/category/{categoryId}', [MaterialController::class, 'byCategory']);





