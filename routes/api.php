<?php


use GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Google Map Location API  */
Route::get('location', function(){
    $location = new GoogleMaps();

    $response =  $location->load('geocoding')
    ->setParam([
        'address'    => 'santa cruz',
        // 'components' => [
        //     'administrative_area'  => 'TX',
        //     'country'              => 'US',
        // ]
    ])->get();
    return $response;
});

/* Admin api routes for back panel  */
Route::group(['namespace' => 'Api\Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::apiResource('/locations', LocationController::class);
    Route::apiResource('/venues', VenueController::class);
    Route::apiResource('/ceramonies', CeramonyController::class);
    Route::apiResource('/tasks', TaskController::class);
    Route::apiResource('/vendors', VendorController::class);
    Route::apiResource('/articles', ArticleController::class);
    Route::apiResource('/testimonials',TestimonialController::class);
});

Route::group(['namespace' => 'Api\Host', 'prefix' => 'host', 'as' => 'host.'], function () {
    Route::apiResource('/invitationData', InvitationDataController::class);
});


Route::group(['namespace' => 'Api\Vendor', 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
    // Route::get('/vendorsProfile/{id}', 'VendorController@index');
    // Route::post('/vendorsProfile', 'VendorController@store');
    // Route::patch('/vendorsProfile/{id}', 'VendorController@update');
    // Route::post('/vendorsCProfile', 'VendorController@storeCompany');
    // Route::patch('/vendorsProfile/{id}', 'VendorController@update');
    
    // Route::get('/vendorsCategory/{id}', 'VendorController@catGet');
    Route::post('/vendorsCategory', 'VendorController@catStore');
    Route::get('/vendorsProducts/{id}/{catid}', 'VendorController@productGet');
    Route::apiResource('/review', 'ReviewController');

});


Route::group(['namespace' => 'Api\Vendor', 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
   // Route::apiResource('/profile', 'ProfileController');
    Route::apiResource('/lead', 'LeadController');
});

Route::group(['namespace' => 'Api\Vendor\Services', 'prefix' => 'vendor', 'as' => 'vendor.'], function () {
    Route::apiResource('/addacc', 'AccomodationController');
    Route::apiResource('/addvenue', 'VenueController'); 
}); 


//Company Routes
Route::group(['namespace' => 'Api\Company', 'prefix' => 'company', 'as' => 'company.'], function () {
    Route::apiResource('/profile', 'ProfileController');

});

//Host Routes
Route::group(['namespace' => 'Api\Host', 'prefix' => 'host', 'as' => 'host.'], function () {
    Route::apiResource('/profile', 'ProfileController');

});

//Bride Routes
Route::group(['namespace' => 'Api\Bride', 'prefix' => 'bride', 'as' => 'bride.'], function () {
    Route::apiResource('/profile', 'ProfileController');

});


//Groom Routes
Route::group(['namespace' => 'Api\Groom', 'prefix' => 'groom', 'as' => 'groom.'], function () {
    Route::apiResource('/profile', 'ProfileController');

});


//Guest Routes
Route::group(['namespace' => 'Api\Guest', 'prefix' => 'guest', 'as' => 'guest.'], function () {
    Route::apiResource('/profile', 'ProfileController');

});

Route::group(['namespace' => 'Api'], function () {
    Route::apiResource('contactus', 'ContactusController');
    Route::apiResource('sitetasks', 'SitetasksController');
    //Route::apiResource('authcheck', 'AuthcheckController');

});

Route::group([ 'namespace' => 'Api'], function () {
    Route::apiResource('authcheck', 'AuthcheckController');
});











// List articles
Route::group(['namespace' => 'Admin'], function(){
    Route::get('articles', 'ArticleController@index');

    // List single article
    Route::get('article/{id}', 'ArticleController@show');

    // Create new article
    Route::post('article', 'ArticleController@store');

    // Update article
    Route::put('article', 'ArticleController@store');

    // Delete article
    Route::delete('article/{id}', 'ArticleController@destroy');

});


//Route::get('/categories', 'Vendor\VendorCatController@index');
//Route::get('/products', 'Vendor\ProductController@index');
//Route::get('/services', 'Vendor\ServiceController@index');
