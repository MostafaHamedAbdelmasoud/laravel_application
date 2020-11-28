<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // MainPageImages
    Route::delete('mainpageimages/destroy', 'MainPageImagesController@massDestroy')->name('mainpageimages.massDestroy');
    Route::post('mainpageimages/media', 'MainPageImagesController@storeMedia')->name('mainpageimages.storeMedia');
    Route::post('mainpageimages/ckmedia', 'MainPageImagesController@storeCKEditorImages')->name('mainpageimages.storeCKEditorImages');
    Route::resource('mainpageimages', 'MainPageImagesController');

    // Cities
    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CitiesController');

    // Departments
    Route::delete('departments/destroy', 'DepartmentsController@massDestroy')->name('departments.massDestroy');
    Route::post('departments/media', 'DepartmentsController@storeMedia')->name('departments.storeMedia');
    Route::post('departments/ckmedia', 'DepartmentsController@storeCKEditorImages')->name('departments.storeCKEditorImages');
    Route::resource('departments', 'DepartmentsController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Offers
    Route::delete('offers/destroy', 'OffersController@massDestroy')->name('offers.massDestroy');
    Route::post('offers/media', 'OffersController@storeMedia')->name('offers.storeMedia');
    Route::post('offers/ckmedia', 'OffersController@storeCKEditorImages')->name('offers.storeCKEditorImages');
    Route::resource('offers', 'OffersController');

    // Specializations
    Route::delete('specializations/destroy', 'SpecializationsController@massDestroy')->name('specializations.massDestroy');
    Route::resource('specializations', 'SpecializationsController');

    // Jobs
    Route::delete('jobs/destroy', 'JobsController@massDestroy')->name('jobs.massDestroy');
    Route::post('jobs/media', 'JobsController@storeMedia')->name('jobs.storeMedia');
    Route::post('jobs/ckmedia', 'JobsController@storeCKEditorImages')->name('jobs.storeCKEditorImages');
    Route::resource('jobs', 'JobsController');

    // News
    Route::delete('news/destroy', 'NewsController@massDestroy')->name('news.massDestroy');
    Route::post('news/media', 'NewsController@storeMedia')->name('news.storeMedia');
    Route::post('news/ckmedia', 'NewsController@storeCKEditorImages')->name('news.storeCKEditorImages');
    Route::resource('news', 'NewsController');

    // Notifications
    Route::delete('notifications/destroy', 'NotificationsController@massDestroy')->name('notifications.massDestroy');
    Route::resource('notifications', 'NotificationsController');

    // Job Offers
    Route::delete('job-offers/destroy', 'JobOfferController@massDestroy')->name('job-offers.massDestroy');
    Route::post('job-offers/media', 'JobOfferController@storeMedia')->name('job-offers.storeMedia');
    Route::post('job-offers/ckmedia', 'JobOfferController@storeCKEditorImages')->name('job-offers.storeCKEditorImages');
    Route::resource('job-offers', 'JobOfferController');

    // Traders
    Route::delete('traders/destroy', 'TraderController@massDestroy')->name('traders.massDestroy');
    Route::post('traders/media', 'TraderController@storeMedia')->name('traders.storeMedia');
    Route::post('traders/ckmedia', 'TraderController@storeCKEditorImages')->name('traders.storeCKEditorImages');
    Route::resource('traders', 'TraderController');

    // Products
    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductsController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductsController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductsController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
