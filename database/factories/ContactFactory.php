<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
final class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => fake('es_MX')->name(),
            'email' => fake('es_MX')->safeEmail(),
            'phone' => fake('es_MX')->phoneNumber(),
            'position' => fake('es_MX')->jobTitle(),
            'is_primary' => false,
        ];
    }
}
