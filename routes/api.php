<?php

use Illuminate\Http\Request;


Route::ANY('getRegions',           'index@index');
Route::ANY('register',             'index@index');
Route::ANY('validateCode',         'index@index');
Route::ANY('login',                'index@index');
Route::ANY('forgetPassword',       'index@index');
Route::ANY('changePassword',       'index@index');
Route::ANY('updatePassword',       'index@index');
Route::ANY('getProfile',           'index@index');
Route::ANY('resendCode',           'index@index');
Route::ANY('changeLang',           'index@index');
Route::ANY('updateFireBaseToken',  'index@index');
Route::ANY('logout',               'index@index');
Route::ANY('appInfo',              'index@index');
Route::ANY('contacts',             'index@index');
Route::ANY('unseenNotifications',  'index@index');
Route::ANY('notifications',        'index@index');
Route::ANY('getOrders',            'index@index');
Route::ANY('getServices',          'index@index');
Route::ANY('getAds',               'index@index');
Route::ANY('sendMessages',         'index@index');
Route::ANY('getMessages',          'index@index');
Route::ANY('updateUserProfile',    'index@index');
Route::ANY('addOrder',             'index@index');
Route::ANY('addFavourite',         'index@index');
Route::ANY('rateStore',            'index@index');
Route::ANY('myFavourites',         'index@index');

Route::ANY('developer',            'index@index');

route::ANY('getSliders','index@index');
route::ANY('getCategories','index@index');
route::ANY('getProducts','index@index');
route::ANY('getOffers','index@index');
route::ANY('validate','index@index');
route::ANY('updateProfile','index@index');
route::ANY('addToCart','index@index');
route::ANY('deleteCart','index@index');
route::ANY('makeOrder','index@index');
route::ANY('getOffers','index@index');
route::ANY('getTimeOfDelivery','index@index');
route::ANY('getCart','index@index');
route::ANY('countCart','index@index');
route::ANY('getNotifications','index@index');
route::ANY('getInfo','index@index');
route::ANY('updateCart','index@index');
route::ANY('getOrderInfo','index@index');
route::post('getVouchers','index@index');
route::post('visitors','index@index');
route::post('contactUs','index@index');