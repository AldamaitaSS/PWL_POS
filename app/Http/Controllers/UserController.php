<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // PRAK 2.1
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);
        
        // $user = UserModel::where('level_id', 1) -> first();
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstWhere('level_id', 1);
        // return view('user', ['data' => $user]);

        // $user = UserModel::findOr(1, ['username', 'nama'], function() {
        //     abort(404);
        // });
        // return view('user', ['data' => $user]);

        // $user = UserModel::findOr(20, ['username', 'nama'], function() {
        //     abort(404);
        // });
        // return view('user', ['data' => $user]);

        //PRAK 2.2
        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);

        // $user = UserModel::where('username', 'manager9') ->firstOrFail();
        // return view('user', ['data' => $user]);

        // PRAK 2.3
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view('user', ['data' => $user]);

        // $userCount = UserModel::where('level_id', 2)->count();
        // return view('user', ['userCount' => $userCount]);

        //PRAK 2.4
        // $user = UserModel::firstOrcreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        //     ],
        // );
       
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user', ['data' => $user]);

        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
        );
        $user->save();
        return view('user', ['data' => $user]);
    }
}
