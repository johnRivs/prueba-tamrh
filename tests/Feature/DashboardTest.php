<?php

namespace Tests\Feature;

use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\Dashboard;

class DashboardTest extends TestCase
{
    /** @test */
    function filtered_names_returns_all_names_when_search_is_empty()
    {
        Livewire::test(Dashboard::class)
            ->assertSet('search', '')
            ->assertSee(['John', 'Jane', 'Peter', 'Mary', 'Robert', 'Laura']);
    }

    /** @test */
    function filtered_names_returns_only_matching_names_when_search_term_is_provided()
    {
        Livewire::test(Dashboard::class)
            ->set('search', 'ohn')
            ->assertSee('John')
            ->assertDontSee(['Jane', 'Peter', 'Mary', 'Robert', 'Laura']);
    }

    /** @test */
    function filtered_names_returns_no_names_when_no_matching_search_term_is_provided()
    {
        Livewire::test(Dashboard::class)
            ->set('search', 'xyz')
            ->assertSee('No results found.')
            ->assertDontSee(['John', 'Jane', 'Peter', 'Mary', 'Robert', 'Laura']);
    }

    /** @test */
    function reset_search_method_resets_search_property_and_dispatches_event()
    {
        Livewire::test(Dashboard::class)
            ->set('search', 'John')
            ->call('resetSearch')
            ->assertSet('search', '')
            ->assertDispatched('resetSearch')
            ->assertSee(['John', 'Jane', 'Peter', 'Mary', 'Robert', 'Laura']);
    }
}
