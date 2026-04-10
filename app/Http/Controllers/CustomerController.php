<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $service,
    ) {}

    public function index(Request $request): View
    {
        return view('crm.customers.index', [
            'customers' => $this->service->list($request),
        ]);
    }

    public function create(): View
    {
        return view('crm.customers.create');
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('crm.customers.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'contacts',
            'activities' => static fn ($query) => $query->orderByDesc('created_at')->limit(5),
            'deals.pipelineStage',
        ]);

        return view('crm.customers.show', [
            'customer' => $customer,
        ]);
    }

    public function edit(Customer $customer): View
    {
        return view('crm.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $this->service->update($customer->id, $request->validated());

        return redirect()
            ->route('crm.customers.show', $customer)
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $this->service->destroy($customer->id);

        return redirect()
            ->route('crm.customers.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
