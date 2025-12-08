<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdView;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PopularAdsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_displays_popular_ads(): void
    {
        // Create ads
        $ads = Ad::factory()->count(3)->create();

        // Create views: ad[1] gets most
        $today = now()->toDateString();
        AdView::factory()->create(['ad_id' => $ads[0]->id, 'view_date' => $today, 'ip_hash' => 'a', 'session_id' => 's1']);
        AdView::factory()->create(['ad_id' => $ads[0]->id, 'view_date' => $today, 'ip_hash' => 'b', 'session_id' => 's2']);

        AdView::factory()->create(['ad_id' => $ads[1]->id, 'view_date' => $today, 'ip_hash' => 'c', 'session_id' => 's3']);

        // Hit home
        $resp = $this->get('/');
        $resp->assertStatus(200);
        $resp->assertSee('Top Ads');
        $resp->assertSee($ads[0]->ad_name);
    }
}
