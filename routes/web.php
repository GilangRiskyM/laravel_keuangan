<?php

use App\Http\Controllers\PemasukanController;
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

Route::get('/', function () {
    return view('welcome');
});

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
