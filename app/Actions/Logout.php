<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    function handle()
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
