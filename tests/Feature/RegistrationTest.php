<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_only_collects_name_and_phone(): void
    {
        $this->get('/register')->assertOk()
            ->assertSee('name="name"', false)
            ->assertSee('name="phone"', false)
            ->assertDontSee('name="username"', false)
            ->assertDontSee('name="email"', false)
            ->assertDontSee('name="password"', false)
            ->assertDontSee('name="birth_month"', false)
            ->assertDontSee('name="birth_day"', false);
    }

    public function test_registration_saves_player_data_without_logging_in(): void
    {
        $this->post('/register', [
            'name' => 'Test Player',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => 'chosen-password',
        ])->assertSessionHasNoErrors()->assertRedirect(route('register'))->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Test Player',
            'username' => '081234567890',
            'role' => 'user',
        ]);
        $user = User::where('username', '081234567890')->firstOrFail();
        $this->assertContains($user->profile_picture, ['panda', 'tiger', 'fox', 'cat', 'rabbit', 'bear', 'koala', 'penguin']);
        $this->assertFalse(\Illuminate\Support\Facades\Hash::check('chosen-password', $user->password));
        $this->assertGuest();
    }

    public function test_registration_requires_name_and_phone(): void
    {
        $this->from('/register')->post('/register', [])
            ->assertRedirect('/register')->assertSessionHasErrors(['name', 'phone']);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_invalid_phone(): void
    {
        $this->post('/register', ['name' => 'Test Player', 'phone' => 'not-a-phone'])
            ->assertSessionHasErrors('phone');

        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_duplicate_phone(): void
    {
        $this->post('/register', ['name' => 'First Player', 'phone' => '081234567890']);
        $this->app['auth']->forgetGuards();

        $this->post('/register', ['name' => 'Second Player', 'phone' => '081234567890'])
            ->assertSessionHasErrors('phone');

        $this->assertDatabaseCount('users', 1);
    }
}
