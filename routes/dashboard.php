<?php
use Illuminate\Support\Arr;

route::get('test',function(){
       return \App\Models\users::find(10);
});
route::post('/login','authentication@login')->name('dashboard.login');
route::get('/login','authentication@index')->name('dashboard.login.index');
route::get('/logout','authentication@logout')->name('dashboard.logout');

Route::group(['middleware' => ['dashboard']], function () 
{
       route::get('statistics','statistics@index')->name('dashboard.statistics.index');
       route::post('statistics/getByDateRange','statistics@getByDateRange')->name('dashboard.statistics.getByDateRange');
       route::post('statistics','statistics@indexPageing')->name('dashboard.statistics.indexPageing');

       route::get('users','users@index')->name('dashboard.users.index');
       route::post('users/createUpdate','users@createUpdate')->name('dashboard.users.createUpdate');
       route::post('users','users@indexPageing')->name('dashboard.users.indexPageing');
       route::get('users/delete/{id}','users@delete')->name('dashboard.users.delete');
       route::get('users/check/{check}/{id}','users@check')->name('dashboard.users.check');
       route::get('users/getRecord/{id}','users@getRecord')->name('dashboard.users.getRecord');

       route::get('notifications','notifications@index')->name('dashboard.notifications.index');
       route::post('notifications/createUpdate','notifications@createUpdate')->name('dashboard.notifications.createUpdate');
       route::post('notifications','notifications@indexPageing')->name('dashboard.notifications.indexPageing');
       route::get('notifications/delete/{id}','notifications@delete')->name('dashboard.notifications.delete');
       route::get('notifications/check/{type}/{id}','notifications@check')->name('dashboard.notifications.check');
       route::get('notifications/getRecord/{id}','notifications@getRecord')->name('dashboard.notifications.getRecord');

       route::get('contacts','contacts@index')->name('dashboard.contacts.index');
       route::post('contacts/createUpdate','contacts@createUpdate')->name('dashboard.contacts.createUpdate');
       route::post('contacts','contacts@indexPageing')->name('dashboard.contacts.indexPageing');
       route::get('contacts/delete/{id}','contacts@delete')->name('dashboard.contacts.delete');
       route::get('contacts/check/{check}/{id}','contacts@check')->name('dashboard.contacts.check');
       route::get('contacts/getRecord/{id}','contacts@getRecord')->name('dashboard.contacts.getRecord');

       route::get('categories','categories@index')->name('dashboard.categories.index');
       route::post('categories/createUpdate','categories@createUpdate')->name('dashboard.categories.createUpdate');
       route::post('categories','categories@indexPageing')->name('dashboard.categories.indexPageing');
       route::get('categories/delete/{id}','categories@delete')->name('dashboard.categories.delete');
       route::get('categories/check/{check}/{id}','categories@check')->name('dashboard.categories.check');
       route::get('categories/getRecord/{id}','categories@getRecord')->name('dashboard.categories.getRecord');

       route::get('regions','regions@index')->name('dashboard.regions.index');
       route::post('regions/createUpdate','regions@createUpdate')->name('dashboard.regions.createUpdate');
       route::post('regions','regions@indexPageing')->name('dashboard.regions.indexPageing');
       route::get('regions/delete/{id}','regions@delete')->name('dashboard.regions.delete');
       route::get('regions/check/{type}/{id}','regions@check')->name('dashboard.regions.check');
       route::get('regions/getRecord/{id}','regions@getRecord')->name('dashboard.regions.getRecord');

       route::get('ads','ads@index')->name('dashboard.ads.index');
       route::post('ads/createUpdate','ads@createUpdate')->name('dashboard.ads.createUpdate');
       route::post('ads','ads@indexPageing')->name('dashboard.ads.indexPageing');
       route::get('ads/delete/{id}','ads@delete')->name('dashboard.ads.delete');
       route::get('ads/check/{type}/{id}','ads@check')->name('dashboard.ads.check');
       route::get('ads/getRecord/{id}','ads@getRecord')->name('dashboard.ads.getRecord');

       route::get('orders','orders@index')->name('dashboard.orders.index');
       route::post('orders/createUpdate','orders@createUpdate')->name('dashboard.orders.createUpdate');
       route::post('orders','orders@indexPageing')->name('dashboard.orders.indexPageing');
       route::get('orders/delete/{id}','orders@delete')->name('dashboard.orders.delete');
       route::get('orders/check/{check}/{id}','orders@check')->name('dashboard.orders.check');
       route::get('orders/getRecord/{id}','orders@getRecord')->name('dashboard.orders.getRecord');

       route::get('admins','admins@index')->name('dashboard.admins.index');
       route::post('admins/createUpdate','admins@createUpdate')->name('dashboard.admins.createUpdate');
       route::post('admins','admins@indexPageing')->name('dashboard.admins.indexPageing');
       route::get('admins/delete/{id}','admins@delete')->name('dashboard.admins.delete');
       route::get('admins/check/{type}/{id}','admins@check')->name('dashboard.admins.check');
       route::get('admins/getRecord/{id}','admins@getRecord')->name('dashboard.admins.getRecord');

       route::get('app_settings','app_settings@index')->name('dashboard.app_settings.index');
       route::post('app_settings/createUpdate','app_settings@createUpdate')->name('dashboard.app_settings.createUpdate');
       route::post('app_settings','app_settings@indexPageing')->name('dashboard.app_settings.indexPageing');
       route::get('app_settings/delete/{id}','app_settings@delete')->name('dashboard.app_settings.delete');
       route::get('app_settings/check/{type}/{id}','app_settings@check')->name('dashboard.app_settings.check');
       route::get('app_settings/getRecord/{id}','app_settings@getRecord')->name('dashboard.app_settings.getRecord');

       route::get('products','products@index')->name('dashboard.products.index');
       route::post('products/createUpdate','products@createUpdate')->name('dashboard.products.createUpdate');
       route::post('products','products@indexPageing')->name('dashboard.products.indexPageing');
       route::get('products/delete/{id}','products@delete')->name('dashboard.products.delete');
       route::get('products/check/{check}/{id}','products@check')->name('dashboard.products.check');
       route::get('products/getRecord/{id}','products@getRecord')->name('dashboard.products.getRecord');
       
       route::get('products','products@index')->name('dashboard.products.index');
       route::post('products/createUpdate','products@createUpdate')->name('dashboard.products.createUpdate');
       route::post('products','products@indexPageing')->name('dashboard.products.indexPageing');
       route::get('products/delete/{id}','products@delete')->name('dashboard.products.delete');
       route::get('products/check/{check}/{id}','products@check')->name('dashboard.products.check');
       route::get('products/getRecord/{id}','products@getRecord')->name('dashboard.products.getRecord');
       
       route::get('users','users@index')->name('dashboard.users.index');
       route::post('users/createUpdate','users@createUpdate')->name('dashboard.users.createUpdate');
       route::post('users','users@indexPageing')->name('dashboard.users.indexPageing');
       route::get('users/delete/{id}','users@delete')->name('dashboard.users.delete');
       route::get('users/check/{check}/{id}','users@check')->name('dashboard.users.check');
       route::get('users/getRecord/{id}','users@getRecord')->name('dashboard.users.getRecord');
       
       route::get('users','users@index')->name('dashboard.users.index');
       route::post('users/createUpdate','users@createUpdate')->name('dashboard.users.createUpdate');
       route::post('users','users@indexPageing')->name('dashboard.users.indexPageing');
       route::get('users/delete/{id}','users@delete')->name('dashboard.users.delete');
       route::get('users/check/{check}/{id}','users@check')->name('dashboard.users.check');
       route::get('users/getRecord/{id}','users@getRecord')->name('dashboard.users.getRecord');
       
       route::get('contact_us','contact_us@index')->name('dashboard.contact_us.index');
       route::post('contact_us/createUpdate','contact_us@createUpdate')->name('dashboard.contact_us.createUpdate');
       route::post('contact_us','contact_us@indexPageing')->name('dashboard.contact_us.indexPageing');
       route::get('contact_us/delete/{id}','contact_us@delete')->name('dashboard.contact_us.delete');
       route::get('contact_us/check/{check}/{id}','contact_us@check')->name('dashboard.contact_us.check');
       route::get('contact_us/getRecord/{id}','contact_us@getRecord')->name('dashboard.contact_us.getRecord');
       
       route::get('regions','regions@index')->name('dashboard.regions.index');
       route::post('regions/createUpdate','regions@createUpdate')->name('dashboard.regions.createUpdate');
       route::post('regions','regions@indexPageing')->name('dashboard.regions.indexPageing');
       route::get('regions/delete/{id}','regions@delete')->name('dashboard.regions.delete');
       route::get('regions/check/{check}/{id}','regions@check')->name('dashboard.regions.check');
       route::get('regions/getRecord/{id}','regions@getRecord')->name('dashboard.regions.getRecord');
       
       route::get('sliders','sliders@index')->name('dashboard.sliders.index');
       route::post('sliders/createUpdate','sliders@createUpdate')->name('dashboard.sliders.createUpdate');
       route::post('sliders','sliders@indexPageing')->name('dashboard.sliders.indexPageing');
       route::get('sliders/delete/{id}','sliders@delete')->name('dashboard.sliders.delete');
       route::get('sliders/check/{check}/{id}','sliders@check')->name('dashboard.sliders.check');
       route::get('sliders/getRecord/{id}','sliders@getRecord')->name('dashboard.sliders.getRecord');
       
       route::get('delivery_time','delivery_time@index')->name('dashboard.delivery_time.index');
       route::post('delivery_time/createUpdate','delivery_time@createUpdate')->name('dashboard.delivery_time.createUpdate');
       route::post('delivery_time','delivery_time@indexPageing')->name('dashboard.delivery_time.indexPageing');
       route::get('delivery_time/delete/{id}','delivery_time@delete')->name('dashboard.delivery_time.delete');
       route::get('delivery_time/check/{check}/{id}','delivery_time@check')->name('dashboard.delivery_time.check');
       route::get('delivery_time/getRecord/{id}','delivery_time@getRecord')->name('dashboard.delivery_time.getRecord');
       
       route::get('vouchers_time','vouchers_time@index')->name('dashboard.vouchers_time.index');
       route::post('vouchers_time/createUpdate','vouchers_time@createUpdate')->name('dashboard.vouchers_time.createUpdate');
       route::post('vouchers_time','vouchers_time@indexPageing')->name('dashboard.vouchers_time.indexPageing');
       route::get('vouchers_time/delete/{id}','vouchers_time@delete')->name('dashboard.vouchers_time.delete');
       route::get('vouchers_time/check/{check}/{id}','vouchers_time@check')->name('dashboard.vouchers_time.check');
       route::get('vouchers_time/getRecord/{id}','vouchers_time@getRecord')->name('dashboard.vouchers_time.getRecord');
       
       route::get('vouchers','vouchers@index')->name('dashboard.vouchers.index');
       route::post('vouchers/createUpdate','vouchers@createUpdate')->name('dashboard.vouchers.createUpdate');
       route::post('vouchers','vouchers@indexPageing')->name('dashboard.vouchers.indexPageing');
       route::get('vouchers/delete/{id}','vouchers@delete')->name('dashboard.vouchers.delete');
       route::get('vouchers/check/{check}/{id}','vouchers@check')->name('dashboard.vouchers.check');
       route::get('vouchers/getRecord/{id}','vouchers@getRecord')->name('dashboard.vouchers.getRecord');
       
       route::get('orders','orders@index')->name('dashboard.orders.index');
       route::post('orders/createUpdate','orders@createUpdate')->name('dashboard.orders.createUpdate');
       route::post('orders','orders@indexPageing')->name('dashboard.orders.indexPageing');
       route::get('orders/delete/{id}','orders@delete')->name('dashboard.orders.delete');
       route::get('orders/check/{check}/{id}','orders@check')->name('dashboard.orders.check');
       route::get('orders/getRecord/{id}','orders@getRecord')->name('dashboard.orders.getRecord');       route::get('orders/getRecordInfo/{id}','orders@getRecordInfo')->name('dashboard.orders.getRecordInfo');
       route::get('orders/getRecordInfo/{id}','orders@getRecordInfo')->name('dashboard.orders.getRecordInfo');
    
       route::get('images','images@index')->name('dashboard.images.index');
       route::post('images/createUpdate','images@createUpdate')->name('dashboard.images.createUpdate');
       route::post('images','images@indexPageing')->name('dashboard.images.indexPageing');
       route::get('images/delete/{id}','images@delete')->name('dashboard.images.delete');
       route::get('images/check/{check}/{id}','images@check')->name('dashboard.images.check');
       route::get('images/getRecord/{id}','images@getRecord')->name('dashboard.images.getRecord');
});