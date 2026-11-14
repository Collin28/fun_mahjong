<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post('/login', ['username' => $admin->username, 'password' => 'password123'])
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_existing_player_cannot_login(): void
    {
        $player = User::factory()->create();

        $this->post('/login', ['username' => $player->username, 'password' => 'password123'])
            ->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    #[TestWith(['GET', '/admin/dashboard'])]
    #[TestWith(['GET', '/admin/users'])]
    #[TestWith(['GET', '/admin/users/1'])]
    #[TestWith(['GET', '/admin/users/1/edit'])]
    #[TestWith(['PUT', '/admin/users/1'])]
    #[TestWith(['DELETE', '/admin/users/1'])]
    #[TestWith(['POST', '/admin/adjust-stat'])]
    #[TestWith(['POST', '/admin/add-point'])]
    #[TestWith(['POST', '/admin/add-match'])]
    #[TestWith(['POST', '/admin/reset'])]
    #[TestWith(['GET', '/scorer'])]
    public function test_guests_cannot_access_admin_endpoints(string $method, string $uri): void
    {
        $this->call($method, $uri)->assertRedirect(route('login'));
    }

    public function test_existing_player_session_cannot_manage_data(): void
    {
        $player = User::factory()->create();

        $this->actingAs($player)->post('/admin/adjust-stat', [
            'username' => $player->username, 'group' => 'hu', 'delta' => 1,
        ])->assertForbidden();

        $this->assertSame(0, $player->fresh()->hu_points);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk()
            ->assertSee('href="'.route('scorer.index').'"', false)
            ->assertSee('Scoring');
    }

    public function test_admin_can_update_player_name_and_phone(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $player = User::factory()->create();

        $this->actingAs($admin)->put('/admin/users/'.$player->id, [
            'name' => 'Updated Player', 'phone' => '081234567899',
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['id' => $player->id, 'name' => 'Updated Player', 'username' => '081234567899']);
    }

    public function test_old_user_dashboard_redirects_to_public_home(): void
    {
        $this->get('/user/dashboard')->assertRedirect('/');
    }
}
