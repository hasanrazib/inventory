<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\POS\SupplierController;
use App\Http\Controllers\POS\CustomerController;
use App\Http\Controllers\POS\UnitController;
use App\Http\Controllers\POS\CategoryController;
use App\Http\Controllers\POS\ProductController;
use App\Http\Controllers\POS\PurchaseController;
use App\Http\Controllers\POS\InvoiceController;
use App\Http\Controllers\POS\DefaultController;










Route::get('/', function () {
    return view('welcome');
});


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index')->name('about.page')->middleware('check');
    Route::get('/contact', 'ContactMethod')->name('cotact.page');
});


// Admin All Route 
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');
    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
     
});


// Supplier All Route 
Route::controller(SupplierController::class)->group(function () {
    Route::get('/supplier/add', 'addSupplier')->name('add.supplier');
    Route::post('/supplier/insert', 'insertSuplier')->name('insert.supplier');
    Route::get('/supplier/edit/{id}', 'editSupplier')->name('edit.supplier');
    Route::post('/supplier/update', 'updateSupplier')->name('update.supplier');
    Route::get('/supplier/delete/{id}', 'deleteSupplier')->name('delete.supplier');
    Route::get('/supplier/all', 'viewAllSupplier')->name('view.suppliers');
    
     
});
// Customer All Route 
Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer/add', 'addCustomer')->name('add.customer');
    Route::post('/customer/insert', 'insertCustomer')->name('insert.customer');
    Route::get('/customer/edit/{id}', 'editCustomer')->name('edit.customer');
    Route::post('/customer/update', 'updateCustomer')->name('update.customer');
    Route::get('/customer/delete/{id}', 'deleteCustomer')->name('delete.customer');
    Route::get('/customer/all', 'viewAllCustomer')->name('view.customers');
    
     
});

// Unit All Route 
Route::controller(UnitController::class)->group(function () {
    Route::get('/unit/add', 'addUnit')->name('add.unit');
    Route::post('/unit/insert', 'insertUnit')->name('insert.unit');
    Route::get('/unit/edit/{id}','editUnit')->name('edit.unit');
    Route::post('/unit/update/','updateUnit')->name('update.unit');
    Route::get('/unit/delete/{id}','deleteUnit')->name('delete.unit');
    Route::get('/unit/all', 'viewAllUnit')->name('view.units');
   
    
     
});

// Category All Route 
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/add', 'addCategory')->name('add.category');
    Route::post('/category/insert', 'insertCategory')->name('insert.category');
    Route::get('/category/edit/{id}','editCategory')->name('edit.category');
    Route::post('/category/update/','updateCategory')->name('update.category');
    Route::get('/category/delete/{id}','deleteCategory')->name('delete.category');
    Route::get('/category/all', 'viewAllCategory')->name('view.categories');
   
    
     
});

// Product All Route 
Route::controller(ProductController::class)->group(function () {
    Route::get('/product/add', 'addProduct')->name('add.product');
    Route::post('/product/insert', 'insertProduct')->name('insert.product');
    Route::get('/product/edit/{id}','editProduct')->name('edit.product');
    Route::post('/product/update/','updateProduct')->name('update.product');
    Route::get('/product/delete/{id}','deleteProduct')->name('delete.product');
    Route::get('/product/all', 'viewAllProduct')->name('view.products');
   
   
    
     
});


// Purchase All Controller
Route::controller(PurchaseController::class)->group(function () {
    Route::get('/purchases/add', 'addPurchase')->name('add.purchase');
    Route::post('/purchases/insert', 'insertPurchase')->name('insert.purchase');
    Route::get('/purchases/delete/{id}','deletePurchase')->name('delete.purchase');
    Route::get('/purchases/pending','pendingPurchase')->name('pending.purchase');
    Route::get('/purchase/approve/{id}', 'approvePurchase')->name('approve.purchase');
    Route::get('/purchases/all', 'viewAllPurchases')->name('view.purchases');
    
   

});

// Invoice All Controller
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoice/add', 'addInvoice')->name('add.invoice');
    Route::post('/invoice/insert', 'insertInvoice')->name('insert.invoice');
    Route::get('/invoice/all', 'viewAllInvoice')->name('view.invoices');
    
    

});




// Default Controller
Route::controller(DefaultController::class)->group(function () {
    Route::get('/get-category', 'getCategory')->name('get-category');
    Route::get('/get-product', 'getProduct')->name('get-product');
    Route::get('/get-stock', 'getStock')->name('get-check-stock');
   
   
    
     
});



Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });
