<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\DealStatus;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Repositories\Contracts\DealRepositoryInterface;
use Illuminate\Support\Collection;

final class DealRepository implements DealRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = Deal::query();

        if (isset($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(int $id): Deal
    {
        return Deal::query()->findOrFail($id);
    }

    public function create(array $data): Deal
    {
        return Deal::query()->create($data);
    }

    public function update(int $id, array $data): Deal
    {
        $deal = $this->find($id);
        $deal->update($data);

        return $deal->refresh();
    }

    public function moveToStage(int $dealId, int $stageId): Deal
    {
        return $this->update($dealId, ['pipeline_stage_id' => $stageId]);
    }

    public function getKanbanData(): Collection
    {
        return PipelineStage::query()
            ->with(['deals' => static fn ($query) => $query->with('customer')])
            ->get();
    }

    public function getDashboardMetrics(): array
    {
        $wonDeals = Deal::query()->where('status', DealStatus::Won->value)->count();
        $lostDeals = Deal::query()->where('status', DealStatus::Lost->value)->count();
        $closedDeals = $wonDeals + $lostDeals;

        return [
            'active_deals' => Deal::query()->where('status', DealStatus::Active->value)->count(),
            'won_deals' => $wonDeals,
            'lost_deals' => $lostDeals,
            'close_rate' => $closedDeals > 0 ? ($wonDeals / $closedDeals) * 100 : 0.0,
            'pipeline_value' => (float) Deal::query()
                ->where('status', DealStatus::Active->value)
                ->sum('value'),
        ];
    }
}
