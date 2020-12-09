<?php

Route::group(
    ['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin',
//    'middleware' => ['auth:api']
    ],
    function () {
        // Permissions
        Route::apiResource('permissions', 'PermissionsApiController');

        // Roles
        Route::group(['middleware' => 'can:role_access'], function () {
            Route::apiResource('roles', 'RolesApiController');
        });

        // Users
        Route::apiResource('users', 'UsersApiController');

        // MainPageImages
        Route::post('mainpageimages/media', 'MainPageImagesApiController@storeMedia')->name('mainpageimages.storeMedia');
        Route::apiResource('mainpageimages', 'MainPageImagesApiController');


        // MainPageImages
        Route::post('item_advertisements/media', 'ItemAdvertisementsApiController@storeMedia')->name('item_advertisements.storeMedia');
        Route::apiResource('item_advertisements', 'ItemAdvertisementsApiController');

        // Cities
        Route::apiResource('cities', 'CitiesApiController');

        // Departments
        Route::post('departments/media', 'DepartmentsApiController@storeMedia')->name('departments.storeMedia');
        Route::apiResource('departments', 'DepartmentsApiController');

        // تصنيف قسم التسوق الرئيسية
        Route::apiResource('categories', 'CategoriesApiController');


        // تصنيف منتجات رئيسي
        Route::apiResource('main_product_types', 'MainProductTypesApiController');


        //تصنيف خدمات منتجات رئيسي
        Route::apiResource('main_product_service_types', 'MainProductServiceTypesApiController');


        // تصنيف قسم التسوق الفرعية
        Route::apiResource('sub_categories', 'SubCategoriesApiController');
        Route::get('get_categories_ajax/{id}', 'SubCategoriesApiController@getCategoryAjax');

        // تصنيف منتجات فرعي
        Route::apiResource('sub_product_types', 'SubProductTypesApiController');
        Route::get('get_main_product_type_ajax/{id}', 'SubProductTypesApiController@getMainProductTypeAjax');


        //تصنيف خدمات منتجات فرعي
        Route::apiResource('sub_product_service_types', 'SubProductServiceTypesApiController');
        Route::get('get_main_product_service_type_ajax/{id}', 'SubProductServiceTypesApiController@SubProductServiceTypeAjax');


        //تصنيف الإعلانات رئيسي
        Route::apiResource('news_categories', 'NewsCategoriesApiController');


        //تصنيف فرعي الإعلانات
        Route::apiResource('news_sub_categories', 'NewsSubCategoriesApiController');
        Route::get('get_news_sub_categories_ajax/{id}', 'NewsSubCategoriesApiController@getNewsSubCategoryAjax');

        // Coupons
        Route::apiResource('coupons', 'CouponsApiController');

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
        Route::apiResource('news', 'NewsApiController'); // details field for filter

        // Notifications
        Route::apiResource('notifications', 'NotificationsApiController');

        // Job Offers
        Route::post('job-offers/media', 'JobOfferApiController@storeMedia')->name('job-offers.storeMedia');
        Route::apiResource('job-offers', 'JobOfferApiController'); //about  field for filter

        // Traders
        Route::post('traders/media', 'TraderApiController@storeMedia')->name('traders.storeMedia');
        Route::apiResource('traders', 'TraderApiController');

        // Products
        Route::post('products/media', 'ProductsApiController@storeMedia')->name('products.storeMedia');
        Route::apiResource('products', 'ProductsApiController');

        // Variants
        Route::post('variants/media', 'VariantsApiController@storeMedia')->name('variants.storeMedia');
        Route::apiResource('products.variants', 'VariantsApiController');

        // Orders
        Route::apiResource('orders', 'OrdersApiController');
    }
);

Route::namespace('Api\V1\Admin')->group(function () {
    Route::get('/select/cities', 'CitiesSelectController@select_city')->name('cities.select');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Auth',],function () {
        //Auth API
        Route::post('register', 'AuthApiController@register');
        Route::post('login', 'AuthApiController@login');
        // + other routes in the same namespace
    }
);
