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

Auth::routes();

Route::get('/', 'Slip\SlipController@index')->name('slip.index');
Route::get('/export', 'Slip\SlipController@export')->name('export');
Route::post('slip/store', 'Slip\SlipController@store')->name('slip.store');
Route::post('slip/update', 'Slip\SlipController@update')->name('slip.update');
Route::post('slip/delete/{id}', 'Slip\SlipController@destroy')->name('slip.delete');
Route::resource('subject', 'Slip\SubjectController')->only(['index', 'create', 'store', 'destroy']);
Route::post('subject/update/{id}', 'Slip\SubjectController@update')->name('subject.update');
Route::get('m_summary', 'Slip\Month_summaryController@index')->name('m_summary.index');
Route::get('y_summary', 'Slip\Years_summaryController@index')->name('y_summary.index');

Route::get('scan_slip', 'Scan\ScanSlipController@index');
Route::post('scan_slip/extract', 'Scan\ScanSlipController@extract');