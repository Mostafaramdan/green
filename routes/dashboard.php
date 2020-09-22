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

       route::get('providers','providers@index')->name('dashboard.providers.index');
       route::post('providers/createUpdate','providers@createUpdate')->name('dashboard.providers.createUpdate');
       route::post('providers','providers@indexPageing')->name('dashboard.providers.indexPageing');
       route::get('providers/delete/{id}','providers@delete')->name('dashboard.providers.delete');
       route::get('providers/check/{check}/{id}','providers@check')->name('dashboard.providers.check');
       route::get('providers/getRecord/{id}','providers@getRecord')->name('dashboard.providers.getRecord');

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

       route::get('stores','stores@index')->name('dashboard.stores.index');
       route::post('stores/createUpdate','stores@createUpdate')->name('dashboard.stores.createUpdate');
       route::post('stores','stores@indexPageing')->name('dashboard.stores.indexPageing');
       route::get('stores/delete/{id}','stores@delete')->name('dashboard.stores.delete');
       route::get('stores/check/{check}/{id}','stores@check')->name('dashboard.stores.check');
       route::get('stores/getRecord/{id}','stores@getRecord')->name('dashboard.stores.getRecord');

       route::get('services','services@index')->name('dashboard.services.index');
       route::post('services/createUpdate','services@createUpdate')->name('dashboard.services.createUpdate');
       route::post('services','services@indexPageing')->name('dashboard.services.indexPageing');
       route::get('services/delete/{id}','services@delete')->name('dashboard.services.delete');
       route::get('services/check/{check}/{id}','services@check')->name('dashboard.services.check');
       route::get('services/getRecord/{id}','services@getRecord')->name('dashboard.services.getRecord');

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
});

