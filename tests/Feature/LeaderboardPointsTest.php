<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeaderboardPointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_leaderboard_shows_weighted_points_separately_from_wins(): void
    {
        User::factory()->create(['name' => 'Example Player', 'hu_points' => 10, 'zi_mo_points' => 2]);

        $this->get('/')->assertOk()
            ->assertSee('Akumulasi Poin')
            ->assertSee('data-label="Akumulasi Poin" class="col-center">14</td>', false);
    }

    public function test_top_players_are_ranked_by_weighted_points(): void
    {
        $huPlayer = User::factory()->create(['hu_points' => 3, 'zi_mo_points' => 0]);
        $ziMoPlayer = User::factory()->create(['hu_points' => 0, 'zi_mo_points' => 2]);

        $this->get('/')->assertViewHas('topPlayers', fn ($users) => $users->modelKeys() === [$ziMoPlayer->id, $huPlayer->id]);
    }

    public function test_public_leaderboard_limits_each_category_to_ten_users(): void
    {
        User::factory()->count(12)->create([
            'daily_played' => 1,
            'weekly_played' => 1,
            'total_played' => 1,
        ]);

        $this->get('/')->assertViewHas('dailyUsers', fn ($users) => $users->count() === 10)
            ->assertViewHas('weeklyUsers', fn ($users) => $users->count() === 10)
            ->assertViewHas('topPlayers', fn ($users) => $users->count() === 10)
            ->assertViewHas('topLoyal', fn ($users) => $users->count() === 10);
    }

    public function test_admin_leaderboard_limits_each_category_to_ten_users(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->count(12)->create([
            'daily_played' => 1,
            'weekly_played' => 1,
            'total_played' => 1,
        ]);

        $this->actingAs($admin)->get('/admin/dashboard')
            ->assertViewHas('dailyUsers', fn ($users) => $users->count() === 10)
            ->assertViewHas('weeklyUsers', fn ($users) => $users->count() === 10)
            ->assertViewHas('topPlayers', fn ($users) => $users->count() === 10)
            ->assertViewHas('topLoyal', fn ($users) => $users->count() === 10);
    }

    public function test_public_leaderboard_does_not_display_win_rate(): void
    {
        User::factory()->create(['total_played' => 10, 'total_wins' => 5]);

        $this->get('/')->assertDontSee('Win Rate');
    }

    public function test_admin_leaderboard_does_not_display_win_rate(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['total_played' => 10, 'total_wins' => 5]);

        $this->actingAs($admin)->get('/admin/dashboard')->assertDontSee('Win Rate');
    }

    public function test_admin_displays_player_name_and_accumulated_points(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['name' => 'Named Player', 'username' => '081234567890', 'hu_points' => 10, 'zi_mo_points' => 2]);

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk()
            ->assertSee('Nama Pemain')->assertDontSee('<th scope="col">Username</th>', false)
            ->assertSee('<td>Named Player</td>', false)
            ->assertSee('data-field="accumulated_points">14</strong>', false);
    }

    public function test_adjusting_zi_mo_updates_points_and_win_count(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $player = User::factory()->create(['hu_points' => 10, 'zi_mo_points' => 1, 'weekly_wins' => 5]);

        $this->actingAs($admin)->postJson('/admin/adjust-stat', [
            'username' => $player->username, 'group' => 'zi_mo', 'delta' => 1,
        ])->assertOk()->assertJsonPath('accumulated_points', 14)
            ->assertJsonPath('total_wins', 12)->assertJsonPath('weekly_wins', 6);

        $this->assertDatabaseHas('users', ['id' => $player->id, 'zi_mo_points' => 2, 'total_wins' => 12, 'weekly_wins' => 6]);
    }
}
