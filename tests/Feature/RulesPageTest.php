<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RulesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_with_rules_section(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="rules"', false);
        $response->assertSee('class="skip-link"', false);
        $response->assertSee('role="tablist"', false);
    }

    public function test_home_page_has_no_dead_anchors(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertStringNotContainsString('href="#"', $html);

        // Every in-page anchor must resolve to a real id on the page.
        preg_match_all('/href="#([\w-]+)"/', $html, $matches);
        foreach (array_unique($matches[1]) as $anchor) {
            $this->assertStringContainsString(
                'id="'.$anchor.'"',
                $html,
                "Anchor #{$anchor} has no matching element."
            );
        }
    }

    public function test_about_and_auth_pages_render(): void
    {
        $this->get('/about-us')->assertStatus(200);

        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('for="username"', false)
            ->assertSee('autocomplete="current-password"', false);

        $this->get('/register')
            ->assertStatus(200)
            ->assertSee('autocomplete="new-password"', false);
    }
}
