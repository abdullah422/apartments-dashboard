<?php


use Illuminate\Support\Facades\Route;

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
//Route::get('/apartments_for_anyone', 'ApartmentController@forAnyone');

Route::middleware('auth:sanctum')->group(function () {

    //user route
    Route::get( '/user', 'AuthController@user');
    Route::post( '/change_password', 'AuthController@changePassword');
    ////===================   Places ============================
     Route::get('/places', 'PlaceController@index');

    ///=================== Apartments for anyone ===================
   Route::get('/apartments_for_anyone', 'ApartmentController@forAnyone');



    //owners
///=================== Apartments for owner ===================
    Route::get('/apartments_for_owner', 'ApartmentController@forOwner');
    Route::get('/filter', 'ApartmentController@filter');
    Route::get('/filter_data', 'ApartmentController@filterData');
    Route::get('/get_favourites', 'ApartmentController@getFavourites');
    Route::get('/toggle', 'ApartmentController@toggleFavourite');

    Route::group(['prefix' => 'apartment'], function () {

        Route::post('/add', 'ApartmentController@storeApartment');
        Route::put('/update', 'ApartmentController@updateApartment');
        Route::delete('/delete', 'ApartmentController@deleteApartment');
        Route::post('/add_image', 'ApartmentController@storeImage');
        Route::post('/update_image', 'ApartmentController@updateImage');
        Route::delete('/delete_image', 'ApartmentController@deleteImage');

    });

});

