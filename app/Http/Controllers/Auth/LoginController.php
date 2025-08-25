<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectPath());
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
