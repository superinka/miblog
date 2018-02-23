<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/admin', 'Admin\DashboardController@index')->name('Dashboard');

Route::get('/admin/post', 'Admin\PostController@index')->name('Bài Viết');

Route::get('/admin/postcategory', 'Admin\PostCategoryController@index')->name('Danh mục Bài Viết');

Route::get('/admin/postcategory/action', 'Admin\PostCategoryController@action');
Route::post('/admin/postcategory/action', 'Admin\PostCategoryController@action');

Route::get('/admin/postcategory/create', 'Admin\PostCategoryController@create');
Route::post('/admin/postcategory/create', 'Admin\PostCategoryController@create');

Route::get('/admin/category/action', 'Admin\CategoryController@action');
Route::post('/admin/category/action', 'Admin\CategoryController@action');

Route::get('/admin/category/create', 'Admin\CategoryController@create');
Route::post('/admin/category/create', 'Admin\CategoryController@create');

Route::get('/admin/postcategory/edit', 'Admin\PostCategoryController@edit');
Route::post('/admin/postcategory/edit', 'Admin\PostCategoryController@edit');

Route::get('/admin/postcategory/destroy', 'Admin\PostCategoryController@destroy');
Route::post('/admin/postcategory/destroy', 'Admin\PostCategoryController@destroy');

Route::get('/admin/postcategory/check_slug', 'Admin\PostCategoryController@check_slug');
Route::post('/admin/postcategory/check_slug', 'Admin\PostCategoryController@check_slug');

Route::get('/admin/postcategory/list_categories', 'Admin\PostCategoryController@list_categories');
Route::post('/admin/postcategory/list_categories', 'Admin\PostCategoryController@list_categories');

Route::get('category-tree-view',['uses'=>'CategoryController@manageCategory']);
Route::post('add-category',['as'=>'add.category','uses'=>'CategoryController@addCategory']);