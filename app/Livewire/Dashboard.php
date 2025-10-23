<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    public string $search = '';
    public array $names   = ['John', 'Jane', 'Peter', 'Mary', 'Robert', 'Laura'];

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
