<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Repositories\Contracts\DealRepositoryInterface;
use App\Services\DealService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DealController extends Controller
{
    public function __construct(
        private readonly DealService $service,
        private readonly DealRepositoryInterface $repository,
    ) {}

    public function index(Request $request): View
    {
        return view('crm.deals.index', [
            'kanbanData' => $this->repository->getKanbanData(),
        ]);
    }

    public function create(): View
    {
        return view('crm.deals.create', [
            'customers' => Customer::query()->get(),
            'stages' => PipelineStage::query()->get(),
        ]);
    }

    public function store(StoreDealRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('crm.deals.index')
            ->with('success', 'Negocio creado correctamente.');
    }

    public function show(Deal $deal): View
    {
        $deal->load(['customer', 'pipelineStage', 'activities']);

        return view('crm.deals.show', [
            'deal' => $deal,
        ]);
    }

    public function edit(Deal $deal): View
    {
        return view('crm.deals.edit', [
            'deal' => $deal,
            'customers' => Customer::query()->get(),
            'stages' => PipelineStage::query()->get(),
        ]);
    }

    public function update(UpdateDealRequest $request, Deal $deal): RedirectResponse
    {
        $this->service->update($deal->id, $request->validated());

        return redirect()->route('crm.deals.show', $deal);
    }

    public function destroy(Deal $deal): RedirectResponse
    {
        $this->service->destroy($deal->id);

        return redirect()->route('crm.deals.index');
    }

    public function moveStage(Request $request, Deal $deal): JsonResponse
    {
        $request->validate([
            'pipeline_stage_id' => 'required|exists:pipeline_stages,id',
        ]);

        $this->service->moveStage($deal->id, (int) $request->input('pipeline_stage_id'));

        return response()->json([
            'success' => true,
            'deal' => $deal->fresh()->load('pipelineStage'),
        ]);
    }
}
