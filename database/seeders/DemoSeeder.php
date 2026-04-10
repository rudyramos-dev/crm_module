<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ActivityType;
use App\Enums\DealStatus;
use App\Models\Activity;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\PipelineStage;
use Illuminate\Database\Seeder;

final class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake('es_MX');

        Customer::factory()
            ->count(10)
            ->create()
            ->each(function (Customer $customer) use ($faker): void {
                $contactCount = random_int(1, 2);

                Contact::factory()
                    ->count($contactCount)
                    ->for($customer)
                    ->create()
                    ->each(function (Contact $contact, int $index): void {
                        if ($index === 0) {
                            $contact->update(['is_primary' => true]);
                        }
                    });

                $dealCount = random_int(2, 4);
                $dealStatuses = [
                    DealStatus::Active->value,
                    DealStatus::Won->value,
                    DealStatus::Lost->value,
                ];
                shuffle($dealStatuses);
                $selectedStatuses = array_slice(array_merge($dealStatuses, $dealStatuses), 0, $dealCount);

                $deals = collect($selectedStatuses)->map(function (string $status) use ($customer) {
                    $pipelineStageId = PipelineStage::inRandomOrder()->first()?->id;

                    if ($pipelineStageId === null) {
                        return null;
                    }

                    return Deal::factory()
                        ->for($customer)
                        ->create([
                            'pipeline_stage_id' => $pipelineStageId,
                            'status' => $status,
                        ]);
                })->filter();

                $activityCount = random_int(2, 3);
                $activityTypes = [
                    ActivityType::Call->value,
                    ActivityType::Email->value,
                    ActivityType::Meeting->value,
                    ActivityType::Note->value,
                ];
                shuffle($activityTypes);

                $scheduledTemplates = [
                    [
                        'scheduled_at' => now()->addDays(random_int(1, 20)),
                        'completed_at' => null,
                    ],
                    [
                        'scheduled_at' => now()->subDays(random_int(1, 20)),
                        'completed_at' => now()->subDays(random_int(0, 5)),
                    ],
                    [
                        'scheduled_at' => $faker->boolean(50) ? now()->addDays(random_int(2, 15)) : now()->subDays(random_int(2, 15)),
                        'completed_at' => $faker->boolean(50) ? now()->subDays(random_int(0, 3)) : null,
                    ],
                ];

                for ($i = 0; $i < $activityCount; $i++) {
                    $template = $scheduledTemplates[$i];

                    Activity::factory()
                        ->for($customer)
                        ->create([
                            'deal_id' => $deals->isNotEmpty() && $faker->boolean(70)
                                ? $deals->random()->id
                                : null,
                            'type' => $activityTypes[$i % count($activityTypes)],
                            'description' => $faker->randomElement([
                                'Llamada de seguimiento para validar propuesta comercial.',
                                'Se envió correo con cotizacion y terminos de servicio.',
                                'Reunion de demo del producto con el equipo de compras.',
                                'Nota interna sobre necesidades y presupuesto del cliente.',
                                'Se confirmo interes y proxima fecha de cierre estimada.',
                            ]),
                            'scheduled_at' => $template['scheduled_at'],
                            'completed_at' => $template['completed_at'],
                        ]);
                }
            });
    }
}
