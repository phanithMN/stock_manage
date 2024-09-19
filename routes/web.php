<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// auth 
Auth::routes();
Route::get('/', [App\Http\Controllers\AuthController::class, 'SignIn'])->name('sign-in');

// home 
Route::get('/dashboad', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboad');

// product
Route::get('/product', [App\Http\Controllers\ProductController::class, 'Product'])->name('product');
Route::get('/insert-product', [App\Http\Controllers\ProductController::class, 'Insert'])->name('insert-product');
Route::post('/insert-data-product', [App\Http\Controllers\ProductController::class, 'InsertData'])->name('insert-data-product');
Route::get('/edit-product/{id}', [App\Http\Controllers\ProductController::class, 'Update'])->name('update-product');
Route::put('/edit-data-product/{id}', [App\Http\Controllers\ProductController::class, 'DataUpdate'])->name('edit-data-product');
Route::get('/delete-product/{id}', [App\Http\Controllers\ProductController::class, 'Delete'])->name('delete-product');
// category
Route::get('/category', [App\Http\Controllers\CategoryController::class, 'Category'])->name('category');
Route::get('/insert-category', [App\Http\Controllers\CategoryController::class, 'Insert'])->name('insert-category');
Route::post('/insert-data-category', [App\Http\Controllers\CategoryController::class, 'InsertData'])->name('insert-data-category');
Route::get('/edit-category/{id}', [App\Http\Controllers\CategoryController::class, 'Update'])->name('update-category');
Route::put('/edit-data-category/{id}', [App\Http\Controllers\CategoryController::class, 'DataUpdate'])->name('edit-data-category');
Route::get('/delete-category/{id}', [App\Http\Controllers\CategoryController::class, 'Delete'])->name('delete-category');
// role
Route::get('/role', [App\Http\Controllers\RoleController::class, 'Role'])->name('role');
Route::get('/insert-role', [App\Http\Controllers\RoleController::class, 'Insert'])->name('insert-role');
Route::post('/insert-data-role', [App\Http\Controllers\RoleController::class, 'InsertData'])->name('insert-data-role');
Route::get('/edit-role/{id}', [App\Http\Controllers\RoleController::class, 'Update'])->name('update-role');
Route::put('/edit-data-role/{id}', [App\Http\Controllers\RoleController::class, 'DataUpdate'])->name('edit-data-role');
Route::get('/delete-role/{id}', [App\Http\Controllers\RoleController::class, 'Delete'])->name('delete-role');
// permission
Route::get('/permission', [App\Http\Controllers\PermissionController::class, 'Permission'])->name('permission');
Route::get('/insert-permission', [App\Http\Controllers\PermissionController::class, 'Insert'])->name('insert-permission');
Route::post('/insert-data-permission', [App\Http\Controllers\PermissionController::class, 'InsertData'])->name('insert-data-permission');
Route::get('/edit-permission/{id}', [App\Http\Controllers\PermissionController::class, 'Update'])->name('update-permission');
Route::put('/edit-data-permission/{id}', [App\Http\Controllers\PermissionController::class, 'DataUpdate'])->name('edit-data-permission');
Route::get('/delete-permission/{id}', [App\Http\Controllers\PermissionController::class, 'Delete'])->name('delete-permission');
// stock
Route::get('/stock', [App\Http\Controllers\StockController::class, 'Stock'])->name('stock');
Route::get('/insert-stock', [App\Http\Controllers\StockController::class, 'Insert'])->name('insert-stock');
Route::post('/insert-data-stock', [App\Http\Controllers\StockController::class, 'InsertData'])->name('insert-data-stock');
Route::get('/edit-stock/{id}', [App\Http\Controllers\StockController::class, 'Update'])->name('update-stock');
Route::put('/edit-data-stock/{id}', [App\Http\Controllers\StockController::class, 'DataUpdate'])->name('edit-data-stock');
Route::get('/delete-stock/{id}', [App\Http\Controllers\StockController::class, 'Delete'])->name('delete-stock');
Route::get('/item-details/{id}', [App\Http\Controllers\StockController::class, 'getItemDetails']);
// user
Route::get('/user', [App\Http\Controllers\UserController::class, 'User'])->name('user');
Route::get('/insert-user', [App\Http\Controllers\UserController::class, 'Insert'])->name('insert-user');
Route::post('/insert-data-user', [App\Http\Controllers\UserController::class, 'InsertData'])->name('insert-data-user');
Route::get('/edit-user/{id}', [App\Http\Controllers\UserController::class, 'Update'])->name('update-user');
Route::put('/edit-data-user/{id}', [App\Http\Controllers\UserController::class, 'DataUpdate'])->name('edit-data-user');
Route::get('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'Delete'])->name('delete-user');
// unit-of-measure
Route::get('/unit-of-measure', [App\Http\Controllers\UnitOfMeasureController::class, 'UnitOfMeasure'])->name('unit-of-measure');
Route::get('/insert-unit-of-measure', [App\Http\Controllers\UnitOfMeasureController::class, 'Insert'])->name('insert-unit-of-measure');
Route::post('/insert-data-unit-of-measure', [App\Http\Controllers\UnitOfMeasureController::class, 'InsertData'])->name('insert-data-unit-of-measure');
Route::get('/edit-unit-of-measure/{id}', [App\Http\Controllers\UnitOfMeasureController::class, 'Update'])->name('update-unit-of-measure');
Route::put('/edit-data-unit-of-measure/{id}', [App\Http\Controllers\UnitOfMeasureController::class, 'DataUpdate'])->name('edit-data-unit-of-measure');
Route::get('/delete-unit-of-measure/{id}', [App\Http\Controllers\UnitOfMeasureController::class, 'Delete'])->name('delete-unit-of-measure');
// status
Route::get('/status', [App\Http\Controllers\StatusController::class, 'Status'])->name('status');
Route::get('/insert-status', [App\Http\Controllers\StatusController::class, 'Insert'])->name('insert-status');
Route::post('/insert-data-status', [App\Http\Controllers\StatusController::class, 'InsertData'])->name('insert-data-status');
Route::get('/edit-status/{id}', [App\Http\Controllers\StatusController::class, 'Update'])->name('update-status');
Route::put('/edit-data-status/{id}', [App\Http\Controllers\StatusController::class, 'DataUpdate'])->name('edit-data-status');
Route::get('/delete-status/{id}', [App\Http\Controllers\StatusController::class, 'Delete'])->name('delete-status');
// report stock
Route::get('/report-stock', [App\Http\Controllers\ReportStockController::class, 'ReportStock'])->name('report-stock');
Route::get('/export-stock', [App\Http\Controllers\ReportStockController::class, 'ExportCSV'])->name('export-stock');
// report product 
Route::get('/report-product', [App\Http\Controllers\ReportProductController::class, 'ReportProduct'])->name('report-product');
Route::get('/export-product', [App\Http\Controllers\ReportProductController::class, 'ExportCSV'])->name('export-product');
//setting
Route::get('/account-setting', [App\Http\Controllers\AccountSettingController::class, 'AccountSetting'])->name('account-setting');
Route::post('/insert-data', [App\Http\Controllers\AccountSettingController::class, 'DataInsert'])->name('insert-data');
Route::put('/edit-data-account-setting/{id}', [App\Http\Controllers\AccountSettingController::class, 'DataUpdateAccountSetting'])->name('edit-data-account-setting');
Route::get('/clear-user-info/{id}', [App\Http\Controllers\AccountSettingController::class, 'ClearUserInfo'])->name('clear-user-info');
