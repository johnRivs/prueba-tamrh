<?php

namespace Tests\Auth;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /** @test */
    function a_user_can_logout()
    {
        $this->actingAs(User::factory()->create())
            ->delete(route('session.destroy'));

        $this->assertGuest();
    }

    /** @test */
    function a_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $this->post(route('session.store'), [
            'email'    => 'john@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function a_user_cannot_login_with_invalid_credentials()
    {
        $this->withExceptionHandling();

        User::factory()->create(['email' => 'john@example.com']);

        $this->post(route('session.store'), [
            'email'    => 'john@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    /** @test */
    function a_user_can_login_with_remember_me()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $this->post(route('session.store'), [
            'email'    => 'john@example.com',
            'password' => 'password',
            'remember' => 'on',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull(auth()->user()->remember_token);
    }
}
