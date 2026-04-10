<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
final class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('es_MX')->name(),
            'email' => fake('es_MX')->unique()->safeEmail(),
            'phone' => fake('es_MX')->phoneNumber(),
            'company' => fake('es_MX')->company(),
            'address' => fake('es_MX')->address(),
            'notes' => fake('es_MX')->optional()->sentence(),
        ];
    }
}
