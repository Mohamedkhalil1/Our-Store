<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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



Route::group(['namespace' =>'Admin','middleware' => 'auth:admin'], function () {
    ###########################################################################
    /* Languages Routes */
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/','LanguagesController@index')->name('admin.languages');
        Route::get('/create','LanguagesController@create')->name('admin.languages.create');
        Route::post('/','LanguagesController@store')->name('admin.languages.store');
        Route::get('edit/{id}','LanguagesController@edit')->name('admin.languages.edit');
        Route::post('update/{id}','LanguagesController@update')->name('admin.languages.update');
        Route::get('delete/{id}','LanguagesController@destory')->name('admin.languages.destory');
    });
    /* end languages Routes */


    ###########################################################################
    /* Main Categories Routes */
    Route::group(['prefix' => 'main_categories'], function () {
       
    });
    /* end Main Categories Routes */

     ###########################################################################
    /* Main Vendors Routes */
    Route::group(['prefix' => 'vendors'], function () {
        Route::get('/','VendorsController@index')->name('admin.vendors');
        Route::get('/create','VendorsController@create')->name('admin.vendors.create');
        Route::post('/','VendorsController@store')->name('admin.vendors.store');
        Route::get('edit/{id}','VendorsController@edit')->name('admin.vendors.edit');
        Route::post('update/{id}','VendorsController@update')->name('admin.vendors.update');
        Route::get('delete/{id}','VendorsController@destory')->name('admin.vendors.destory');
        Route::get('changeStatus/{id}','VendorsController@changeStatus')->name('admin.vendors.status');
    });
    /* end Vendors Routes */

    ###############################################################################
   
});



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        
    Route::group(['namespace' =>'Admin','prefix' =>'admin'], function () {
        Route::get('/login','LoginController@getLogin')->name('get.admin.login');
        Route::post('/login','LoginController@Login')->name('admin.login');
        Route::get('/logout','LoginController@Logout')->name('admin.logout');
    });


    Route::group(['namespace' =>'Admin','middleware' => 'auth:admin','prefix' =>'admin'], function () {
            Route::get('/', 'DashboardController@index')->name('admin.dashboard');

            ## Shipping Routes 
            Route::group(['prefix' => 'settings'], function () {
                Route::get('shipping-methods/{type}','SettingsController@editShippingMethod')->name('edit.shipping.methods');
                Route::post('shipping-methods/{id}','SettingsController@updateShippingMethod')->name('update.shipping.methods');
            });
            ## end Shipping Routes 

            ## Profile Routes 
            Route::group(['prefix' => 'profile'], function () {
                Route::get('edit','ProfileController@editProfile')->name('edit.profile');
                Route::put('update','ProfileController@updateProfile')->name('update.profile');
            });
            ## end Profile Routes 

             ## Categories Routes 
             Route::group(['prefix' => 'categories'], function () {
                Route::get('/{type}','MainCategoriesController@index')->name('admin.maincategories');
                Route::get('create/{type}','MainCategoriesController@create')->name('admin.maincategories.create');
                Route::post('store','MainCategoriesController@store')->name('admin.maincategories.store');
                Route::get('show/{id}/{type}','MainCategoriesController@show')->name('admin.maincategories.show');
                Route::get('edit/{id}/{type}','MainCategoriesController@edit')->name('admin.maincategories.edit');
                Route::post('update/{id}','MainCategoriesController@update')->name('admin.maincategories.update');
                Route::get('delete/{id}','MainCategoriesController@destroy')->name('admin.maincategories.delete');
            });
            ## end Categories Routes 

            ## Brands Routes 
              Route::group(['prefix' => 'brands'], function () {
                Route::get('/','BrandController@index')->name('admin.brands');
                Route::get('create/','BrandController@create')->name('admin.brands.create');
                Route::post('store','BrandController@store')->name('admin.brands.store');
                Route::get('show/{id}/','BrandController@show')->name('admin.brands.show');
                Route::get('edit/{id}/','BrandController@edit')->name('admin.brands.edit');
                Route::post('update/{id}','BrandController@update')->name('admin.brands.update');
                Route::get('delete/{id}','BrandController@destroy')->name('admin.brands.delete');
            });
            ## end Brands Routes 

            

        });
       
        
   
        
});


