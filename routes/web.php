<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\ManageCategoryController;
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
use App\Http\Controllers\WeeklyReportController;
// Seller Importation
use App\Http\Controllers\seller\SellController;
use App\Http\Controllers\seller\CartController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LensSalesController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PerformaInvoices;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\MakeSalesController;
use App\Http\Controllers\ConfirmOrdersController;
use App\Http\Controllers\PurchaseCartController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\PdfController;

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

Route::get('/searchStock', [ConfirmOrdersController::class, 'searchStock'])->name('searchStock');

Route::get('/download-pdf', [PdfController::class, 'index'])->name('download.pdf');

Route::post('/get-codes', [itemsController::class, 'getCodes'])->name('get-codes');
Route::post('/get-colors', [itemsController::class, 'getColors'])->name('get-colors');
Route::post('/get-sizes', [itemsController::class, 'getSizes'])->name('get-sizes');






// Handling glasses

Route::post('/get-codes3', [itemsController::class, 'getCodes3'])->name('get-codes3');
Route::post('/get-colors3', [itemsController::class, 'getColors3'])->name('get-colors3');
Route::post('/get-sizes3', [itemsController::class, 'getSizes3'])->name('get-sizes3');



// Handling reading glasses

Route::post('/get-codes4', [itemsController::class, 'getCodes4'])->name('get-codes4');
Route::post('/get-colors4', [itemsController::class, 'getColors4'])->name('get-colors4');
Route::post('/get-sizes4', [itemsController::class, 'getSizes4'])->name('get-sizes4');




