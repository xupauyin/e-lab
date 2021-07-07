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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', 'HomeController@test')->name('test');

Route::get('qrlink/{id}', 'Qr\QrController@qrlink')->name('qr.qrlink')->middleware(['laboran', 'koordinator', 'administrator']);

Route::group(['middleware' => 'laboran', 'prefix' => 'laboran'], function () {
    Route::get('', 'Laboran\DashboardController@index')->name('laboran.home');

    Route::get('inventaris/input', 'Laboran\InventarisController@input')->name('laboran.inventaris.input');
    Route::post('inventaris/insert', 'Laboran\InventarisController@store')->name('laboran.inventaris.store');
    Route::get('inventaris', 'Laboran\InventarisController@index')->name('laboran.inventaris.index');
    Route::get('inventaris/edit/{id}', 'Laboran\InventarisController@edit')->name('laboran.inventaris.edit');
    Route::post('inventaris/update/{id}', 'Laboran\InventarisController@update')->name('laboran.inventaris.update');
    Route::get('data_inventaris', 'Laboran\ServiceController@data_inventaris')->name('laboran.data_inventaris');
    Route::get('inventaris/grafik', 'Laboran\InventarisController@grafik')->name('laboran.inventaris.grafik');

    Route::get('maintenance/input', 'Laboran\MaintenanceController@input')->name('laboran.maintenance.input');
    Route::get('maintenance/input/viaqr/{id}', 'Laboran\MaintenanceController@inputqr')->name('laboran.maintenance.inputqr');
    Route::post('maintenance/insert', 'Laboran\MaintenanceController@store')->name('laboran.maintenance.store');
    Route::get('maintenance', 'Laboran\MaintenanceController@index')->name('laboran.maintenance.index');
    Route::get('maintenance/edit/{id}', 'Laboran\MaintenanceController@edit')->name('laboran.maintenance.edit');
    Route::post('maintenance/update/{id}', 'Laboran\MaintenanceController@update')->name('laboran.maintenance.update');
    Route::get('data_maintenance', 'Laboran\ServiceController@data_maintenance')->name('laboran.data_maintenance');
    Route::get('maintenance/grafik', 'Laboran\MaintenanceController@grafik')->name('laboran.maintenance.grafik');

    Route::get('jurnal/input', 'Laboran\JurnalController@input')->name('laboran.jurnal.input');
    Route::post('jurnal/insert', 'Laboran\JurnalController@store')->name('laboran.jurnal.store');
    Route::get('jurnal', 'Laboran\JurnalController@index')->name('laboran.jurnal.index');
    Route::get('jurnal/edit/{id}', 'Laboran\JurnalController@edit')->name('laboran.jurnal.edit');
    Route::post('jurnal/update/{id}', 'Laboran\JurnalController@update')->name('laboran.jurnal.update');

    Route::get('peminjamanalat/input', 'Laboran\PeminjamanAlatController@input')->name('laboran.peminjamanalat.input');
    Route::post('peminjamanalat/insert', 'Laboran\PeminjamanAlatController@store')->name('laboran.peminjamanalat.store');
    Route::get('peminjamanalat', 'Laboran\PeminjamanAlatController@index')->name('laboran.peminjamanalat.index');
    Route::get('peminjamanalat/edit/{id}', 'Laboran\PeminjamanAlatController@edit')->name('laboran.peminjamanalat.edit');
    Route::post('peminjamanalat/update/{id}', 'Laboran\PeminjamanAlatController@update')->name('laboran.peminjamanalat.update');
    Route::get('data_peminjamanalat', 'Laboran\ServiceController@data_peminjamanalat')->name('laboran.data_peminjamanalat');
    Route::get('peminjamanalat/grafik', 'Laboran\PeminjamanAlatController@grafik')->name('laboran.peminjamanalat.grafik');

    Route::get('peminjamanlab/input', 'Laboran\PeminjamanLabController@input')->name('laboran.peminjamanlab.input');
    Route::post('peminjamanlab/insert', 'Laboran\PeminjamanLabController@store')->name('laboran.peminjamanlab.store');
    Route::get('peminjamanlab', 'Laboran\PeminjamanLabController@index')->name('laboran.peminjamanlab.index');
    Route::get('peminjamanlab/edit/{id}', 'Laboran\PeminjamanLabController@edit')->name('laboran.peminjamanlab.edit');
    Route::post('peminjamanlab/update/{id}', 'Laboran\PeminjamanLabController@update')->name('laboran.peminjamanlab.update');

    Route::get('inventaris/laporan_pdf', 'Laboran\InventarisController@laporan_pdf')->name('laboran.inventaris.laporan_pdf');
    Route::get('peminjamanlab/laporan_pdf', 'Laboran\PeminjamanLabController@laporan_pdf')->name('laboran.peminjamanlab.laporan_pdf');
    Route::get('peminjamanalat/laporan_pdf', 'Laboran\PeminjamanAlatController@laporan_pdf')->name('laboran.peminjamanalat.laporan_pdf');
    Route::get('jurnal/laporan_pdf', 'Laboran\JurnalController@laporan_pdf')->name('laboran.jurnal.laporan_pdf');
    Route::get('maintenance/laporan_pdf', 'Laboran\MaintenanceController@laporan_pdf')->name('laboran.maintenance.laporan_pdf');

    Route::post('verifikasi_inventaris', 'Laboran\ServiceController@verifikasi_inventaris')->name('laboran.verifikasi_inventaris');
    Route::post('verifikasi_jurnal', 'Laboran\ServiceController@verifikasi_jurnal')->name('laboran.verifikasi_jurnal');
    Route::post('verifikasi_maintenance', 'Laboran\ServiceController@verifikasi_maintenance')->name('laboran.verifikasi_maintenance');
    Route::post('verifikasi_peminjamanalat', 'Laboran\ServiceController@verifikasi_peminjamanalat')->name('laboran.verifikasi_peminjamanalat');
    Route::post('verifikasi_peminjamanlab', 'Laboran\ServiceController@verifikasi_peminjamanlab')->name('laboran.verifikasi_peminjamanlab');

    Route::get('profil', 'Laboran\ProfilController@index')->name('laboran.profil');
    Route::post('profil/update', 'Laboran\ProfilController@update')->name('laboran.profil.update');
});

