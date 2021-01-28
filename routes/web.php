<?php

Auth::routes(['register'=>false]);
Route::get('/','HomeController@index');

Route::group(['middleware' => ['web', 'auth', 'permission'] ], function () {

  Route::group(['namespace' => '\Arcanedev\LogViewer\Http\Controllers','prefix' => 'log-viewer'], function () {
    Route::get('/','LogViewerController@index')->name('log-viewer::logs.dashboard');
  });

  Route::get('/dashboard', 'HomeController@index')->name('home.dashboard');

  Route::resource('users','backend\UserController');
  Route::get('activ/{id}','backend\UserController@active')->name('users.activate');
  Route::get('deactiv/{id}','backend\UserController@deactivate')->name('users.deactivate');
  Route::get('user/{id}/permission','backend\UserController@permissions')->name('users.permissions');
  Route::post('user/{id}/permission', 'backend\UserController@simpan')->name('users.simpan');
  Route::post('user/ajax_all', ['uses' => 'backend\UserController@ajax_all']);

  Route::resource('regist','backend\registController');

  Route::get('roles','backend\RoleController@index')->name('roles.index');
  Route::post('roles','backend\RoleController@store')->name('roles.add');
  Route::patch('roles/{id}','backend\RoleController@update')->name('roles.updt');
  Route::delete('roles/{id}','backend\RoleController@destroy')->name('roles.destroy');
  Route::get('roles/{id}/permission','backend\RoleController@permissions')->name('roles.permissions');
  Route::post('roles/{id}/permission', 'backend\RoleController@simpan')->name('roles.simpan');

  Route::get('satuan-kerja','backend\satuanKerjaController@index')->name('satker.index');
  Route::post('satuan-kerja','backend\satuanKerjaController@store')->name('satker.add');
  Route::patch('satuan-kerja/{id}','backend\satuanKerjaController@update')->name('satker.updt');
  Route::delete('satuan-kerja/{id}','backend\satuanKerjaController@destroy')->name('satker.destroy');

  Route::get('unit','backend\unitController@index')->name('unit.index');
  Route::post('unit','backend\unitController@store')->name('unit.add');
  Route::patch('unit/{id}','backend\unitController@update')->name('unit.updt');
  Route::delete('unit/{id}','backend\unitController@destroy')->name('unit.destroy');

  Route::get('brand','backend\brandController@index')->name('brand.index');
  Route::post('brand','backend\brandController@store')->name('brand.add');
  Route::patch('brand/{id}','backend\brandController@update')->name('brand.updt');
  Route::delete('brand/{id}','backend\brandController@destroy')->name('brand.destroy');

  Route::get('type','backend\typeController@index')->name('type.index');
  Route::post('type','backend\typeController@store')->name('type.add');
  Route::patch('type/{id}','backend\typeController@update')->name('type.updt');
  Route::delete('type/{id}','backend\typeController@destroy')->name('type.destroy');

  Route::get('jenis-barang','backend\jenisBarangController@index')->name('jenis.index');
  Route::post('jenis-barang','backend\jenisBarangController@store')->name('jenis.add');
  Route::patch('jenis-barang/{id}','backend\jenisBarangController@update')->name('jenis.updt');
  Route::delete('jenis-barang/{id}','backend\jenisBarangController@destroy')->name('jenis.destroy');

  Route::get('supplier','backend\supplierController@index')->name('supplier.index');
  Route::post('supplier','backend\supplierController@store')->name('supplier.add');
  Route::patch('supplier/{id}','backend\supplierController@update')->name('supplier.updt');
  Route::delete('supplier/{id}','backend\supplierController@destroy')->name('supplier.destroy');

  Route::get('request-inventoris','backend\inventorisRequestController@index')->name('inreq.index');
  Route::get('request-inventoris/create','backend\inventorisRequestController@create')->name('inreq.create');
  Route::get('request-inventoris/{id}','backend\inventorisRequestController@show')->name('inreq.show');
  Route::get('request-inventoris/cetak/{id}','backend\inventorisRequestController@cetak');
  Route::post('request-inventoris','backend\inventorisRequestController@store')->name('inreq.store');
  Route::delete('request-inventoris/{id}','backend\inventorisRequestController@destroy')->name('inreq.destroy');
  Route::patch('request-inventoris/{id}','backend\inventorisRequestController@acc')->name('inreq.acc');
  Route::patch('request-inventoris/acc_one/{id}','backend\inventorisRequestController@acc_one')->name('inreq.acc_one');
  Route::put('request-inventoris/reject_one/{id}','backend\inventorisRequestController@reject_one')->name('inreq.reject_one');
  Route::put('request-inventoris/{id}','backend\inventorisRequestController@reject')->name('inreq.reject');

  Route::post('detail-request-inventoris/{id}','backend\inventorisRequestDetailController@store')->name('inreqde.add');
  Route::patch('detail-request-inventoris/{id}','backend\inventorisRequestDetailController@update')->name('inreqde.updt');
  Route::delete('detail-request-inventoris/{id}','backend\inventorisRequestDetailController@destroy')->name('inreqde.destroy');

  Route::get('item','backend\itemController@index')->name('item.index');
  Route::get('item/create','backend\itemController@create')->name('item.create');
  Route::get('item/{id}','backend\itemController@show')->name('item.show');
  Route::post('item','backend\itemController@store')->name('item.store');
  Route::patch('item/{id}','backend\itemController@update')->name('item.updt');
  Route::delete('item/{id}','backend\itemController@destroy')->name('item.destroy');

  Route::get('transaksi','backend\transaksiController@index')->name('transaksi.index');
  Route::patch('transaksi/{id}','backend\transaksiController@send')->name('transaksi.send');
  Route::get('transaksi/{id}','backend\transaksiController@show')->name('transaksi.show');

  Route::get('markets','backend\marketsController@index')->name('markets.index');
  Route::get('markets//{id}/create','backend\marketsController@create')->name('markets.create');
  Route::post('markets/{id}','backend\marketsController@store')->name('markets.store');

  Route::get('orders','backend\ordersController@index')->name('orders.index');
  Route::get('orders/{id}','backend\ordersController@confirm')->name('orders.confirm');


  Route::get('salurkan/create','backend\salurkanController@create')->name('salurkan.create');
  Route::post('salurkan','backend\salurkanController@create')->name('salurkan.store');

  Route::post('detail-inventoris/{id}','backend\inventorisDetailController@store')->name('inventorisDetail.add');
  Route::patch('detail-inventoris/{inventoris_id}/{id}','backend\inventorisDetailController@confirm')->name('inventorisDetail.updt');
  Route::delete('detail-inventoris/{inventoris_id}/{id}','backend\inventorisDetailController@destroy')->name('inventorisDetail.destroy');

  Route::post('keluar-inventoris/{id}','backend\inventorisKeluarController@store')->name('inventorisKeluar.add');
  Route::patch('keluar-inventoris/{inventoris_id}/{id}','backend\inventorisKeluarController@update')->name('inventorisKeluar.updt');
  Route::delete('keluar-inventoris/{inventoris_id}/{id}','backend\inventorisKeluarController@destroy')->name('inventorisKeluar.destroy');

  Route::get('laporan-mingguan/filter','backend\laporanController@lapmingguanfilter')->name('laporan.mingguan-filter');
  Route::get('laporan-mingguan','backend\laporanController@lapmingguanpgsql2')->name('laporan.mingguan');
  Route::get('laporan-keluar/filter','backend\laporanController@lapkeluarfilter')->name('laporan.keluar-filter');
  Route::get('laporan-keluar','backend\laporanController@lapkeluar')->name('laporan.keluar');


  //Profile
  Route::get('profile','profileController@index');
  Route::get('edit-profile','profileController@editProfile');
  Route::patch('edit-profile','profileController@updateProfile');
  Route::get('edit-password','profileController@editPassword');
  Route::patch('edit-password','profileController@updatePassword');

});

