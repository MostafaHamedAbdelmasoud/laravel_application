<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin',
    'middleware' => ['auth:api']
],
    function () {
        // Permissions
        Route::apiResource('permissions', 'PermissionsApiController');

        // Roles
        Route::apiResource('roles', 'RolesApiController');

        // Users
        Route::apiResource('users', 'UsersApiController');

        // MainPageImages
        Route::post('mainpageimages/media', 'MainPageImagesApiController@storeMedia')->name('mainpageimages.storeMedia');
        Route::apiResource('mainpageimages', 'MainPageImagesApiController');

        // Cities
        Route::apiResource('cities', 'CitiesApiController');

        // Departments
        Route::post('departments/media', 'DepartmentsApiController@storeMedia')->name('departments.storeMedia');
        Route::apiResource('departments', 'DepartmentsApiController');

        // Categories
        Route::apiResource('categories', 'CategoriesApiController');

        // Offers
        Route::post('offers/media', 'OffersApiController@storeMedia')->name('offers.storeMedia');
        Route::apiResource('offers', 'OffersApiController');

        // Specializations
        Route::apiResource('specializations', 'SpecializationsApiController');

        // Jobs
        Route::post('jobs/media', 'JobsApiController@storeMedia')->name('jobs.storeMedia');
        Route::apiResource('jobs', 'JobsApiController');

        // News
        Route::post('news/media', 'NewsApiController@storeMedia')->name('news.storeMedia');
        Route::apiResource('news', 'NewsApiController');

        // Notifications
        Route::apiResource('notifications', 'NotificationsApiController');

        // Job Offers
        Route::post('job-offers/media', 'JobOfferApiController@storeMedia')->name('job-offers.storeMedia');
        Route::apiResource('job-offers', 'JobOfferApiController');

        // Traders
        Route::post('traders/media', 'TraderApiController@storeMedia')->name('traders.storeMedia');
        Route::apiResource('traders', 'TraderApiController');

        // Products
        Route::post('products/media', 'ProductsApiController@storeMedia')->name('products.storeMedia');
        Route::apiResource('products', 'ProductsApiController');


    });

Route::namespace('Api\V1\Admin')->group(function () {

    Route::get('/select/cities', 'CitiesSelectController@select_city')->name('cities.select');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Auth',
//    'middleware' => ['auth:api']
],
    function () {
        //Auth API
        Route::post('register', 'AuthApiController@register');
        Route::post('login', 'AuthApiController@login');
// + other routes in the same namespace
    });
