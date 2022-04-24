<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'role:admin|super_admin',
])
    ->group(function () {

        Route::name('admin.')->prefix('admin')->group(function () {

            //home
            Route::get('/home/top_statistics', 'HomeController@topStatistics')->name('home.top_statistics');
            Route::get('/home', 'HomeController@index')->name('home');

            //role routes
            Route::get('/roles/data', 'RoleController@data')->name('roles.data');
            Route::delete('/roles/bulk_delete', 'RoleController@bulkDelete')->name('roles.bulk_delete');
            Route::resource('roles', 'RoleController');

            //admin routes
            Route::get('/admins/data', 'AdminController@data')->name('admins.data');
            Route::delete('/admins/bulk_delete', 'AdminController@bulkDelete')->name('admins.bulk_delete');
            Route::resource('admins', 'AdminController');

            //owner routes
            Route::get('/owners/data', 'OwnerController@data')->name('owners.data');
            Route::delete('/owners/bulk_delete', 'OwnerController@bulkDelete')->name('owners.bulk_delete');
            Route::resource('owners', 'OwnerController');

            //user routes
            Route::get('/users/data', 'UserController@data')->name('users.data');
            Route::delete('/users/bulk_delete', 'UserController@bulkDelete')->name('users.bulk_delete');
            Route::resource('users', 'UserController');

            //setting routes
            Route::get('/settings/general', 'SettingController@general')->name('settings.general');
            Route::resource('settings', 'SettingController')->only(['store']);

            //profile routes
            Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
            Route::put('/profile/update', 'ProfileController@update')->name('profile.update');
            Route::name('profile.')->namespace('Profile')->group(function () {

                //password routes
                Route::get('/password/edit', 'PasswordController@edit')->name('password.edit');
                Route::put('/password/update', 'PasswordController@update')->name('password.update');

            });

            //place routes
            Route::get('/places/data', 'PlaceController@data')->name('places.data');
            Route::delete('/places/bulk_delete', 'PlaceController@bulkDelete')->name('places.bulk_delete');
            Route::resource('places', 'PlaceController');

            // apartments routes
            Route::get('/apartments/data', 'ApartmentController@data')->name('apartments.data');
            Route::delete('/apartments/bulk_delete', 'ApartmentController@bulkDelete')->name('apartments.bulk_delete');
            Route::resource('apartments', 'ApartmentController');


            // Banners routes
            Route::get('/banners/data', 'BannerController@data')->name('banners.data');
            Route::delete('/banners/bulk_delete', 'BannerController@bulkDelete')->name('banners.bulk_delete');
            Route::resource('banners', 'BannerController');

        });

    });
