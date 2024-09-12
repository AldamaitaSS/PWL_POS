<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // tambah data menggunakan Eloquent
        // $data = [
        //     'username' => 'customer 1',
        //     'nama' => 'pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];
        // UserModel::insert($data);

        //update data dengan Eloquent
        $data = [
            'nama' => 'Pelanggan pertama',
        ];
        UserModel::where('username', 'customer 1')->update($data); //update data user

        // ambil semua data dari model UserModel
        $user = UserModel::all(); 
        return view('user', ['data' => $user]);
    }
}
