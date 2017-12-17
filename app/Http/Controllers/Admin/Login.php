<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\LoginValidation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

/**
 * Login controller
 */
class Login extends Controller {

    public function index() {
        return view('admin.login');
    }

    public function auth(LoginValidation $request) {

        if (Auth::attempt(['name' => $request->input('login'), 'password' => $request->input('password')])) {

            return redirect('/admin/start');
        } else {
            return redirect('/admin/login')->withErrors(array('Niepoprawny login lub hasło'));
        }
    }

    public function createUser() {
        $data = array(
            'id' => null,
            'name' => 'robot',
            'email' => 'krspawlicki@gmail.com',
            'roles' => 1,
            'password' => Hash::make('RobotHaslo123'),
            'remember_token' => ''
        );
        User::create($data);
        echo "dodany";
    }

    public function logout() {
        Auth::logout();
        return redirect('/admin/login');
    }

}
