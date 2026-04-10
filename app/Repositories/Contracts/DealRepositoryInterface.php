<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Deal;
use Illuminate\Support\Collection;

interface DealRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function find(int $id): Deal;

    public function create(array $data): Deal;

    public function update(int $id, array $data): Deal;

    public function moveToStage(int $dealId, int $stageId): Deal;

    public function getKanbanData(): Collection;

    public function getDashboardMetrics(): array;
}
