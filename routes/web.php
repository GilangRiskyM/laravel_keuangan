<?php

use App\Http\Controllers\KuitansiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/pemasukan', [PemasukanController::class, 'index']);
Route::get('/pemasukan/tambah', [PemasukanController::class, 'create']);
Route::post('/tambah-pemasukan', [PemasukanController::class, 'store']);
Route::get('/pemasukan/edit/{id}', [PemasukanController::class, 'edit']);
Route::put('/edit-pemasukan/{id}', [PemasukanController::class, 'update']);
Route::get('/pemasukan/hapus/{id}', [PemasukanController::class, 'delete']);
Route::delete('/destroy-pemasukan/{id}', [PemasukanController::class, 'destroy']);
Route::get('/pemasukan/restore', [PemasukanController::class, 'deletedPemasukan']);
Route::get('/restore-pemasukan/{id}', [PemasukanController::class, 'restoreData']);
Route::get('/pemasukan/hapus_permanen/{id}', [PemasukanController::class, 'deletePermanen']);
Route::delete('/force_delete-pemasukan/{id}', [PemasukanController::class, 'forceDelete']);
Route::post('/pemasukan/export', [PemasukanController::class, 'export']);

Route::get('/pengeluaran', [PengeluaranController::class, 'index']);
Route::get('/pengeluaran/tambah', [PengeluaranController::class, 'create']);
Route::post('/tambah-pengeluaran', [PengeluaranController::class, 'store']);
Route::get('/pengeluaran/edit/{id}', [PengeluaranController::class, 'edit']);
Route::put('/edit-pengeluaran/{id}', [PengeluaranController::class, 'update']);
Route::get('/pengeluaran/hapus/{id}', [PengeluaranController::class, 'delete']);
Route::delete('/destroy-pengeluaran/{id}', [PengeluaranController::class, 'destroy']);
Route::get('/pengeluaran/restore', [PengeluaranController::class, 'deletedPengeluaran']);
Route::get('/restore-pengeluaran/{id}', [PengeluaranController::class, 'restoreData']);
Route::get('/pengeluaran/hapus_permanen/{id}', [PengeluaranController::class, 'deletePermanen']);
Route::delete('/force_delete-pengeluaran/{id}', [PengeluaranController::class, 'forceDelete']);
Route::post('/pengeluaran/export', [PengeluaranController::class, 'export']);

Route::get('/laporan', [LaporanController::class, 'index']);
Route::post('/laporan/export', [LaporanController::class, 'export']);

Route::get('/kuitansi', [KuitansiController::class, 'index']);
Route::get('/kuitansi/tambah/{id}', [KuitansiController::class, 'create']);
Route::post('/tambah-kuitansi', [KuitansiController::class, 'store']);
Route::get('/kuitansi/edit/{id}', [KuitansiController::class, 'edit']);
Route::put('/edit-kuitansi/{id}', [KuitansiController::class, 'update']);
Route::get('/kuitansi/cetak/{id}', [KuitansiController::class, 'cetakKuitansi']);
