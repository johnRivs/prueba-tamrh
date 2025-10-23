<?php

namespace App\Livewire;

use Illuminate\Container\Attributes\CurrentUser;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    public string $username;
    public string $search = '';
    public array $names   = ['John', 'Jane', 'Peter', 'Mary', 'Robert', 'Laura'];

    function mount(#[CurrentUser] $user)
    {
        $this->username = $user->name;
    }

    #[Computed]
    function filteredNames(): array
    {
        return $this->search
            ? collect($this->names)->filter(fn ($name) => str_contains(strtolower($name), strtolower($this->search)))->all()
            : $this->names;
    }

    function resetSearch()
    {
        $this->search = '';

        $this->dispatch('resetSearch');
    }
}
