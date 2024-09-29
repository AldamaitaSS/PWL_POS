<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        // Breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User']
        ];

        // Informasi halaman
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem',
        ];

        $activeMenu = 'user'; // Set menu yang sedang aktif

        // Ambil semua data level untuk digunakan dalam filter level
        $level = LevelModel::all();

        // Tampilkan halaman user.index dengan data yang diperlukan
        return view('user.index', [
            'breadcrumb' => $breadcrumb, 
            'page'       => $page, 
            'level'      => $level, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data user dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        // Ambil data user dan sertakan relasi dengan 'level'
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                          ->with('level');

        // Filter data user berdasarkan 'level_id' jika ada
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        // Kembalikan data dalam format DataTables
        return DataTables::of($users)
            ->addIndexColumn()  // Tambahkan kolom indeks
            ->addColumn('aksi', function ($user) {
                // Tambahkan tombol aksi: Detail, Edit, dan Hapus
                $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // Render kolom aksi sebagai HTML
            ->make(true);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        // Simpan data user baru
        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password), // Enkripsi password
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        // Ambil data user beserta data level-nya
        $user = UserModel::with('level')->find($id);

        // Breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list'  => ['Home', 'User', 'Detail']
        ];

        // Informasi halaman
        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // Set menu yang sedang aktif

        // Tampilkan halaman user.show dengan data yang diperlukan
        return view('user.show', [
            'breadcrumb' => $breadcrumb, 
            'page'       => $page, 
            'user'       => $user, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        // Breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        // Informasi halaman
        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        // Ambil data level untuk dropdown pilihan level
        $level = LevelModel::all();
        $activeMenu = 'user'; // Set menu yang sedang aktif

        // Tampilkan halaman user.create dengan data yang diperlukan
        return view('user.create', [
            'breadcrumb' => $breadcrumb, 
            'page'       => $page, 
            'level'      => $level, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan form untuk mengedit user
    public function edit(string $id)
    {
        // Ambil data user berdasarkan id
        $user = UserModel::find($id);

        // Ambil semua data level untuk dropdown pilihan level
        $level = LevelModel::all();

        // Breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list'  => ['Home', 'User', 'Edit']
        ];

        // Informasi halaman
        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user'; // Set menu yang sedang aktif

        // Tampilkan halaman user.edit dengan data yang diperlukan
        return view('user.edit', [
            'breadcrumb' => $breadcrumb, 
            'page'       => $page, 
            'user'       => $user, 
            'level'      => $level, 
            'activeMenu' => $activeMenu
        ]);
    }

    // Memperbarui data user yang sudah ada
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'username'  => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'      => 'required|string|max:100',
            'password'  => 'required|min:5',
            'level_id'  => 'required|integer'
        ]);

        // Update data user berdasarkan id
        UserModel::find($id)->update([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus user
    public function destroy(string $id)
    {
        // Cek apakah user dengan id tersebut ada
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            // Hapus data user
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terkait dengan tabel lain');
        }
    }
}
