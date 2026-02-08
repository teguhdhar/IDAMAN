<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanDonasiController;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(ProgramController::class)->group(function () {
    Route::get('/program', 'index')->name('program.index');
    Route::post('/program', 'store')->name('program.store');
     Route::get('/program/{id}/edit', 'edit')->name('program.edit');
    Route::put('/program/{id}', 'update')->name('program.update');
    Route::delete('/program/{id}', 'destroy')->name('program.destroy');
});
Route::controller(DonasiController::class)->group(function () {
    Route::get('/donasi', 'index')->name('donasi.index');
    Route::post('/donasi', 'store')->name('donasi.store');
    Route::get('/donasi/{id}/edit', 'edit')->name('donasi.edit');
    Route::put('/donasi/{id}', 'update')->name('donasi.update');
    Route::delete('/donasi/{id}', 'destroy')->name('donasi.destroy');
});
Route::controller(PengeluaranController::class)->group(function () {
    Route::get('/pengeluaran', 'index')->name('pengeluaran.index');
    Route::post('/pengeluaran', 'store')->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}/edit', 'edit')->name('pengeluaran.edit');
    Route::put('/pengeluaran/{id}', 'update')->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', 'destroy')->name('pengeluaran.destroy');
});
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index');
    Route::post('/dashboard', 'store');
});
Route::controller(LaporanDonasiController::class)->group(function () {
    Route::get('/laporan/donasi', 'index')->name('laporan.donasi');
    Route::get('/laporan/donasi/pdf', 'pdf')->name('laporan.donasi.pdf');
});

// Route::controller(LaporanController::class)->group(function () {
//     Route::get('/laporan/program', [LaporanController::class, 'index']);
//     Route::get('/laporan/program/filter', [LaporanController::class, 'filter']);
//     Route::get('/laporan/program/{id}', [LaporanController::class, 'show']);
//     Route::post('/laporan/all', [LaporanController::class, 'all'])->name('laporan.all');
// });
Route::controller(LaporanController::class)->group(function () {

    Route::get('/laporan', 'index')->name('laporan.index');

    Route::post('/laporan/program/filter', 'filter')
        ->name('laporan.filter');

    Route::get('/laporan/program/{id}/pdf', 'programPdf')
        ->name('laporan.program.pdf');

    Route::get('/laporan/program/{id}', 'program')
        ->name('laporan.program');

});

