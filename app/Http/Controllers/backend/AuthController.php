<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getlogin()
    {
        return view('backend.Auth.Login');
    }
    public function  logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect('login');
        } else {
            return redirect('login');
        }
    }
    public function postlogin(Request $request)
    {


        $this->validate($request, [
            'username' => 'required|exists:ptq_user',
            'password' => 'required|min:3|max:32',
        ], [
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu có ít nhất 3 kí tự',
            'password.max' => 'Mật khẩu tối đa 32 kí tự',
            'username.required' => 'Bạn chưa nhập tên tài khoản',
            'username.exists' => 'Tài khoản của bạn không tồn tại trong hệ thống',
        ]);
        $username = $request->username;
        $password = $request->password;
        $data = ['username' => $username, 'password' => $password];
        if (Auth::attempt($data)) {

            // echo 'Thanh cong';
            // echo bcrypt($password);

            return redirect()->route('admin.dashboard')->with('message', ['type' => 'success', 'msg' => 'Đăng nhập tài khoản thành công!']);
        } else {
            return redirect('login');
            // echo 'That bai';
            // var_dump($data);
            // echo bcrypt($password);
        }
    }
}
