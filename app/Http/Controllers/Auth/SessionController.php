<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    function create()
    {
        return view('auth.login');
    }

    function store(LoginRequest $request)
    {
        if (! Auth::attempt($request->only(['email', 'password']), $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'The provided credentials do not match our records.']);
        }

        Session::regenerate();

        return redirect()->route('dashboard');
    }

    function destroy()
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
