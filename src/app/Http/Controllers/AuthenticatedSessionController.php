<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|string|max:191',
            'password' => 'required|min:8|max:191|',
        ],[
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.string' => 'メールアドレスは有効な文字列を使用してください',
            'email.max' => 'メールアドレスは191字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは8字以上で入力してください',
            'password.max' => 'パスワードは191字以内で入力してください',
            'password.confirmed' => 'パスワードが間違っています'
        ]);

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
        return redirect('/');
        }
        return redirect()->back();
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('signIn');
    }
}
