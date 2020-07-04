<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::get('offline',function(){
    return view('frontend.offline');
});

Route::get('manage/login', 'Backend\AuthController@login')->name('manage.login')->middleware('islogin');
Route::post('manage/login', 'Backend\AuthController@loginPost')->name('manage.loginPost')->middleware('islogin');

Route::prefix('manage')->namespace('Backend')->name('manage.')->middleware('isadmin')->group(function () {

    //ARTICLE
    Route::get('panel', 'Dashboard@index')->name('dashboard');
    Route::get('switch', 'ArticleController@switch')->name('switch');
    Route::get('deletearticle/{id}', 'ArticleController@delete')->name('delete.article');
    Route::get('harddeletearticle/{id}', 'ArticleController@hardDelete')->name('harddelete.article');
    Route::Get('recoverarticle/{id}', 'ArticleController@recover')->name('recover.article');
    Route::get('meqale/silinenler', 'ArticleController@trashed')->name('trashed.article');
    Route::resource('meqale', 'ArticleController');
 
    //CATEGORY
    Route::get('kateqoriya', 'CategoryController@index')->name('category.index');
    Route::get('kateqoriya/switch','CategoryController@switch')->name('category.switch');
    Route::get('kateqoriya/getdata','CategoryController@getData')->name('category.getdata');
    Route::post('kateqoriya/update','CategoryController@update')->name('category.update');
    Route::post('kateqoriya/delete','CategoryController@delete')->name('category.delete');
    Route::post('kateqoriya/post','CategoryController@categoryPost')->name('category.post');
    Route::get('logout', 'AuthController@logout')->name('logout');

    //PAGES
    Route::get('sehifeler','PageController@index')->name('page.index');
    Route::get('sehifeler/yeni','PageController@create')->name('page.create');
    Route::get('sehifeler/guncelle/{id}','PageController@edit')->name('page.edit');
    Route::post('sehifeler/guncelle/{id}','PageController@update')->name('page.update');
    Route::get('sehifeler/sil/{id}','PageController@delete')->name('page.delete');
    Route::post('sehifeler/yeni','PageController@post')->name('page.post');
    Route::get('sehifeler/switch','PageController@switch')->name('page.switch');
    Route::get('sehifeler/siralama','PageController@sortable')->name('page.sortable');

    //SETTINGS
    Route::get('parametrler','ConfigController@index')->name('config.index');
    Route::post('parametrler/redakte','ConfigController@update')->name('config.update');
});



/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'Frontend\HomePage@index')->name('homePage');
Route::get('/sehife', 'Frontend\HomePage@index');
Route::get('/elaqe', 'Frontend\HomePage@contact')->name('contact');
Route::post('/elaqe', 'Frontend\HomePage@contactPost')->name('contact.post');
Route::get('/kateqoriya/{category}', 'Frontend\HomePage@category')->name('category');
Route::get('/{category}/{slug}', 'Frontend\HomePage@single')->name('single');
Route::get('/{seyfe}', 'Frontend\HomePage@page')->name('page');
