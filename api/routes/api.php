<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {
// Authentication api router
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::get('me', 'AuthController@me');
});
Route::group([
    'middleware' => 'auth',
    'prefix' => 'v1'
], function ($router) {
    // brand api router
Route::get('brand-data', 'API\BrandController@data');
Route::post('brand-store', 'API\BrandController@store');
Route::get('brand-edit/{id}', 'API\BrandController@edit');
Route::post('brand-update', 'API\BrandController@update');
Route::get('brand-delete/{id}', 'API\BrandController@SoftDelete');
Route::get('category-data-brand', 'API\BrandController@category');
Route::get('subcategory-data-brand', 'API\BrandController@subcategory');
Route::get('brand-find-subcategory/{id}', 'API\BrandController@Findsubcategory');
    // category api router
Route::get('category-data', 'API\CategoryController@data');
Route::post('category-store', 'API\CategoryController@store');
Route::get('category-edit/{id}', 'API\CategoryController@edit');
Route::post('category-update', 'API\CategoryController@update');
Route::get('category-delete/{id}', 'API\CategoryController@SoftDelete');
    //sub category api router
Route::get('sub-category-data', 'API\SubCategoryController@data');
Route::get('category-data-sub', 'API\SubCategoryController@category');
Route::post('sub-category-store', 'API\SubCategoryController@store');
Route::get('sub-category-edit/{id}', 'API\SubCategoryController@edit');
Route::post('sub-category-update', 'API\SubCategoryController@update');
Route::get('sub-category-delete/{id}', 'API\SubCategoryController@SoftDelete');
    // customer api router
Route::get('customer-data', 'API\CustomerController@data');
Route::post('customer-store', 'API\CustomerController@store');
Route::get('customer-edit/{id}', 'API\CustomerController@edit');
Route::post('customer-update', 'API\CustomerController@update');
Route::post('customer-search', 'API\CustomerController@search');
Route::get('customer-delete/{id}', 'API\CustomerController@SoftDelete');
    // suplier api router
Route::get('suplier-data', 'API\SuplierController@data');
Route::post('suplier-store', 'API\SuplierController@store');
Route::get('suplier-edit/{id}', 'API\SuplierController@edit');
Route::post('suplier-update', 'API\SuplierController@update');
Route::get('suplier-delete/{id}', 'API\SuplierController@SoftDelete');
    // invoice api router
Route::get('invoice-data', 'API\InvoiceController@data');
Route::get('invoice-customer-data', 'API\InvoiceController@Customers');
Route::get('invoice-stock-data', 'API\InvoiceController@Stock');
Route::get('find-product-data/{id}', 'API\InvoiceController@FindProduct');
Route::post('invoice-store', 'API\InvoiceController@store');
Route::get('invoice-edit/{id}', 'API\InvoiceController@edit');
Route::post('invoice-update', 'API\InvoiceController@update');
Route::get('invoice-delete/{id}', 'API\InvoiceController@SoftDelete');
// settings api router
Route::get('settings-data', 'API\SettingsController@data');
Route::post('settings-store', 'API\SettingsController@store');
Route::get('settings-edit/{id}', 'API\SettingsController@edit');
Route::post('settings-update', 'API\SettingsController@update');
Route::get('settings-delete/{id}', 'API\SettingsController@SoftDelete');
// User api router
Route::get('role-data', 'API\UserController@role');
Route::get('user-data', 'API\UserController@data');
Route::post('user-store', 'API\UserController@store');
Route::get('user-edit/{id}', 'API\UserController@edit');
Route::post('user-update', 'API\UserController@update');
Route::get('user-delete/{id}', 'API\UserController@SoftDelete');
// Profile api router
Route::get('profile-data', 'API\ProfileController@data');
Route::post('profile-update', 'API\ProfileController@update');
Route::post('profile-password-update', 'API\ProfileController@ProfilePasswordUpdate');

// Product api router
Route::get('product-data', 'API\ProductController@data');
Route::get('suplier-product-data', 'API\ProductController@suplier');
Route::get('product-brand-data', 'API\ProductController@Branddata');
Route::post('product-store', 'API\ProductController@store');
Route::get('product-edit/{id}', 'API\ProductController@edit');
Route::post('product-update', 'API\ProductController@update');
Route::get('product-delete/{id}', 'API\ProductController@SoftDelete');
Route::get('product-find-brand/{id}', 'API\ProductController@FindBrand');
// Stock api router
Route::get('stock-data', 'API\StockController@data');
Route::post('stock-store', 'API\StockController@store');
Route::get('stock-edit/{id}', 'API\StockController@edit');
Route::get('stock-delete/{id}', 'API\StockController@SoftDelete');
Route::post('stock-update', 'API\StockController@update');
});