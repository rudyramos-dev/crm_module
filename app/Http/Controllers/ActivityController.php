<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Services\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ActivityController extends Controller
{
    public function __construct(
        private readonly ActivityService $service,
    ) {}

    public function index(Customer $customer): View
    {
        return view('crm.activities.index', [
            'customer' => $customer,
            'activities' => $this->service->listByCustomer($customer->id),
        ]);
    }

    public function create(Customer $customer): View
    {
        return view('crm.activities.create', [
            'customer' => $customer,
            'deals' => Deal::query()->where('customer_id', $customer->id)->get(),
        ]);
    }

    public function store(StoreActivityRequest $request, Customer $customer): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('crm.customers.show', $customer)
            ->with('success', 'Actividad creada correctamente.');
    }

    public function markCompleted(Activity $activity): RedirectResponse
    {
        $this->service->markCompleted($activity->id);

        return back()->with('success', 'Actividad marcada como completada.');
    }
}
