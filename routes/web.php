<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\itemsController;
use App\Http\Controllers\ItemsLensController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseLensController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
Route::get('dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'approvedUser'])
    ->name('home');

Route::group(['prefix' => 'seller', 'as' => 'seller.', 'middleware' => ['auth', 'sellerCheck', 'approvedUser']], function () {});

// Admin Controlllers

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminCheck', 'approvedUser'], 'as' => 'admin.'], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('/items/glasses', [itemsController::class, 'index'])->name('items.index');
    Route::post('/item/glasses/store', [itemsController::class, 'store'])->name('item.store');
    Route::put('/item/glasses/update/{id}', [itemsController::class, 'update'])->name('item.update');
    Route::delete('/item/glasses/delete/{id}', [itemsController::class, 'delete'])->name('item.delete');

    Route::get('/items/lens', [ItemsLensController::class, 'index'])->name('items.lens.index');
    Route::post('/item/lens/store', [ItemsLensController::class, 'store'])->name('item.lens.store');
    Route::put('/item/lens/update/{id}', [ItemsLensController::class, 'update'])->name('item.lens.update');
    Route::delete('/item/lens/delete/{id}', [ItemsLensController::class, 'delete'])->name('item.lens.delete');

    Route::get('/users', [ManageUsersController::class, 'index'])->name('users.index');

    // Supplier routes to manage controllers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/suppliers/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/suppliers/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

    // Customer routes to manage controllers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

    // Purchase glasses routes to manage controllers
    Route::get('/purchase/glasses', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/purchase/glasses/store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/glasses/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::post('/purchase/glasses/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/glasses/delete/{id}', [PurchaseController::class, 'delete'])->name('purchase.delete');

    // Purchase lens routes to manage controllers
    Route::post('/purchase/lens/store', [PurchaseLensController::class, 'store'])->name('purchase.lens.store');
    Route::get('/purchase/lens/edit/{id}', [PurchaseLensController::class, 'edit'])->name('purchase.lens.edit');
    Route::post('/purchase/lens/update/{id}', [PurchaseLensController::class, 'update'])->name('purchase.lens.update');
    Route::delete('/purchase/lens/delete/{id}', [PurchaseLensController::class, 'delete'])->name('purchase.lens.delete');

   
    // Controller to handle the items removal
    Route::delete('/purchase/item/delete/{id}', [PurchaseController::class, 'deleteItem'])->name('purchase.item.delete');
    Route::delete('/purchase/lens/delete/{id}', [PurchaseLensController::class, 'deleteLens'])->name('purchase.lens.delete');

    // Customer routes to manage controllers

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
