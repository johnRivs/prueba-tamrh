<?php

namespace Tests\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SessionTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();

        Http::fakeSequence('*recaptcha*')
            ->push(['success' => true], 200)
            ->push(['success' => false], 200);
    }

    /** @test */
    function a_user_can_logout()
    {
        $this->actingAs(User::factory()->create())
            ->delete(route('session.destroy'));

        $this->assertGuest();
    }

    /** @test */
    function guests_are_redirected_to_login_when_accessing_dashboard()
    {
        $this->withExceptionHandling();

        $this->get(route('dashboard'))
            ->assertRedirect(route('session.create'));
    }

    /** @test */
    function a_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $this->post(route('session.store'), [
            'email'                => 'john@example.com',
            'password'             => 'password',
            'g-recaptcha-response' => 'valid'
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function a_user_cannot_login_with_invalid_credentials()
    {
        $this->withExceptionHandling();

        User::factory()->create(['email' => 'john@example.com']);

        $this->post(route('session.store'), [
            'email'                => 'john@example.com',
            'password'             => 'wrong-password',
            'g-recaptcha-response' => 'valid'
        ])->assertSessionHasErrors(['email']);

        $this->assertGuest();
    }

    /** @test */
    function a_user_can_login_with_remember_me()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $this->post(route('session.store'), [
            'email'                => 'john@example.com',
            'password'             => 'password',
            'remember'             => 'on',
            'g-recaptcha-response' => 'valid'
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull(auth()->user()->remember_token);
    }

    /** @test */
    function recaptcha_verification_for_login_works_as_expected()
    {
        $this->withExceptionHandling();

        $user = User::factory()->create(['email' => 'test@example.com']);

        $this->post(route('session.store'), [
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'g-recaptcha-response'  => 'valid',
        ]);

        $this->assertAuthenticatedAs($user);

        auth()->logout();

        $this->post(route('session.store'), [
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'g-recaptcha-response'  => 'invalid',
        ])->assertSessionHasErrors('g-recaptcha-response');

        $this->assertGuest();
    }

    /** @test */
    function an_authenticated_user_is_redirected_from_the_login_page()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('session.create'))
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    function a_guest_cannot_logout()
    {
        $this->withExceptionHandling();

        $this->delete(route('session.destroy'))
            ->assertRedirect(route('session.create'));
    }
}
