<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\MaterialCategoryLinkController;
use App\Http\Controllers\MaterialImageController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\DeliveryLocationController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Кастомный маршрут для удаления связи материал-категория
    Route::delete('material-category-links/{material_id}/category/{category_id}', [MaterialCategoryLinkController::class, 'destroy'])->name('material-category-links.destroy');
    // Маршруты для изображений материалов
    Route::post('material-category-links/{material_id}/images', [MaterialImageController::class, 'store'])->name('material-images.store');
    Route::delete('material-category-links/{material_id}/images/{image_id}', [MaterialImageController::class, 'destroy'])->name('material-images.destroy');
    Route::post('material-category-links/{material_id}/images/{image_id}', [MaterialImageController::class, 'update'])->name('material-images.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('product-categories', ProductCategoryController::class)->middleware('auth');
    Route::resource('sliders', SliderController::class)->middleware('auth');
    Route::resource('pages', PageController::class)->middleware('auth');
    Route::resource('delivery-locations', DeliveryLocationController::class)->middleware('auth');
    
    // Маршруты для управления заказами
    Route::get('orders', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderManagementController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('orders/{id}', [OrderManagementController::class, 'destroy'])->name('orders.destroy');
    
    // Кастомный маршрут для добавления категории к материалу
    Route::post('material-category-links/{material_id}', [MaterialCategoryLinkController::class, 'store'])->name('material-category-links.store')->middleware('auth');
    // Остальные CRUD-операции через resource, кроме store
    Route::resource('material-category-links', MaterialCategoryLinkController::class)->except(['store', 'destroy'])->middleware('auth');
});



require __DIR__.'/auth.php';