Route::group(['middleware' => 'koordinator', 'prefix' => 'koordinator'], function () {
    Route::get('', 'Koordinator\DashboardController@index')->name('koordinator.home');

    Route::get('inventaris', 'Koordinator\InventarisController@index')->name('koordinator.inventaris.index');
    Route::get('inventaris/generateqr/{id}', 'Koordinator\InventarisController@generateqr')->name('koordinator.inventaris.generateqr');
    Route::get('inventaris/qrlink/{id}', 'Koordinator\InventarisController@qrlink')->name('koordinator.inventaris.qrlink');
    Route::get('inventaris/delete/{id}', 'Koordinator\InventarisController@destroy')->name('koordinator.inventaris.destroy');
    Route::get('data_inventaris', 'Koordinator\ServiceController@data_inventaris')->name('koordinator.data_inventaris');
    Route::get('inventaris/grafik', 'Koordinator\InventarisController@grafik')->name('koordinator.inventaris.grafik');

    Route::get('maintenance', 'Koordinator\MaintenanceController@index')->name('koordinator.maintenance.index');
    Route::get('maintenance/delete/{id}', 'Koordinator\MaintenanceController@destroy')->name('koordinator.maintenance.destroy');
    Route::get('data_maintenance', 'Koordinator\ServiceController@data_maintenance')->name('koordinator.data_maintenance');
    Route::get('maintenance/grafik', 'Koordinator\MaintenanceController@grafik')->name('koordinator.maintenance.grafik');

    Route::get('jurnal', 'Koordinator\JurnalController@index')->name('koordinator.jurnal.index');
    Route::get('jurnal/delete/{id}', 'Koordinator\JurnalController@destroy')->name('koordinator.jurnal.destroy');

    Route::get('peminjamanalat', 'Koordinator\PeminjamanAlatController@index')->name('koordinator.peminjamanalat.index');
    Route::get('peminjamanalat/delete/{id}', 'Koordinator\PeminjamanAlatController@destroy')->name('koordinator.peminjamanalat.destroy');
    Route::get('data_peminjamanalat', 'Koordinator\ServiceController@data_peminjamanalat')->name('koordinator.data_peminjamanalat');
    Route::get('peminjamanalat/grafik', 'Koordinator\PeminjamanAlatController@grafik')->name('koordinator.peminjamanalat.grafik');

    Route::get('peminjamanlab', 'Koordinator\PeminjamanLabController@index')->name('koordinator.peminjamanlab.index');
    Route::get('peminjamanlab/delete/{id}', 'Koordinator\PeminjamanLabController@destroy')->name('koordinator.peminjamanlab.destroy');

    Route::post('verifikasi_inventaris', 'Koordinator\ServiceController@verifikasi_inventaris')->name('koordinator.verifikasi_inventaris');
    Route::post('verifikasi_jurnal', 'Koordinator\ServiceController@verifikasi_jurnal')->name('koordinator.verifikasi_jurnal');
    Route::post('verifikasi_maintenance', 'Koordinator\ServiceController@verifikasi_maintenance')->name('koordinator.verifikasi_maintenance');
    Route::post('verifikasi_peminjamanalat', 'Koordinator\ServiceController@verifikasi_peminjamanalat')->name('koordinator.verifikasi_peminjamanalat');
    Route::post('verifikasi_peminjamanlab', 'Koordinator\ServiceController@verifikasi_peminjamanlab')->name('koordinator.verifikasi_peminjamanlab');

    Route::get('profil', 'Koordinator\ProfilController@index')->name('koordinator.profil');
    Route::post('profil/update', 'Koordinator\ProfilController@update')->name('koordinator.profil.update');
});

