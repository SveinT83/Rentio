<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\AdView;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdViewFactory extends Factory
{
    protected $model = AdView::class;

    public function definition(): array
    {
        return [
            'ad_id' => Ad::factory(),
            'view_date' => now()->toDateString(),
            'ip_hash' => $this->faker->sha256(),
            'session_id' => $this->faker->uuid(),
            'user_id' => null,
        ];
    }
}
