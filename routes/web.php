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

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/card', 'HomeController@card')->name('card');
Route::get('/deck', 'HomeController@deck')->name('deck');
Route::get('/news', 'HomeController@news')->name('news');
Route::get('/newsPost', 'HomeController@newsPost')->name('newsPost');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/myDeck', 'HomeController@myDeck')->name('myDeck');
Route::get('/myDeckDetail', 'HomeController@myDeckDetail')->name('myDeckDetail');
Route::get('/order', 'HomeController@order')->name('order');


Route::post('/orderCreate','HomeController@orderCreate')->name('orderCreate');

Auth::routes(['verify' => true]);


/** Social Login*/
Route::get('/login/oauth/{provider}/{redirectURL}', 'SocialiteController@redirectToOAuth')->name('SocialLogin');
Route::get('/login/callback/{provider}', 'SocialiteController@handleOAuthCallback')->name('SocialLoginCallBack');

/** Ajax*/
//Route::post('/ChangeDeckCard','Admin\Menu\DecksController@ChangeDeckCard')->name('ChangeDeckCard');
//Route::post('/CleanDeck','Admin\Menu\DecksController@CleanDeck')->name('CleanDeck');
//Route::post('/addToDeck','HomeController@addToDeck')->name('addToDeck');


/** Admin Ajax*/
Route::post('/ChangeDeckCard','Admin\Menu\DecksController@ChangeDeckCard')->name('ChangeDeckCard');
Route::post('/CleanDeck','Admin\Menu\DecksController@CleanDeck')->name('CleanDeck');
Route::post('/GetCardData','Admin\Menu\DecksController@GetCardData')->name('GetCardData');
Route::post('/checkCardLimit','Admin\Menu\DecksController@checkCardLimit')->name('checkCardLimit');
Route::post('/searchUser','Admin\Menu\UsersController@searchUser')->name('searchUser');
Route::post('/getUser','Admin\Menu\UsersController@getUser')->name('getUser');
Route::post('/searchCard','Admin\Menu\CardsController@searchCard')->name('searchCard');
Route::post('/GetProductCard','Admin\Menu\ProductsController@GetProductCard')->name('GetProductCard');
Route::post('/GetItemCard','Admin\Menu\OrdersController@GetItemCard')->name('GetItemCard');
Route::post('/ImportCodeCard','Admin\Menu\OrdersController@ImportCodeCard')->name('ImportCodeCard');
Route::post('/addOrderItem','Admin\Menu\OrdersController@addOrderItem')->name('addOrderItem');
Route::post('/inviteStaff','Admin\Menu\VendorsController@inviteStaff')->name('inviteStaff');
Route::post('/deleteStaff','Admin\Menu\VendorsController@deleteStaff')->name('deleteStaff');


/**
 * 後台 Route
 */
Route::get('admin-login','Admin\AdminController@loginPage')->name('admin-login');//後台登入頁
Route::get('/verifiedMail/{id}/{hash}','Admin\Menu\UsersController@verifiedMail')->name('verifiedMail');//信箱驗證
Route::get('/staffRegister/{id}/{hash}','Admin\Menu\UsersController@staffRegister')->name('staffRegister');//店員註冊驗證
Route::post('staffRegisterAction', 'Admin\Menu\UsersController@staffRegisterAction')->name('staffRegisterAction');//店員註冊動作


Route::group(['prefix'=>'admin', 'middleware' => ['web', 'admin.area'],'as'=>'admin.'],function (){
    /** 首頁*/
    Route::get('/','Admin\AdminController@index')->name('index');
    /**
     * 快取清除
     */
    Route::get('/clear-cache', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return redirect()->back()->with('message', '快取已清除!');
    })->name('clear-cache');


    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('/resendConfirm/{user}', 'Admin\Menu\UsersController@resendConfirm')
            ->name('resendConfirm');
    });


    Route::group(['prefix' => 'card', 'as' => 'card.'], function(){
        Route::get('/reinstall', 'Admin\Menu\CardsController@reinstall')
            ->name('reinstall');
        Route::post('/rarity', 'Admin\Menu\CardsController@rarity')
            ->name('rarity');
    });
    Route::group(['prefix' => 'deck', 'as' => 'deck.'], function(){
        Route::get('/build/{deck}', 'Admin\Menu\DecksController@build')
            ->name('build');
    });

});



