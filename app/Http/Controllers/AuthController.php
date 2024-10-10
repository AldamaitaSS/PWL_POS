<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller{
    public function login(){
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home
        return redirect('/');
        }
        return view('auth.login');
    }
    
    public function postlogin(Request $request){
        if($request->ajax() || $request->wantsJson()){
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'redirect' => url('/')
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }
    
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function register()
    {
        return view('auth.register');
    }
    
    public function postRegister(Request $request)
    {
        Log::info('Registration attempt started', ['data' => $request->all()]);

        if ($request->ajax() || $request->wantsJson()) {
            try {
                Log::info('Validating data');
                $validatedData = $request->validate([
                    'username' => 'required|string|min:3|unique:m_user,username',
                    'name' => 'required|string|max:100',
                    'password' => 'required|min:5',
                ]);
                Log::info('Validation passed');

                Log::info('Attempting to create user');
                $user = UserModel::create([
                    'username' => $validatedData['username'],
                    'name' => $validatedData['name'],
                    'password' => bcrypt($validatedData['password']),
                    'level_id' => 3
                ]);
                Log::info('User created successfully', ['user_id' => $user->id]);

                return response()->json([
                    'status' => true,
                    'message' => 'Register Berhasil',
                    'redirect' => url('/login')
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('Validation failed', ['errors' => $e->errors()]);
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                Log::error('Registration failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage(),
                ], 500);
            }
        }
        Log::warning('Non-AJAX request to registration endpoint');
        return redirect('register');

    }
}