Route::post('/get-attributes', [itemsController::class, 'getAttributes'])->name('get-attributes');
Route::post('/get-power_sph', [itemsController::class, 'getSph'])->name('get-sph');
Route::post('/get-power_cyl', [itemsController::class, 'getCyl'])->name('get-cyl');
Route::post('/get-power_axis', [itemsController::class, 'getAxis'])->name('get-axis');
Route::post('/get-power_add', [itemsController::class, 'getAdd'])->name('get-add');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'adminCheck', 'approvedUser'], 'as' => 'admin.'], function () {
    Route::get('/weekly-report', [WeeklyReportController::class, 'show']);
    Route::get('/categories', [ManageCategoryController::class, 'index'])->name('category.index');
    Route::post('/category/store', [ManageCategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [ManageCategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [ManageCategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [ManageCategoryController::class, 'delete'])->name('category.delete');

    Route::get('/filterData', [HomeController::class, 'filterData'])->name('filterData');
    Route::get('/filterYearData', [HomeController::class, 'filterYearData'])->name('filterYearData');

    Route::get('api/sales-data', [StatisticController::class, 'getSalesData'])->name('admin.api.sales-data');
    Route::get('api/lens-sales-data', [StatisticController::class, 'getLensSalesData'])->name('admin.api.lens-sales-data');
    Route::get('api/frame-sales-data', [StatisticController::class, 'getFrameSalesData'])->name('admin.api.frame-sales-data');

    Route::get('/items/glasses', [itemsController::class, 'index'])->name('items.index');
    Route::post('/item/glasses/store', [itemsController::class, 'store'])->name('item.store');
    Route::get('/item/glasses/edit/{id}', [itemsController::class, 'edit'])->name('item.edit');
    Route::put('/item/glasses/update/{id}', [itemsController::class, 'update'])->name('item.update');
    Route::delete('/item/glasses/delete/{id}', [itemsController::class, 'delete'])->name('item.delete');

    Route::get('/show/statistics', [StatisticController::class, 'index'])->name('admin.statistics');

    Route::get('/insurances', [InsuranceController::class, 'index'])->name('insurances');
    Route::post('/insurance', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::delete('/insurance/{id}', [InsuranceController::class, 'delete'])->name('insurance.delete');

    Route::get('/items/lens', [ItemsLensController::class, 'index'])->name('items.lens.index');
    Route::post('/item/lens/store', [ItemsLensController::class, 'store'])->name('item.lens.store');
    Route::get('/item/lens/edit/{id}', [ItemsLensController::class, 'edit'])->name('item.lens.edit');
    Route::put('/item/lens/update/{id}', [ItemsLensController::class, 'update'])->name('item.lens.update');
    Route::delete('/item/lens/delete/{id}', [ItemsLensController::class, 'delete'])->name('item.lens.delete');

    Route::get('/items/sun-glasses', [itemsController::class, 'index2'])->name('items.sunglasses.index');
    Route::get('/items/reading-glasses', [itemsController::class, 'index3'])->name('items.readingglasses.index');

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

    Route::get('/request-orders', [PurchaseCartController::class, 'index'])->name('purchase.order.index');
    Route::post('/order/add-cart', [PurchaseCartController::class, 'addCart'])->name('order.add-cart');
    Route::post('/order/lens/add-cart', [PurchaseCartController::class, 'addLensCart'])->name('order.lens.add-cart');
    Route::delete('/remove-cart/{id}', [PurchaseCartController::class, 'remove'])->name('order-cart.remove');
    Route::post('/accept-cart', [PurchaseCartController::class, 'accept'])->name('order.list.accept.all');
    Route::post('/draft-cart', [PurchaseCartController::class, 'draft'])->name('order.list.draft.all');
    Route::get('/all-draft-cart', [ConfirmOrdersController::class, 'draft'])->name('all-draft.list');



    Route::post('/order/add-cart/new-item', [PurchaseCartController::class, 'addCartNew'])->name('order.add-cart.new-item');


    // Purchase glasses routes to manage controllers
    Route::post('/purchase/glasses/store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/glasses/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::post('/purchase/glasses/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/glasses/delete/{id}', [PurchaseController::class, 'delete'])->name('purchase.delete');



    Route::get('/request-orders-new-item', [PurchaseController::class, 'requestNew'])->name('requests-new-item');


    // Pending order details
    Route::get('/pending-order-details', [ConfirmOrdersController::class, 'details'])->name('pending.order.details');
    Route::delete('/remove-order-detail/{id}', [ConfirmOrdersController::class, 'delete'])->name('delete.order.detail');

    Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');
    Route::post('/seller/store', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/seller/edit/{id}', [SellerController::class, 'edit'])->name('seller.edit');
    Route::put('/seller/update/{id}', [SellerController::class, 'update'])->name('seller.update');
    Route::delete('/seller/delete/{id}', [SellerController::class, 'delete'])->name('seller.delete');

    // Manage orders
    Route::get('/confirm-orders', [ConfirmOrdersController::class, 'accepted'])->name('confirm.orders');
    Route::post('/request/order/store', [ConfirmOrdersController::class, 'store'])->name('order.store');
    Route::post('/order/list/sent', [ConfirmOrdersController::class, 'send'])->name('order.list.send');
    Route::get('/single-order/list/{id}', [ConfirmOrdersController::class, 'singleOrder'])->name('single.order.list');
    Route::put('/single-order/confirm/{id}', [ConfirmOrdersController::class, 'confirm'])->name('single.order.confirm');
    Route::put('/single-order/reconfirm/{id}', [ConfirmOrdersController::class, 'reconfirm'])->name('single.order.reconfirm');

    Route::get('/stats-financial', [ConfirmOrdersController::class, 'financial'])->name('stats.financial');

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
    Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
    Route::post('/color/store', [ColorController::class, 'store'])->name('color.store');
    Route::get('/color/edit/{id}', [ColorController::class, 'edit'])->name('color.edit');
    Route::put('/color/update/{id}', [ColorController::class, 'update'])->name('color.update');
    Route::delete('/color/delete/{id}', [ColorController::class, 'delete'])->name('color.delete');

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

    // Financial Stats
    Route::get('/stats-financial', [ConfirmOrdersController::class, 'financial'])->name('stats.financial');

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

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice-by-sell-code/{id}', [InvoiceController::class, 'InvoivebySellCode'])->name('invoice-by-sell-code.index');

    // Customer routes to manage controllers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

    // Additional to sales controller

    Route::get('/glass-sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/fetch-codes', [SalesController::class, 'fetchCodes'])->name('fetch.codes');
    // Route::get('/seller/fetch/codes', 'SellerController@fetchCodes')->name('seller.fetch.codes');
    Route::get('/fetch-colors', [SalesController::class, 'fetchColors'])->name('fetch.colors');
    Route::post('/add-to-cart', [SalesController::class, 'addToCart'])->name('add.to.cart');
    Route::delete('/clear-cart', [SalesController::class, 'clearCart'])->name('clear.cart');
    Route::delete('/remove-from-cart/{id}', [SalesController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::delete('/remove-cart/{id}', [SalesController::class, 'remove'])->name('item-cart.remove');

    // Additional to lens sales controller

    // New Sales Updated controller

    Route::get('/make-sales', [MakeSalesController::class, 'index'])->name('make.sales.index');
    Route::post('/make-sales/store', [MakeSalesController::class, 'store'])->name('make.sale.store');

    Route::get('/lens-sales', [LensSalesController::class, 'index'])->name('lens.sales.index');
    Route::post('/lens-sales-store', [LensSalesController::class, 'store'])->name('cart.lens.store');
    Route::get('/lens-0781Ca/checkout/{id}', [LensSalesController::class, 'checkout'])->name('lens.checkout');
    Route::put('/update-lens/checkout/{id}', [LensSalesController::class, 'update'])->name('checkout.lens.update');
    Route::delete('/remove-lens-cart/{id}', [LensSalesController::class, 'remove'])->name('lens-cart.remove');

    Route::get('/invoice-0781Ca/checkout/{id}', [SalesController::class, 'checkout'])->name('checkout');
    Route::put('/update/checkout/{id}', [SalesController::class, 'update'])->name('checkout.update');

    Route::put('/update/performa/{id}', [SalesController::class, 'performa'])->name('performa.update');
    Route::put('/update/lens/performa/{id}', [LensSalesController::class, 'performa'])->name('performa.lens.update');

    Route::get('/glass/performa/invoices', [PerformaInvoices::class, 'glass'])->name('glass.performa.invoice');
    Route::get('/glass/performa/by-sell-code/{id}', [PerformaInvoices::class, 'GlassbySellCode'])->name('glass-by-sell-code.index');

    Route::get('/lens/performa/invoices', [PerformaInvoices::class, 'lens'])->name('lens.performa.invoice');
    Route::get('/lens/performa/by-sell-code/{id}', [PerformaInvoices::class, 'LensbySellCode'])->name('lens-by-sell-code.index');
});