Route::group(['middleware' => ['api', 'auth'], 'prefix' => 'api' ], function () {
  Route::get('/user','backend\UserController@getData');
  Route::get('/role','backend\RoleController@getData');
  Route::get('/sumber','backend\inventorisSumberController@getData');
  Route::get('/permission','backend\RoleController@permissionGetData');

  Route::get('/satuan-kerja','backend\satuanKerjaController@getData');
  Route::get('/item','backend\itemController@getData');
  Route::get('/unit','backend\unitController@getData');
  Route::get('/brand','backend\brandController@getData');
  Route::get('/type','backend\typeController@getData');
  Route::get('/jenis-barang','backend\jenisBarangController@getData');
  Route::get('/supplier-barang','backend\supplierController@getData');
  Route::get('/transaksi','backend\transaksiController@getData');
  Route::get('/acc-inventoris/{barang_id}/{satuan_id}','backend\inventorisRequestController@accData');
  Route::get('/inventoris','backend\inventorisController@getData');
  Route::get('/orders','backend\ordersController@getData');

  Route::get('/select/sumber/{satker}/{barang}/{satuan}','api\selectController@sumber');
});

Route::get('img/{type}/{file_id}','fileController@image');
Route::get('verifikasi/{kode}/{username}','backend\UserController@aktivation_account');
Route::get('lang/{lang}', 'bahasaController@swap');
