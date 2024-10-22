<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
// Route::get('/', [WelcomeController::class, 'index']);

Route::pattern('id', '[0-9]+');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('signup', [RegistrationController::class, 'registration'])->name('signup');
Route::post('signup', [RegistrationController::class, 'store']);

Route::middleware(['auth'])->group(function () {
// Route::middleware(['authorize:ADM,MNG'])->group(function () {

    // Route::get('/', [UserController::class, 'index']); //halaman awal
    Route::get('/', [WelcomeController::class, 'index']); //halaman awal
    
    Route::group(['middleware' => 'authorize:ADM,MNG,STF,CUS'], function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::patch('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });    



    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    //Semua route di grup ini harus punya role ADM (Administrator)
    Route::group(['prefix' => 'level', 'middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [LevelController::class, 'index']);                             //menampilkan laman awal level
        Route::post('/list', [LevelController::class, 'list']);                         //menampilkan data level dalam bentuk json untuk datatables
        Route::get('/create', [LevelController::class, 'create']);                      //menampilkan laman form tambah user
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);            //menampilkan laman form tambah level AJAX
        Route::post('/ajax', [LevelController::class, 'store_ajax']);                   //menyimpan data level baru AJAX
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);           //menampilkan laman form edit level AJAX
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);       //menyimpan perubahan data level AJAX
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);      //menampilkan form confirm hapus data level AJAX
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);    //menghapus data level AJAX
        Route::get('/import', [LevelController::class, 'import']);                      // ajax form upload excel
        Route::post('/import_ajax', [LevelController::class, 'import_ajax']);           // ajax import excel
        Route::get('/export_excel', [LevelController::class, 'export_excel']);          // ajax import excel
        Route::get('/export_pdf', [LevelController::class, 'export_pdf']);              // ajax export pdf
    });

    Route::group(['prefix' => 'user', 'middleware'=> 'authorize:ADM'], function(){
        Route::get('/', [UserController::class, 'index']);                          //menampilkan laman awal user
        Route::post('/list', [UserController::class, 'list']);                      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);                   //menampilkan laman form tambah user
        Route::post('/', [UserController::class, 'store']);                         //menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);         //menampilkan laman form tambah user AJAX
        Route::post('/ajax', [UserController::class, 'store_ajax']);                //menyimpan data user baru AJAX
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);                      //menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);                  //menampilkan laman form edit user
        Route::put('/{id}', [UserController::class, 'update']);                     //menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);        //menampilkan laman form edit user AJAX
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);    //menyimpan perubahan data user AJAX
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);   //menampilkan form confirm hapus data user AJAX
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //menghapus data user AJAX
        Route::delete('/{id}', [UserController::class, 'destroy']);                 //menghapus data user
        Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [UserController::class, 'export_excel']); // ajax import excel
        Route::get('/export_pdf', [UserController::class, 'export_pdf']); // ajax export pdf        
    });

    //Semua route di grup ini harus punya role ADM (Administrator) dan MNG (Manager)
    Route::group(['prefix' => 'kategori', 'middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [KategoriController::class, 'index']);                              //menampilkan laman awal kategori
        Route::post('/list', [KategoriController::class, 'list']);                          //menampilkan data kategori dalam bentuk json untuk datatables
        Route::get('/create', [KategoriController::class, 'create']);                          //menampilkan laman form tambah user
        Route::post('/', [KategoriController::class, 'store']);
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);             //menampilkan laman form tambah kategori AJAX
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);                    //menyimpan data kategori baru AJAX
        Route::get('/{id}', [KategoriController::class, 'show']);
        Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);            //menampilkan laman form edit kategori AJAX
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);        //menyimpan perubahan data kategori AJAX
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);       //menampilkan form confirm hapus data kategori AJAX
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);     //menghapus data kategori AJAX
        Route::get('/import', [KategoriController::class, 'import']);                       // ajax form upload excel
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax']);            // ajax import excel
        Route::get('/export_excel', [KategoriController::class, 'export_excel']);           // ajax import excel
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);               // ajax export pdf
    });

    //Semua route di grup ini harus punya role ADM (Administrator)
    Route::group(['prefix' => 'supplier', 'middleware'=> 'authorize:ADM'], function(){
        Route::get('/', [SupplierController::class, 'index']);                              //menampilkan laman awal supplier
        Route::post('/list', [SupplierController::class, 'list']);                          //menampilkan data supplier dalam bentuk json untuk datatables
        Route::get('/create', [SupplierController::class, 'create']);                          //menampilkan laman form tambah user
        Route::post('/', [SupplierController::class, 'store']);
        Route::get('/{id}', [SupplierController::class, 'show']);
        Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);             //menampilkan laman form tambah supplier AJAX
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);                    //menyimpan data supplier baru AJAX
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);            //menampilkan laman form edit supplier AJAX
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);        //menyimpan perubahan data supplier AJAX
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);       //menampilkan form confirm hapus data supplier AJAX
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);     //menghapus data supplier AJAX
        Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
        Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
        Route::get('/export_excel', [SupplierController::class, 'export_excel']); // ajax import excel
        Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); // ajax export pdf
    });

    //Semua route di grup ini harus punya role ADM (Administrator) dan MNG (Manager)
    Route::group(['prefix' => 'barang', 'middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [BarangController::class, 'index']);                                //menampilkan laman awal barang
        Route::post('/list', [BarangController::class, 'list']);                            //menampilkan data barang dalam bentuk json untuk datatables
        Route::get('/create', [BarangController::class, 'create']);                          //menampilkan laman form tambah user
        Route::post('/', [BarangController::class, 'store']);
        Route::get('/{id}', [BarangController::class, 'show']);
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']);               //menampilkan laman form tambah barang AJAX
        Route::post('/ajax', [BarangController::class, 'store_ajax']);                      //menyimpan data barang baru AJAX
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);              //menampilkan laman form edit barang AJAX
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);          //menyimpan perubahan data barang AJAX
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);         //menampilkan form confirm hapus data barang AJAX
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);       //menghapus data barang AJAX
        Route::get('/import', [BarangController::class, 'import']);                         //ajax form upload excel
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']);              //ajax import excel
        Route::get('/export_excel', [BarangController::class, 'export_excel']);             //ajax export excel
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']);                 //ajax export pdf                // ajax export pdf
    });

    //STOK BARANG
    
    Route::group(['prefix' => 'stok', 'middleware'=> 'authorize:ADM,MNG'], function(){
        Route::get('/', [StokController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/list', [StokController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
        Route::get('/create', [StokController::class, 'create']);   // menampilkan halaman form tambah stok
        Route::get('/create_ajax', [StokController::class, 'create_ajax']);
        Route::post('/ajax', [StokController::class, 'store_ajax']);
        Route::post('/', [StokController::class, 'store']);         // menyimpan data stok baru
        Route::get('/{id}', [StokController::class, 'show']);       // menampilkan detail stok
        Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
        Route::get('/{id}/edit', [StokController::class, 'edit']);  // menampilkan halaman form edit stok
        Route::put('/{id}', [StokController::class, 'update']);     // menyimpan perubahan data stok
        Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
        Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data stok
        Route::get('/import', [StokController::class, 'import']);                         //ajax form upload excel
        Route::post('/import_ajax', [StokController::class, 'import_ajax']);              //ajax import excel
        Route::get('/export_excel', [StokController::class, 'export_excel']);             //ajax export excel
        Route::get('/export_pdf', [StokController::class, 'export_pdf']);                 //ajax export pdf
    });

    // masukkan rooute yang perlu diautentikasi disini
    // Route::group(['prefix' => 'user', 'middleware' => 'authorize:ADM'], function () {
    //     Route::get('/', [UserController::class, 'index']); //halaman awal
    //     Route::post('/list', [UserController::class, 'list']);  //data user (json)
    //     Route::get('/create', [UserController::class, 'create']); //form tambah user
    //     Route::post('/', [UserController::class, 'store']); //data user baru
    //     Route::get('/create_ajax', [UserController::class, 'create_ajax']); //form tambah user ajax
    //     Route::post('/ajax', [UserController::class, 'store_ajax']); //simpan data user baru ajax
    //     Route::get('/{id}', [UserController::class, 'show']); //detail user
    //     Route::get('/{id}/edit', [UserController::class, 'edit']); //form edit
    //     Route::put('/{id}', [UserController::class, 'update']); // simpan perubahan data
    //     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //tampilkan form edit dengan ajax
    //     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //simpan perubahan user ajax
    //     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //confirm delete ajax
    //     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //hapus ajax
    //     Route::delete('/{id}', [UserController::class, 'destroy']); //hapus data user
    //     Route::get('/import', [UserController::class, 'import']); // Form upload Excel
    //     Route::post('/import_ajax', [UserController::class, 'import_ajax']); // Ajax import Excel
    //     Route::get('/export_excel', [UserController::class, 'export_excel']); // Cetak Excel
    //     Route::get('/export_pdf', [UserController::class, 'export_pdf']); // Cetak Excel
    // });

    // Route::group(['prefix' => 'level', 'middleware' => 'authorize:ADM,MNG'], function () {
    //     Route::get('/', [LevelController::class, 'index']); //halaman awal
    //     Route::post('/list', [LevelController::class, 'list']);  //data user (json)
    //     Route::get('/create', [LevelController::class, 'create']); //form tambah user
    //     Route::post('/', [LevelController::class, 'store']); //data user baru
    //     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); //form tambah user ajax
    //     Route::post('/ajax', [LevelController::class, 'store_ajax']); //simpan data user baru ajax
    //     Route::get('/{id}', [LevelController::class, 'show']); //detail user
    //     Route::get('/{id}/edit', [LevelController::class, 'edit']); //form edit
    //     Route::put('/{id}', [LevelController::class, 'update']); // simpan perubahan data
    //     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); //tampilkan form edit dengan ajax
    //     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); //simpan perubahan user ajax
    //     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //confirm delete ajax
    //     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); //hapus ajax
    //     Route::delete('/{id}', [LevelController::class, 'destroy']); //hapus data user
    //     Route::get('/import', [LevelController::class, 'import']); // Form upload Excel
    //     Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // Ajax import Excel
    //     Route::get('/export_excel', [LevelController::class, 'export_excel']); // Cetak Excel
    //     Route::get('/export_pdf', [LevelController::class, 'export_pdf']); // Cetak Excel
    // });

    // Route::group(['prefix' => 'kategori', 'middleware' => 'authorize:ADM,MNG'], function () {
    //     Route::get('/', [KategoriController::class, 'index']); //halaman awal
    //     Route::post('/list', [KategoriController::class, 'list']);  //data user (json)
    //     Route::get('/create', [KategoriController::class, 'create']); //form tambah user
    //     Route::post('/', [KategoriController::class, 'store']); //data user baru
    //     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //form tambah user ajax
    //     Route::post('/ajax', [KategoriController::class, 'store_ajax']); //simpan data user baru ajax
    //     Route::get('/{id}', [KategoriController::class, 'show']); //detail user
    //     Route::get('/{id}/edit', [KategoriController::class, 'edit']); //form edit
    //     Route::put('/{id}', [KategoriController::class, 'update']); // simpan perubahan data
    //     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //tampilkan form edit dengan ajax
    //     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); //simpan perubahan user ajax
    //     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //confirm delete ajax
    //     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); //hapus ajax
    //     Route::delete('/{id}', [KategoriController::class, 'destroy']); //hapus data user
    //     Route::get('/import', [KategoriController::class, 'import']); // Form upload Excel
    //     Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // Ajax import Excel
    //     Route::get('/export_excel', [KategoriController::class, 'export_excel']); // Cetak Excel
    //     Route::get('/export_pdf', [KategoriController::class, 'export_pdf']); // Cetak Excel
    // });

    // Route::group(['prefix' => 'supplier', 'middleware' => 'authorize:ADM'], function () {
    //     Route::get('/', [SupplierController::class, 'index']); //halaman awal
    //     Route::post('/list', [SupplierController::class, 'list']);  //data user (json)
    //     Route::get('/create', [SupplierController::class, 'create']); //form tambah user
    //     Route::post('/', [SupplierController::class, 'store']); //data user baru
    //     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); //form tambah user ajax
    //     Route::post('/ajax', [SupplierController::class, 'store_ajax']); //simpan data user baru ajax
    //     Route::get('/{id}', [SupplierController::class, 'show']); //detail user
    //     Route::get('/{id}/edit', [SupplierController::class, 'edit']); //form edit
    //     Route::put('/{id}', [SupplierController::class, 'update']); // simpan perubahan data
    //     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //tampilkan form edit dengan ajax
    //     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); //simpan perubahan user ajax
    //     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //confirm delete ajax
    //     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); //hapus ajax
    //     Route::delete('/{id}', [SupplierController::class, 'destroy']); //hapus data user
    //     Route::get('/import', [SupplierController::class, 'import']); // Form upload Excel
    //     Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // Ajax import Excel
    //     Route::get('/export_excel', [SupplierController::class, 'export_excel']); // Cetak Excel
    //     Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); // Cetak Excel
    // });

    // Route::group(['prefix' => 'barang', 'middleware'=>['authorize:ADM,MNG']], function () {
    //     Route::get('/', [BarangController::class, 'index']); //halaman awal
    //     Route::post('/list', [BarangController::class, 'list']);  //data user (json)
    //     Route::get('/create', [BarangController::class, 'create']); //form tambah user
    //     Route::post('/', [BarangController::class, 'store']); //data user baru
    //     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //form tambah user ajax
    //     Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); //simpan data user baru ajax
    //     Route::get('/{id}', [BarangController::class, 'show']); //detail user
    //     Route::get('/{id}/edit', [BarangController::class, 'edit']); //form edit
    //     Route::put('/{id}', [BarangController::class, 'update']); // simpan perubahan data
    //     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); //tampilkan form edit dengan ajax
    //     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); //simpan perubahan user ajax
    //     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); //confirm delete ajax
    //     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); //hapus ajax
    //     Route::delete('/{id}', [BarangController::class, 'destroy']); //hapus data user
    //     Route::get('/import', [BarangController::class, 'import']); // Form upload Excel
    //     Route::post('/import_ajax', [BarangController::class, 'import_ajax']); // Ajax import Excel
    //     Route::get('/export_excel', [BarangController::class, 'export_excel']); // Cetak Excel
    //     Route::get('/export_pdf', [BarangController::class, 'export_pdf']); // Cetak Excel
    // });
});