<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Activity>
 */
final class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'deal_id' => null,
            'user_id' => null,
            'type' => fake()->randomElement(['call', 'email', 'meeting', 'note']),
            'description' => fake('es_MX')->sentence(),
            'scheduled_at' => fake()->optional()->dateTimeBetween('now', '+30 days'),
            'completed_at' => null,
        ];
    }
}
