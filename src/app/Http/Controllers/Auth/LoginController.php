<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $this->credentials($request);

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'password' => [trans('auth.failed')],
            ]);
        }
    }

    // 他のメソッドやロジックもここに追加

}