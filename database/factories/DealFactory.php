<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\PipelineStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deal>
 */
final class DealFactory extends Factory
{
    protected $model = Deal::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'pipeline_stage_id' => PipelineStage::factory(),
            'title' => fake('es_MX')->bs(),
            'value' => fake()->randomFloat(2, 1000, 500000),
            'expected_close_date' => fake()->optional()->dateTimeBetween('now', '+6 months')?->format('Y-m-d'),
            'status' => fake()->randomElement(['active', 'won', 'lost']),
        ];
    }
}
