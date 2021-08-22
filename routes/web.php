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

Auth::routes(['register' => false]);

// 経費処理
Route::get('/', 'Slip\SlipController@index')->name('slip.index');
Route::post('slip/store', 'Slip\SlipController@store')->name('slip.store');
Route::post('slip/update', 'Slip\SlipController@update')->name('slip.update');
Route::post('slip/delete/{id}', 'Slip\SlipController@destroy')->name('slip.delete');
// excel出力
Route::get('/export', 'Slip\Years_summaryController@export')->name('export');
// 科目
Route::resource('subject', 'Slip\SubjectController')->only(['index', 'create', 'store', 'destroy']);
Route::post('subject/update/{id}', 'Slip\SubjectController@update')->name('subject.update');
// 月間サマリー
Route::get('m_summary', 'Slip\Month_summaryController@index')->name('m_summary.index');
Route::post('m_summary/store', 'Slip\Month_summaryController@store')->name('m_summary.store');
// 年間サマリー
Route::get('y_summary', 'Slip\Years_summaryController@index')->name('y_summary.index');
Route::post('y_summary/store', 'Slip\Years_summaryController@store')->name('y_summary.store');
// レシートスキャン
Route::get('scan_slip', 'Scan\ScanSlipController@index');
Route::post('scan_slip/extract', 'Scan\ScanSlipController@extract');
// マニュアル
Route::get('manual', 'Manual\ManualController@index')->name('manual.index');
Route::get('manual/slip', 'Manual\ManualController@slip')->name('manual.slip');
Route::get('manual/m_slip', 'Manual\ManualController@month_slip')->name('manual.m_slip');
Route::get('manual/y_slip', 'Manual\ManualController@years_slip')->name('manual.y_slip');

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
  // ユーザ管理
  Route::get('/account', 'Admin\AccountController@index')->name('account.index');
  Route::post('/account/store', 'Admin\AccountController@store')->name('account.store');
  Route::post('/account/update', 'Admin\AccountController@update')->name('account.update');
});