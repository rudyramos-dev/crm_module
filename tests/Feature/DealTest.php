<?php

use App\Models\Customer;
use App\Models\Deal;
use App\Models\PipelineStage;

describe('Deal Pipeline', function (): void {
    it('crea un deal con stage por defecto', function (): void {
        $defaultStage = PipelineStage::factory()->create([
            'is_default' => true,
        ]);

        $customer = Customer::factory()->create();

        $this->post(route('crm.deals.store'), [
            'customer_id' => $customer->id,
            'title' => 'Negocio de prueba',
            'value' => 15000,
            'expected_close_date' => now()->addDays(10)->toDateString(),
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('deals', [
            'customer_id' => $customer->id,
            'pipeline_stage_id' => $defaultStage->id,
            'title' => 'Negocio de prueba',
        ]);
    });

    it('mueve un deal entre etapas', function (): void {
        $deal = Deal::factory()->create();
        $newStage = PipelineStage::factory()->create();

        $response = $this->post(route('crm.deals.move-stage', $deal), [
            'pipeline_stage_id' => $newStage->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('deals', [
            'id' => $deal->id,
            'pipeline_stage_id' => $newStage->id,
        ]);
    });

    it('calcula metricas correctamente', function (): void {
        $stage = PipelineStage::factory()->create(['is_default' => true]);

        Deal::factory()->count(3)->create([
            'pipeline_stage_id' => $stage->id,
            'status' => 'active',
        ]);

        Deal::factory()->count(2)->create([
            'pipeline_stage_id' => $stage->id,
            'status' => 'won',
        ]);

        Deal::factory()->create([
            'pipeline_stage_id' => $stage->id,
            'status' => 'lost',
        ]);

        $response = $this->get(route('crm.dashboard'));

        $response
            ->assertStatus(200)
            ->assertViewHas('metrics');

        $metrics = $response->viewData('metrics');

        expect($metrics['active_deals'])->toBe(3)
            ->and($metrics['won_deals'])->toBe(2)
            ->and(number_format((float) $metrics['close_rate'], 1, '.', ''))
            ->toBe(number_format(round((2 / 3) * 100, 1), 1, '.', ''));
    });
});
