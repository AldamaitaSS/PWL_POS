<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
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

// level
Route::get('/level', [LevelController::class, 'index']);
// kategori
Route::get('/kategori', [KategoriController::class, 'index']);
//user
Route::get('/user', [UserController::class, 'index']);

//tambah
Route::get('/user/tambah', [UserController::class, 'tambah']);
//tambah_simpan
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

//ubah
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
//ubah_simpan
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
//delete
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Jobsheet 5 - prak 2
Route::get('/', [WelcomeController::class,'index']);

// index
Route::get('/', [WelcomeController::class, 'index']);

// User
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);         // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);     // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class,'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);        // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class,'create_ajax']);   // menampilkan halaman form tambah user ajax
    Route::post('/ajax', [UserController::class,'store_ajax']);   // menyimpan data user baru ajax
    Route::get('/{id}', [UserController::class,'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class,'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class,'update']);  // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class,'edit_ajax']);       // menampilkan halaman form edit user ajax
    Route::put('/{id}/update_ajax', [UserController::class,'update_ajax']);  // menyimpan perubahan data user ajax
    Route::get('/{id}/delete_ajax', [UserController::class,'confirm_ajax']);       // untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax', [UserController::class,'delete_ajax']);       // Untuk hapus data user ajax
    Route::put('/{id}', [UserController::class, 'update']);    // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);  // menghapus data user
});

// Level
Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class, 'index']); //halaman awal
    Route::post('/list', [LevelController::class, 'list']);  //data user (json)
    Route::get('/create', [LevelController::class, 'create']); //form tambah user
    Route::post('/', [LevelController::class, 'store']); //data user baru
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); //form tambah user ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']); //simpan data user baru ajax
    Route::get('/{id}', [LevelController::class, 'show']); //detail user
    Route::get('/{id}/edit', [LevelController::class, 'edit']); //form edit
    Route::put('/{id}', [LevelController::class, 'update']); // simpan perubahan data
    Route::get('/{id}/edit_ajax', [LevelController::class,'edit_ajax']); //tampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); //simpan perubahan user ajax
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //confirm delete ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); //hapus ajax
    Route::delete('/{id}', [LevelController::class, 'destroy']); //hapus data user
});

// Kategori
Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class, 'index']); //halaman awal
    Route::post('/list', [KategoriController::class, 'list']);  //data user (json)
    Route::get('/create', [KategoriController::class, 'create']); //form tambah user
    Route::post('/', [KategoriController::class, 'store']); //data user baru
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //form tambah user ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']); //simpan data user baru ajax
    Route::get('/{id}', [KategoriController::class, 'show']); //detail user
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); //form edit
    Route::put('/{id}', [KategoriController::class, 'update']); // simpan perubahan data
    Route::get('/{id}/edit_ajax', [KategoriController::class,'edit_ajax']); //tampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); //simpan perubahan user ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //confirm delete ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); //hapus ajax
    Route::delete('/{id}', [KategoriController::class, 'destroy']); //hapus data user
});

// Supplier
Route::group(['prefix' => 'supplier'], function(){
    Route::get('/', [SupplierController::class, 'index']); //halaman awal
    Route::post('/list', [SupplierController::class, 'list']);  //data user (json)
    Route::get('/create', [SupplierController::class, 'create']); //form tambah user
    Route::post('/', [SupplierController::class, 'store']); //data user baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); //form tambah user ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); //simpan data user baru ajax
    Route::get('/{id}', [SupplierController::class, 'show']); //detail user
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); //form edit
    Route::put('/{id}', [SupplierController::class, 'update']); // simpan perubahan data
    Route::get('/{id}/edit_ajax', [SupplierController::class,'edit_ajax']); //tampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); //simpan perubahan user ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //confirm delete ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); //hapus ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']); //hapus data user
});

// Barang
Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class, 'index']); //halaman awal
    Route::post('/list', [BarangController::class, 'list']);  //data user (json)
    Route::get('/create', [BarangController::class, 'create']); //form tambah user
    Route::post('/', [BarangController::class, 'store']); //data user baru
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //form tambah user ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']); //simpan data user baru ajax
    Route::get('/{id}', [BarangController::class, 'show']); //detail user
    Route::get('/{id}/edit', [BarangController::class, 'edit']); //form edit
    Route::put('/{id}', [BarangController::class, 'update']); // simpan perubahan data
    Route::get('/{id}/edit_ajax', [BarangController::class,'edit_ajax']); //tampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); //simpan perubahan user ajax
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //confirm delete ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); //hapus ajax
    Route::delete('/{id}', [BarangController::class, 'destroy']); //hapus data user
});