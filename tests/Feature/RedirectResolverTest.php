<?php

namespace Tests\Feature;

use App\Models\Redirect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectResolverTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_known_dead_url_301s_to_its_replacement(): void
    {
        Redirect::create(['old_url' => '/best-electric-wheelchairs', 'new_url' => '/best-electric-wheelchair']);

        $this->get('/best-electric-wheelchairs')
            ->assertStatus(301)
            ->assertRedirect('/best-electric-wheelchair');
    }

    public function test_chained_redirects_resolve_to_the_final_destination(): void
    {
        Redirect::create(['old_url' => '/step-a', 'new_url' => '/step-b']);
        Redirect::create(['old_url' => '/step-b', 'new_url' => '/step-c']);

        $this->get('/step-a')->assertStatus(301)->assertRedirect('/step-c');
    }

    public function test_external_targets_redirect_away(): void
    {
        Redirect::create([
            'old_url' => '/best-shisha-flavors-legacy',
            'new_url' => 'https://shishaware.org/best-shisha-flavors/',
        ]);

        $this->get('/best-shisha-flavors-legacy')
            ->assertStatus(301)
            ->assertRedirect('https://shishaware.org/best-shisha-flavors/');
    }

    public function test_query_string_is_carried_through(): void
    {
        Redirect::create(['old_url' => '/old-page', 'new_url' => '/new-page']);

        $this->get('/old-page?ref=newsletter')
            ->assertStatus(301)
            ->assertRedirect('/new-page?ref=newsletter');
    }

    public function test_legacy_index_php_prefix_is_matched(): void
    {
        Redirect::create([
            'old_url' => '/best-handheld-shower-heads-x',
            'new_url' => '/best-handheld-shower-heads-final',
        ]);

        $this->get('/index.php/best-handheld-shower-heads-x')
            ->assertStatus(301)
            ->assertRedirect('/best-handheld-shower-heads-final');
    }

    public function test_an_unknown_url_still_404s(): void
    {
        $this->get('/this-slug-never-existed-42')->assertNotFound();
    }

    public function test_a_self_referential_row_does_not_redirect(): void
    {
        Redirect::create(['old_url' => '/loopy', 'new_url' => '/loopy']);

        $this->get('/loopy')->assertNotFound();
    }

    public function test_a_cycle_terminates_without_looping(): void
    {
        Redirect::create(['old_url' => '/ping', 'new_url' => '/pong']);
        Redirect::create(['old_url' => '/pong', 'new_url' => '/ping']);

        $this->assertContains($this->get('/ping')->getStatusCode(), [301, 404]);
    }
}
