<?php

use Illuminate\Http\Request;


Route::post('getRegions',           'index@index');
Route::post('register',             'index@index');
Route::post('validateCode',         'index@index');
Route::post('login',                'index@index');
Route::post('forgetPassword',       'index@index');
Route::post('changePassword',       'index@index');
Route::post('updatePassword',       'index@index');
Route::post('getProfile',           'index@index');
Route::post('resendCode',           'index@index');
Route::post('changeLang',           'index@index');
Route::post('updateFireBaseToken',  'index@index');
Route::post('logout',               'index@index');
Route::post('appInfo',              'index@index');
Route::post('contacts',             'index@index');
Route::post('unseenNotifications',  'index@index');
Route::post('notifications',        'index@index');
Route::post('getOrders',            'index@index');
Route::post('getServices',          'index@index');
Route::post('getAds',               'index@index');
Route::post('sendMessages',         'index@index');
Route::post('getMessages',          'index@index');
Route::post('updateUserProfile',    'index@index');
Route::post('addOrder',             'index@index');
Route::post('addFavourite',         'index@index');
Route::post('rateStore',            'index@index');
Route::post('myFavourites',         'index@index');

Route::post('developer',            'index@index');

route::post('getSliders','index@index');
route::post('getCategories','index@index');
route::post('getProducts','index@index');
route::post('getOffers','index@index');
route::post('validate','index@index');
route::post('updateProfile','index@index');
route::post('addToCart','index@index');
route::post('deleteCart','index@index');
route::post('makeOrder','index@index');
route::post('getOffers','index@index');
route::post('getTimeOfDelivery','index@index');
route::post('getCart','index@index');
route::post('countCart','index@index');
route::post('getNotifications','index@index');
route::post('getInfo','index@index');
route::post('updateCart','index@index');
route::post('getOrderInfo','index@index');