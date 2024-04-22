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
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CartLensController;
// Seller Importation
use App\Http\Controllers\seller\SellController;
use App\Http\Controllers\seller\CartController;
use App\Http\Controllers\SalesController;

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

// Admin Controlllers

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminCheck', 'approvedUser'], 'as' => 'admin.'], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('/items/glasses', [itemsController::class, 'index'])->name('items.index');
    Route::post('/item/glasses/store', [itemsController::class, 'store'])->name('item.store');
    Route::get('/item/glasses/edit/{id}', [itemsController::class, 'edit'])->name('item.edit');
    Route::put('/item/glasses/update/{id}', [itemsController::class, 'update'])->name('item.update');
    Route::delete('/item/glasses/delete/{id}', [itemsController::class, 'delete'])->name('item.delete');

    Route::get('/items/lens', [ItemsLensController::class, 'index'])->name('items.lens.index');
    Route::post('/item/lens/store', [ItemsLensController::class, 'store'])->name('item.lens.store');
    Route::get('/item/lens/edit/{id}', [ItemsLensController::class, 'edit'])->name('item.lens.edit');
    Route::put('/item/lens/update/{id}', [ItemsLensController::class, 'update'])->name('item.lens.update');
    Route::delete('/item/lens/delete/{id}', [ItemsLensController::class, 'delete'])->name('item.lens.delete');

    Route::get('/users', [ManageUsersController::class, 'index'])->name('users.index');
    Route::post('/user/store', [ManageUsersController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [ManageUsersController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [ManageUsersController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [ManageUsersController::class, 'delete'])->name('user.delete');

    // Supplier routes to manage controllers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

    // Customer routes to manage controllers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

    // Purchase glasses routes to manage controllers
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
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

    // Invoice route to manage correspondings controller
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice-by-sell-code/{id}', [InvoiceController::class, 'InvoivebySellCode'])->name('invoice-by-sell-code.index');
    Route::get('/pro-invoices', [InvoiceController::class, 'proforma'])->name('invoice.pro.index');
    Route::get('/req-invoices', [InvoiceController::class, 'request'])->name('invoice.req.index');

    // Customer routes to manage controllers

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/lens', [ReportController::class, 'index2'])->name('reports.lens.index');
    Route::get('/reports/speed', [ReportController::class, 'fastslow'])->name('reports.speed');
});

// Seller Controller

Route::group(['prefix' => 'seller', 'as' => 'seller.', 'middleware' => ['auth', 'sellerCheck', 'approvedUser']], function () {
    Route::get('/sell', [SellController::class, 'index'])->name('sell.index');
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
    Route::delete('/seller/sales/{id}', [SellController::class, 'destroy'])->name('sales.destroy');
    Route::get('/seller/sales/{id}/edit', [SellController::class, 'edit'])->name('sales.edit');
    Route::put('/seller/sales/{id}', [SellController::class, 'update'])->name('sales.update');
    Route::get('/invoice/{id}', [InvoiceController::class, 'view'])->name('invoice.view');
    //Report
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/lens', [ReportController::class, 'index2'])->name('reports.lens.index');

    //stock
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

    // Invoice by SellCode

    Route::get('/invoice-by-sell-code/{id}', [InvoiceController::class, 'InvoivebySellCode'])->name('invoice-by-sell-code.index');

    //sell Glasses
    // Route::post('/sale/store', [CartController::class, 'store'])->name('cart.store');
    // Route::get('/make-sales', [CartController::class, 'index'])->name('sale.index');

    // Route::get('/sale/glasses/edit/{id}', [CartController::class, 'edit'])->name('sale.edit');
    // Route::post('/sale/glasses/update/{id}', [CartController::class, 'update'])->name('sale.update');
    // Route::delete('/sale/glasses/delete/{id}', [CartController::class, 'delete'])->name('sale.delete');

    // Sell Lens

    //sell lens

    Route::post('/sale/Lens/store', [CartLensController::class, 'store'])->name('cart-lens.store');
    Route::get('/sale/lens/edit/{id}', [CartLensController::class, 'edit'])->name('sale.lens.edit');
    Route::post('/sale/lens/update/{id}', [CartLensController::class, 'update'])->name('sale.lens.update');
    Route::delete('/sale/lens/delete/{id}', [CartLensController::class, 'delete'])->name('lens.delete');
    Route::delete('/sale/cart-lens/delete/{id}', [CartLensController::class, 'deleteCart'])->name('cart.lens.delete');

    // Customer routes to manage controllers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

    // Additional to sales controller

    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/fetch-codes', [SalesController::class, 'fetchCodes'])->name('fetch.codes');
    Route::get('/fetch-colors', [SalesController::class, 'fetchColors'])->name('fetch.colors');
    Route::post('/add-to-cart', [SalesController::class, 'addToCart'])->name('add.to.cart');
    Route::delete('/clear-cart', [SalesController::class, 'clearCart'])->name('clear.cart');
    Route::delete('/remove-from-cart/{id}', [SalesController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::delete('/remove-cart/{id}', [SalesController::class, 'remove'])->name('item-cart.remove');

    Route::get('/invoice-0781Ca/checkout/{id}', [SalesController::class, 'checkout'])->name('checkout');
    Route::put('/update/checkout/{id}', [SalesController::class, 'update'])->name('checkout.update');
});
