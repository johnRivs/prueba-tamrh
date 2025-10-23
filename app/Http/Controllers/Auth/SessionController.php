<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Logout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secretKey'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (! $response->json('success')) return back()->withErrors(['g-recaptcha-response' => "Couldn't verify you're not a robot."]);

        if (! Auth::attempt($request->only(['email', 'password']), $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'The provided credentials do not match our records.']);
        }

        Session::regenerate();

        return redirect()->route('dashboard');
    }

    function destroy(Logout $action)
    {
        $action->handle();

        return redirect('/');
    }
}
