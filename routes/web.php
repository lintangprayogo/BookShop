<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();


Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name("register");

Route::resource("users","UserController");



Route::get('categories/trash',"CategoryController@trash")->name("categories.trash");
Route::get('categories/{id}/restore',"CategoryController@restore")->name("categories.restore");
Route::delete('categories/{id}/permanent-delete',"CategoryController@permanentDelete")->name("categories.delete-permanent");
Route::resource("categories","CategoryController");

Route::delete('books/{id}/permanent-delete',"BookController@permanentDelete")->name("books.delete-permanent");
Route::get('books/{id}/restore',"BookController@restore")->name("books.restore");
Route::get('books/trash','BookController@trash')->name("books.trash");
Route::resource('books', 'BookController');
Route::get('/ajax/categories/search','BookController@ajaxSearch')->name('categories.ajax');

Route::resource('orders', 'OrderController');


Route::get('/home', 'HomeController@index')->name('home');
