<?php 
    // Route::get('blade', function () {
    //     return view('page');
    // });
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::resource('dashboard', 'DashboardController');
        Route::resource('post', 'PostController');
        Route::resource('postcategory', 'PostCategoryController');
        Route::resource('category', 'CategoryController');
    // Route::resource('customers', 'CustomersController');
    // Route::resource('brands', 'BrandsController');
    // Route::resource('product-categories', 'ProductCategoriesController');
    // Route::resource('products', 'ProductsController');
    // Route::resource('users', 'UsersController');

    // Route::get('orders', [
    //     'uses' => 'OrdersController@index',
    //     'as' => 'orders.index',
    //     ]);
     });
?>