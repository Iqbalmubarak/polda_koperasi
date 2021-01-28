<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Sentinel;
use Activation;

class RegisterController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
      //fungsi cek untuk mengetahui user sudah login atau belum
      if(Sentinel::check()){
        return redirect()->back();
      }else{
        return view('auth.register');
      }
    }

    protected function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50|unique:users,email',
            'username' => 'required|string|max:20|unique:users,username',
            'password' => 'required|string|min:8|same:password_confirmation',
        ]);

        $data = $request->all();
        $user = User::create([
            'first_name'    => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'    => $data['email'],
            'username'    => $data['username'],
            'password' => bcrypt($request->password),
        ]);

        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);
        $user->roles()->sync(2);
        if ($user = Sentinel::authenticate(['email'=>$data['email'],'password'=>$data['password']],false))
        {
           Log::info('ip '.\Request::ip().' Mendaftarkan Ke Aplikasi ');
           return redirect('/dashboard');
        }
    }
}
