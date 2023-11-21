<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'email|required',
            'password' => 'required'
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
