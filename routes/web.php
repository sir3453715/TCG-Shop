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
Route::get('/deckDetail/{deck_id}', 'HomeController@deckDetail')->name('deckDetail');
Route::get('/news', 'HomeController@news')->name('news');
Route::get('/newsPost/{post_id}', 'HomeController@newsPost')->name('newsPost');
Route::get('/competitions', 'HomeController@competitions')->name('competitions');
Route::get('/competitionsPost/{post_id}', 'HomeController@competitionsPost')->name('competitionsPost');
Route::get('/deckAddToCart/{deck_id}', 'HomeController@deckAddToCart')->name('deckAddToCart');
Route::get('/deckAddToAccount/{deck_id}', 'HomeController@deckAddToAccount')->name('deckAddToAccount');
Route::get('/build/{deck_id}', 'AccountController@build')->name('build');
Route::get('/search', 'HomeController@search')->name('search');

Route::get('/cart', 'OrderController@cart')->name('cart');
Route::get('/invoice/{seccode}', 'OrderController@invoice')->name('invoice');


Route::group(['prefix'=>'myAccount','as'=>'myAccount.'],function (){
    Route::get('/dashboard', 'AccountController@dashboard')->name('dashboard');
    Route::get('/myDeck', 'AccountController@myDeck')->name('myDeck');
    Route::get('/myDeckDetail/{deck_id}', 'AccountController@myDeckDetail')->name('myDeckDetail');
    Route::get('/order', 'AccountController@order')->name('order');
    Route::get('/wishlist', 'AccountController@wishlist')->name('wishlist');
    Route::get('/orderDetail/{order_id}', 'AccountController@orderDetail')->name('orderDetail');
    Route::get('/deckEdit/{deck_id}', 'AccountController@deckEdit')->name('deckEdit');

    Route::post('/editUser', 'AccountController@editUser')->name('editUser');
    Route::post('/editUser', 'AccountController@editUser')->name('editUser');
    Route::post('/deckImport', 'AccountController@deckImport')->name('deckImport');

    Route::delete('/deckDel/{deck_id}', 'AccountController@deckDel')->name('deckDel');
    Route::post('/deckSaveTitle/{deck_id}', 'AccountController@deckSaveTitle')->name('deckSaveTitle');
});


Route::post('/orderCreate','OrderController@orderCreate')->name('orderCreate');
Route::post('/cartSubmit','OrderController@cartSubmit')->name('cartSubmit');
Route::post('/deckCreate','OrderController@deckCreate')->name('deckCreate');
Route::post('/deckUpdate','OrderController@deckUpdate')->name('deckUpdate');

Auth::routes(['verify' => true]);


/** Social Login*/
Route::get('/login/oauth/{provider}/{redirectURL}', 'SocialiteController@redirectToOAuth')->name('SocialLogin');
Route::get('/login/callback/{provider}', 'SocialiteController@handleOAuthCallback')->name('SocialLoginCallBack');


/** Ajax*/
Route::post('/AddToCart','OrderController@AddToCart')->name('AddToCart');
Route::post('/CleanCart','OrderController@CleanCart')->name('CleanCart');
Route::post('/GetCardDataF','HomeController@GetCardDataF')->name('GetCardDataF');
Route::post('/AddToWishlist','AccountController@AddToWishlist')->name('AddToWishlist');
Route::post('/RemoveWishlist','AccountController@RemoveWishlist')->name('RemoveWishlist');


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
        Route::post('/changeRarity', 'Admin\Menu\CardsController@changeRarity')
            ->name('changeRarity');
    });
    Route::group(['prefix' => 'deck', 'as' => 'deck.'], function(){
        Route::get('/build/{deck}', 'Admin\Menu\DecksController@build')
            ->name('build');
    });

    Route::group(['prefix' => 'order', 'as' => 'order.'], function(){
        Route::post('createComment', 'Admin\Menu\OrdersController@createComment')
            ->name('createComment');// 新增訂單紀錄
    });
});



