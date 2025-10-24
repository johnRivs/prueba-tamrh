<?php

namespace Tests\Auth;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Sleep;
use App\Livewire\Auth\Register;

class RegisterTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();

        Sleep::fake();
    }

    /** @test */
    function users_can_register()
    {
        $this->get('/register')
            ->assertSeeLivewire(Register::class);

        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertRedirectToRoute('session.create');

        $this->assertTrue(session()->has('status'));
        $this->assertCount(1, User::all());
        $this->assertDatabaseHas('users', [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    function password_must_be_at_least_8_characters()
    {
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('register')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    function an_authenticated_user_is_redirected_from_the_register_page()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('register'))
            ->assertRedirect(route('dashboard'));
    }
}
