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

Route::get('/', 'RandomFormController@view');
Route::post('/', 'RandomFormController@handle');

Route::get('/dearsanta/{participant}', 'DearSantaController@view')->name('dearsanta');
Route::post('/dearsanta/{participant}', 'DearSantaController@handle');
