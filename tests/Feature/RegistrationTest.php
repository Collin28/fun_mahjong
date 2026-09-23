<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_uses_month_and_day_and_persists_an_animal_avatar(): void
    {
        $this->get('/register')->assertOk()
            ->assertSee('name="birth_month"', false)
            ->assertSee('name="birth_day"', false)
            ->assertDontSee('type="date"', false)
            ->assertDontSee('name="birth_year"', false);

        $this->post('/register', [
            'name' => 'Test Player',
            'username' => 'testplayer',
            'email' => 'player@example.com',
            'birth_month' => 2,
            'birth_day' => 29,
            'password' => 'password123',
        ])->assertSessionHasNoErrors()->assertRedirect(route('user.dashboard'));

        $user = User::where('username', 'testplayer')->firstOrFail();
        $this->assertSame('2000-02-29', $user->birth_date);
        $this->assertContains($user->profile_picture, ['panda', 'tiger', 'fox', 'cat', 'rabbit', 'bear', 'koala', 'penguin']);
        $this->assertAuthenticatedAs($user);
        $avatar = $user->profile_animal_emoji;
        $this->get(route('user.dashboard'))->assertOk()->assertSee($avatar);
        $this->get('/')->assertOk()->assertSee($avatar);
        $this->assertSame($avatar, $user->fresh()->profile_animal_emoji);
    }

    public function test_registration_rejects_impossible_month_and_day(): void
    {
        $this->from('/register')->post('/register', [
            'name' => 'Test Player',
            'username' => 'testplayer',
            'email' => 'player@example.com',
            'birth_month' => 4,
            'birth_day' => 31,
            'password' => 'password123',
        ])->assertRedirect('/register')->assertSessionHasErrors('birth_day');

        $this->assertDatabaseCount('users', 0);
    }
}
