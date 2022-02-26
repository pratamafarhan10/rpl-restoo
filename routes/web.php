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

require __DIR__ . '/auth.php';

Route::get('/', 'HomeController@redirectLogin');

Route::post('/payments/notification', 'PaymentController@notification');
Route::get('/payments/completed', 'PaymentController@completed');
Route::get('/payments/failed', 'PaymentController@failed');
Route::get('/payments/unfinish', 'PaymentController@unfinish');
Route::get('/paymentsPage/{order_code}', 'PaymentController@paymentPage')->name('payment.page');

Route::middleware('auth')->group(function () {

    Route::middleware(['role:manajer'])->group(function () {

        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->name('home');

        // Home
        Route::prefix('dashboard')->group(function () {
            Route::get('/', 'HomeController@rekapitulasiHarian')->name('home');
            Route::get('/{food:id}', 'HomeController@rekapitulasiPerMenu')->name('home.menu');
        });

        // Menu
        Route::prefix('menu')->group(function () {
            Route::get('/', 'FoodController@index')->name('food.index');
            Route::get('/create', 'FoodController@create')->name('food.create');
            Route::post('/create/store', 'FoodController@store')->name('food.store');
            Route::get('/{food:id}/edit', 'FoodController@edit')->name('food.edit');
            Route::patch('/{food:id}/edit/update', 'FoodController@update')->name('food.update');
            Route::delete('/{food:id}/delete', 'FoodController@destroy')->name('food.destroy');
            Route::get('/search', 'FoodController@search')->name('food.search');
            Route::get('/{category}', 'FoodController@filter')->name('food.filter');
        });

        // Seat
        Route::prefix('seat')->group(function () {
            Route::get('/', 'TableController@index')->name('table.index');
            Route::post('/create/store', 'TableController@store')->name('table.store');
            Route::get('/{table:id}/edit', 'TableController@edit')->name('table.edit');
            Route::patch('/{table:id}/edit/update', 'TableController@update')->name('table.update');
            Route::delete('/{table:id}/delete', 'TableController@destroy')->name('table.destroy');
        });

        // User
        Route::prefix('user')->group(function () {
            Route::get('/', 'UserController@index')->name('user.index');
            Route::get('/create', 'UserController@create')->name('user.create');
            Route::post('/create/store', 'UserController@store')->name('user.store');
            Route::get('/{user:id}/edit', 'UserController@edit')->name('user.edit');
            Route::patch('/{user:id}/edit/update', 'UserController@update')->name('user.update');
            Route::delete('/{user:id}/delete', 'UserController@destroy')->name('user.destroy');

        });

        // Category
        Route::prefix('category')->group(function () {
            Route::get('/', 'CategoryController@index')->name('category.index');
            Route::post('/create/store', 'CategoryController@store')->name('category.store');
            Route::get('/{category:id}/edit', 'CategoryController@edit')->name('category.edit');
            Route::patch('/{category:id}/edit/update', 'CategoryController@update')->name('category.update');
            Route::delete('/{category:id}/delete', 'CategoryController@destroy')->name('category.destroy');
        });
    });

    Route::middleware(['role:tempat duduk'])->group(function () {

        // Order
        Route::prefix('pemesanan')->group(function () {
            Route::get('/', 'OrderController@index')->name('order.index');
            Route::get('/create', 'OrderController@create')->name('order.create');
            Route::post('/create/store', 'OrderController@store')->name('order.store');
            Route::get('/create/search', 'SearchController@search')->name('order.search');
            Route::get('/create/{category}', 'SearchController@filter')->name('order.filter');
        });
        // Update Pesanan
        Route::prefix('updatepesanan')->group(function () {
            Route::get('/', 'OrderController@edit')->name('order.edit');
            Route::patch('/update', 'OrderController@update')->name('order.update');
            Route::patch('/payment', 'OrderController@payment')->name('order.payment');
        });
    });

    Route::middleware(['role:waiter'])->group(function () {

        // Waiter seat
        Route::prefix('waiter')->group(function () {
            Route::get('/', 'TableController@waiterIndex')->name('waiter.index');
            Route::get('/{table:id}/create', 'TableController@waiterCreate')->name('waiter.create');
            Route::post('/{table:id}/create/store', 'TableController@waiterStore')->name('waiter.store');
        });
    });

    Route::middleware(['role:kasir'])->group(function () {

        // Pembayaran
        Route::prefix('pembayaran')->group(function () {
            Route::get('/', 'PaymentController@index')->name('payment.index');
            Route::patch('/cashPayment/{order:order_code}', 'PaymentController@cash')->name('payment.cash');
            Route::get('/search', 'PaymentController@searchPayment')->name('payment.search');
        });
        Route::prefix('history')->group(function () {
            Route::get('/', 'PaymentController@historyIndex')->name('history.index');
            Route::get('/search', 'PaymentController@searchHistory')->name('history.search');
        });
    });

    Route::middleware(['role:dapur'])->group(function () {

        // Dapur
        Route::prefix('dapur')->group(function () {
            Route::get('/', 'TableController@dapurIndex')->name('dapur.index');
        });

    });

    Route::get('/logout', 'Auth\AuthenticatedSessionController@destroy')->name('logout');
});
