<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Sleep;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;

class Register extends Component
{
    public $name                  = '';
    public $email                 = '';
    public $password              = '';
    public $password_confirmation = '';
    public $isAdmin               = false;

    function register()
    {
        $validated = $this->validate((new RegisterRequest())->rules());

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'isAdmin'  => $validated['isAdmin'] ?? false,
        ]);

        session()->flash('status', 'Registro completado. Entra con tus credenciales.');

        Sleep::for(2)->seconds();

        return $this->redirectRoute('session.create', navigate: true);
    }
}