Route::group(['middleware' => 'administrator', 'prefix' => 'administrator'], function () {
    Route::get('', 'Administrator\DashboardController@index')->name('administrator.home');

    Route::get('inventaris', 'Administrator\InventarisController@index')->name('administrator.inventaris.index');
    Route::get('inventaris/delete/{id}', 'Administrator\InventarisController@destroy')->name('administrator.inventaris.destroy');

    Route::get('maintenance', 'Administrator\MaintenanceController@index')->name('administrator.maintenance.index');
    Route::get('maintenance/delete/{id}', 'Administrator\MaintenanceController@destroy')->name('administrator.maintenance.destroy');

    Route::get('jurnal', 'Administrator\JurnalController@index')->name('administrator.jurnal.index');
    Route::get('jurnal/delete/{id}', 'Administrator\JurnalController@destroy')->name('administrator.jurnal.destroy');

    Route::get('peminjamanalat', 'Administrator\PeminjamanAlatController@index')->name('administrator.peminjamanalat.index');
    Route::get('peminjamanalat/delete/{id}', 'Administrator\PeminjamanAlatController@destroy')->name('administrator.peminjamanalat.destroy');

    Route::get('peminjamanlab', 'Administrator\PeminjamanLabController@index')->name('administrator.peminjamanlab.index');
    Route::get('peminjamanlab/delete/{id}', 'Administrator\PeminjamanLabController@destroy')->name('administrator.peminjamanlab.destroy');

    Route::get('user', 'Administrator\UserController@index')->name('administrator.user.index');
    Route::get('new_user', 'Administrator\UserController@user_create')->name('administrator.new_user');
    Route::get('edit_user/edit/{id}', 'Administrator\UserController@user_edit')->name('administrator.edit_user');
    Route::post('register', 'Administrator\UserController@register')->name('administrator.register');
    Route::post('update_user/update/{id}', 'Administrator\UserController@user_update')->name('administrator.update_user');
    Route::get('user/delete/{id}', 'Administrator\UserController@destroy')->name('administrator.user.destroy');

    Route::get('lab', 'Administrator\LaboratoriumController@index')->name('administrator.lab.index');
    Route::get('new_lab', 'Administrator\LaboratoriumController@lab_create')->name('administrator.new_lab');
    Route::get('edit_lab/edit/{id}', 'Administrator\LaboratoriumController@lab_edit')->name('administrator.edit_lab');
    Route::post('save_lab', 'Administrator\LaboratoriumController@lab_save')->name('administrator.save_lab');
    Route::post('update_lab/update/{id}', 'Administrator\LaboratoriumController@lab_update')->name('administrator.update_lab');
    Route::get('lab/delete/{id}', 'Administrator\LaboratoriumController@destroy')->name('administrator.lab.destroy');

    Route::get('log', 'Administrator\LogController@index')->name('administrator.log.index');

    Route::get('profil', 'Administrator\ProfilController@index')->name('administrator.profil');
    Route::post('profil/update', 'Administrator\ProfilController@update')->name('administrator.profil.update');
});
