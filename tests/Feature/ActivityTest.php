<?php

use App\Models\Activity;
use App\Models\Customer;

describe('Activities', function (): void {
    it('registra una actividad para un cliente', function (): void {
        $customer = Customer::factory()->create();

        $this->post(route('crm.customers.activities.store', $customer), [
            'customer_id' => $customer->id,
            'deal_id' => null,
            'user_id' => null,
            'type' => 'call',
            'description' => 'Llamada de seguimiento',
            'scheduled_at' => now()->addDay()->toDateTimeString(),
        ]);

        $this->assertDatabaseHas('activities', [
            'customer_id' => $customer->id,
            'type' => 'call',
            'description' => 'Llamada de seguimiento',
        ]);
    });

    it('marca una actividad como completada', function (): void {
        $customer = Customer::factory()->create();

        $activity = Activity::factory()->create([
            'customer_id' => $customer->id,
            'completed_at' => null,
        ]);

        $response = $this->post(route('crm.customers.activities.complete', [
            'customer' => $customer->id,
            'activity' => $activity->id,
        ]));

        $response->assertRedirect();

        $this->assertNotNull(Activity::find($activity->id)->completed_at);
    });
});