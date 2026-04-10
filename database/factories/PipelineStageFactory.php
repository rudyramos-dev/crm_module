<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PipelineStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PipelineStage>
 */
final class PipelineStageFactory extends Factory
{
    protected $model = PipelineStage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Lead', 'Contactado', 'Propuesta', 'Negociación', 'Cerrado']),
            'color' => fake()->hexColor(),
            'order' => fake()->numberBetween(1, 10),
            'is_default' => false,
        ];
    }
}
