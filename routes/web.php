<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MmController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login')->middleware('guest');
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('dologin', 'dologin')->middleware('guest');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('role:admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('admin', 'index')->name('admin');
        Route::get('admin/dashboard', 'index');
        Route::get('admin/laporan-manager', 'manager');
        Route::get('admin/laporan-marketing/laporan-harian', 'laporanH');
        Route::get('admin/laporan-marketing/laporan-mingguan', 'laporanM');
        Route::get('admin/laporan-marketing/laporan-harian/{type}', 'laporanMmHarian')->name('laporanHarian');
        Route::get('admin/laporan-marketing/laporan-mingguan/{type}', 'laporanMmMingguan')->name('laporanMingguan');
        Route::get('admin/add-user', 'adduser');
        Route::post('doadduser', 'doadduser')->name('doadduser');
    });
});

Route::middleware('role:mm')->group(function () {
    Route::controller(MmController::class)->group(function () {
        Route::get('manager-marketing', 'index');
        Route::get('manager-marketing/dashboard', 'index');
        Route::get('manager-marketing/marketing', 'marketing')->name('marketing');

        Route::get('manager-marketing/laporan-harian-marketing', 'harian');
        Route::post('manager-marketing/laporan-harian-marketing/{id}/approve', 'happrove')->name('harian.approve');
        Route::post('manager-marketing/laporan-harian-marketing/{id}/reject', 'hreject')->name('harian.reject');
        Route::get('manager-marketing/laporan-harian-marketing/sakinah', 'hariansakinah')->name('harian.sakinah');
        Route::get('manager-marketing/laporan-harian-marketing/savill', 'hariansavill')->name('harian.savill');
        Route::get('manager-marketing/laporan-harian-marketing/triehans', 'hariantriehans')->name('harian.triehans');

        Route::get('manager-marketing/laporan-mingguan-marketing', 'mingguan');
        Route::post('manager-marketing/laporan-mingguan-marketing/{id}/approve', 'mapprove')->name('mingguan.approve');
        Route::post('manager-marketing/laporan-mingguan-marketing/{id}/reject', 'mreject')->name('mingguan.reject');
        Route::get('manager-marketing/laporan-mingguan-marketing/sakinah', 'mingguansakinah')->name('mingguan.sakinah');
        Route::get('manager-marketing/laporan-mingguan-marketing/savill', 'mingguansavill')->name('mingguan.savill');
        Route::get('manager-marketing/laporan-mingguan-marketing/triehans', 'mingguantriehans')->name('mingguan.triehans');
    });
});

Route::middleware('role:marketing')->group(function () {
    Route::controller(MarketingController::class)->group(function () {
        Route::get('marketing', 'index')->name('marketing');
        Route::get('marketing/dashboard', 'index');

        Route::get('marketing/harian', 'harian')->name('harian');
        Route::post('marketing/addharian', 'addharian')->name('addharian');
        Route::get('marketing/harian/{id}/edit', 'harianedit')->name('harian.edit');
        Route::put('marketing/harian/{id}', 'harianupdate')->name('harian.update');
        Route::delete('marketing/harian/{id}', 'hariandestroy')->name('harian.destroy');

        Route::get('marketing/mingguan', 'mingguan')->name('mingguan');
        Route::post('marketing/addmingguan', 'addmingguan')->name('addmingguan');
        Route::get('marketing/mingguan/{id}/edit', 'mingguanedit')->name('mingguan.edit');
        Route::put('marketing/mingguan/{id}', 'mingguanupdate')->name('mingguan.update');
        Route::delete('marketing/mingguan/{id}', 'mingguandestroy')->name('mingguan.destroy');
    });
});

Route::middleware('role:admin')->group(function () {
    Route::controller(ExportController::class)->group(function () {
        Route::get('admin/laporan-marketing/laporan-harian/export-excel/{type}', 'exportExcelH')->name('harian.export.excel');
        Route::get('admin/laporan-marketing/laporan-harian/export-pdf/{type}', 'exportPDFH')->name('harian.export.pdf');
        Route::get('admin/laporan-marketing/laporan-mingguan/export-excel/{type}', 'exportExcelM')->name('mingguan.export.excel');
        Route::get('admin/laporan-marketing/laporan-mingguan/export-pdf/{type}', 'exportPDFM')->name('mingguan.export.pdf');
    });
});
