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
Route::get('/', 'HomeController@index');
Route::get('/getLaporanHarian', 'HomeController@getData');
Route::get('/getLaporanBulanan', 'HomeController@getDataBulanan');
// Route::get('/home', 'HomeController@index');
Route::get('/logout', 'HomeController@getLogout');
//setting
Route::get('/setting', 'HomeController@setting');
Route::post('/setting-save', 'HomeController@save');


//laundry controller
Route::post('laundry/saveDetail', 'LaundryController@saveDetail');
Route::post('laundry/saveHeader', 'LaundryController@saveHeader');
Route::post('laundry/multipleDo', 'LaundryController@multipleDo');
Route::post('laundry/multipleDelete', 'LaundryController@multipleDelete');
Route::post('laundry/bayar', 'LaundryController@bayar');

Route::get('laundry/transaksi', 'LaundryController@transaksi');
Route::get('laundry/hapus/{id}', 'LaundryController@delete');
Route::get('laundry/view', 'LaundryController@index');
Route::get('laundry/cetak/{kode}', 'LaundryController@print');
Route::get('laundry/done/{kode}', 'LaundryController@done');
Route::get('laundry/detail/{kode}', 'LaundryController@detail');
Route::get('laundry/detail-delete/{kode}', 'LaundryController@detail');
Route::get('laundry/batal/{kode}', 'LaundryController@batal');
Route::get('laundry/hapusPermanen/{kode}', 'LaundryController@hapusPermanen');
Route::get('laundry/search/', 'LaundryController@search');
Route::get('laundry/canceledTransaksi/', 'LaundryController@canceledTransaksi');
Route::get('laundry/done', 'LaundryController@transaksiDone');

//master barang laundry route
Route::get('master/laundry', 'MasterController@index');
Route::get('master/laundry-delete/{id}', 'MasterController@laundryDelete');
Route::post('master/laundrySave', 'MasterController@laundrySave');
Route::post('master/laundryUpdate', 'MasterController@laundryUpdate');
Route::post('master/laundry-delete-m', 'MasterController@laundryDeleteM');

//master barang penjualan route
Route::get('master/penjualan', 'MasterController@penjualan');
Route::get('master/masterpenjualandelete/{id}', 'MasterController@masterpenjualandelete');
Route::post('master/masterpenjualansave', 'MasterController@masterpenjualansave');
Route::post('master/masterpenjualanupdate', 'MasterController@masterpenjualanupdate');
Route::post('master/masterpenjualandeletem', 'MasterController@masterpenjualandeletem');

//master biaya bulanan
Route::get('master/biayabulanan', 'MasterController@index_biayabulanan');
Route::get('master/biaya-bulanan-delete/{id}', 'MasterController@biayaBulananMasterDelete');
Route::post('master/biaya-bulanan-save', 'MasterController@biayaBulananMasterSave');
Route::post('master/biaya-bulanan-update', 'MasterController@biayaBulananMasterUpdate');
Route::post('master/biaya-bulanan-delete-multiple', 'MasterController@biayaBulananMasterDelMultiple');

//master customer
Route::get('master/customer', 'CustomerController@index');

//arus kas route
Route::get('aruskas/kaskecilrincian', 'ArusKasController@indexKasKecilRincian');
Route::get('aruskas/kaskecil/{kode}', 'ArusKasController@indexKasKecil');
Route::get('aruskas/kaskecil/', 'ArusKasController@kasKecilCari');
Route::get('aruskas/delete/{id}', 'ArusKasController@delete');
Route::get('aruskas/export', 'ArusKasController@export');
Route::post('aruskas/kaskecilSave', 'ArusKasController@kaskecilSave');
Route::post('aruskas/kaskecilUpdate', 'ArusKasController@kaskecilUpdate');
Route::post('aruskas/multipleDelete', 'ArusKasController@multipleDelete');

Route::get('aruskas/kasbesar/{date}/{jenis}', 'ArusKasController@indexKasBesar');
Route::get('aruskas/kasbesarDelete/{id}', 'ArusKasController@kasbesarDelete');
Route::get('aruskas/kasbesar/search', 'ArusKasController@searchKasBesar');
Route::post('aruskas/kasbesar/multipleDelete', 'ArusKasController@kBsrMultipleDelete');
Route::post('aruskas/kasBesarSave', 'ArusKasController@kasBesarSave');
Route::post('aruskas/kasBesarUpdate', 'ArusKasController@kasBesarUpdate');

//penjualan
Route::get('penjualan/view/{time}', 'PenjualanController@index');
Route::get('penjualan/transaksi', 'PenjualanController@transaksi');
Route::get('penjualan/deletedetail/{id}', 'PenjualanController@deletedetail');
Route::get('penjualan/transaksi', 'PenjualanController@transaksi');
Route::get('penjualan/search', 'PenjualanController@search');
Route::get('penjualan/detail/{kode}', 'PenjualanController@detail');
Route::post('penjualan/saveDetail', 'PenjualanController@saveDetail');
Route::post('penjualan/saveHeader', 'PenjualanController@saveHeader');

//restok barang
Route::get('restok/view/{time}', 'RestokController@index');
Route::post('restok/restoksave', 'RestokController@save');
Route::get('restok/delete/{id}', 'RestokController@delete');

//biaya bulanan GAJI
Route::get('biaya-bulanan/gaji/{time}', 'GajiController@index');
Route::get('biaya-bulanan/gaji-search/', 'GajiController@search');
Route::get('biaya-bulanan/gaji/hapus/{id}', 'GajiController@delete');
Route::post('biaya-bulanan/gaji/save', 'GajiController@save');

//biaya bulanan
Route::get('biaya-bulanan/bb/{time}', 'BiayaBulananController@index');
Route::get('biaya-bulanan/bb', 'BiayaBulananController@search');
Route::post('biaya-bulanan/bb/save', 'BiayaBulananController@save');
Route::post('biaya-bulanan/bb/update', 'BiayaBulananController@update');

//other
Route::get('other/{tipe}/{time}', 'OtherController@index');
Route::get('other/search', 'OtherController@search');
Route::get('othr/delete/{data}', 'OtherController@delete');
Route::post('other/save', 'OtherController@save');
Route::post('other/update', 'OtherController@update');

//data Laporan
//harian
Route::get('laporan/harian/{time}', 'LaporanController@index');
Route::get('laporan/harian-add/', 'LaporanController@add');
Route::get('laporan/harian-search', 'LaporanController@search');
Route::post('laporan/harian-save/', 'LaporanController@save');
//bulanan
Route::get('laporan/bulanan/{time}', 'LaporanController@indexBulanan');
Route::get('laporan/bulanan-search', 'LaporanController@search_bulanan');
