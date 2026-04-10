<?php

use App\Models\Customer;

describe('Customer CRUD', function (): void {
    it('crea un cliente correctamente', function (): void {
        $payload = [
            'name' => 'Cliente Demo',
            'email' => 'cliente.demo@example.com',
            'phone' => '555-123-4567',
            'company' => 'Empresa Demo',
            'address' => 'Av. Principal 123',
            'notes' => 'Cliente importante',
        ];

        $response = $this->post(route('crm.customers.store'), $payload);

        $response->assertRedirect(route('crm.customers.index'));

        $this->assertDatabaseHas('customers', [
            'email' => 'cliente.demo@example.com',
            'name' => 'Cliente Demo',
        ]);
    });

    it('no permite email duplicado', function (): void {
        $customer = Customer::factory()->create();

        $response = $this->post(route('crm.customers.store'), [
            'name' => 'Otro Cliente',
            'email' => $customer->email,
            'phone' => '555-987-6543',
            'company' => 'Otra Empresa',
            'address' => 'Calle Secundaria 456',
            'notes' => 'Nota de prueba',
        ]);

        $response->assertSessionHasErrors('email');
    });

    it('lista clientes', function (): void {
        Customer::factory()->count(3)->create();

        $response = $this->get(route('crm.customers.index'));

        $response
            ->assertStatus(200)
            ->assertViewHas('customers');
    });

    it('actualiza un cliente', function (): void {
        $customer = Customer::factory()->create();

        $this->put(route('crm.customers.update', $customer), [
            'name' => 'Cliente Renombrado',
            'email' => $customer->email,
            'phone' => $customer->phone,
            'company' => $customer->company,
            'address' => $customer->address,
            'notes' => $customer->notes,
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Cliente Renombrado',
        ]);
    });

    it('elimina un cliente con soft delete', function (): void {
        $customer = Customer::factory()->create();

        $this->delete(route('crm.customers.destroy', $customer));

        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    });
});
