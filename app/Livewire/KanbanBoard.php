<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\PipelineStage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

final class KanbanBoard extends Component
{
    public $selectedCustomerId = null;

    public $customers = [];

    public function mount(): void
    {
        $this->customers = Customer::query()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    #[Computed]
    public function kanbanData(): Collection
    {
        return PipelineStage::query()
            ->with([
                'deals' => function (Builder $query): void {
                    if ($this->selectedCustomerId) {
                        $query->where('customer_id', $this->selectedCustomerId);
                    }

                    $query->with('customer')->orderBy('created_at', 'desc');
                },
            ])
            ->get();
    }

    #[On('moveDeal')]
    public function moveDeal(int $dealId, int $stageId): void
    {
        $deal = Deal::findOrFail($dealId);

        $deal->update([
            'pipeline_stage_id' => $stageId,
        ]);

        $this->dispatch('deal-moved', message: 'Deal movido correctamente');
    }

    public function updatedSelectedCustomerId(): void {}

    public function render(): View
    {
        return view('livewire.kanban-board');
    }
}
