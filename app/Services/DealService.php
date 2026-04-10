<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Deal;
use App\Models\PipelineStage;
use App\Repositories\Contracts\DealRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class DealService
{
    public function __construct(
        private readonly DealRepositoryInterface $repository,
    ) {}

    public function list(Request $request): Collection
    {
        return $this->repository->all([
            'customer_id' => $request->input('customer_id'),
            'status' => $request->input('status'),
        ]);
    }

    public function store(array $data): Deal
    {
        if (! array_key_exists('pipeline_stage_id', $data) || $data['pipeline_stage_id'] === null) {
            $data['pipeline_stage_id'] = PipelineStage::query()
                ->where('is_default', true)
                ->value('id');
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Deal
    {
        return $this->repository->update($id, $data);
    }

    public function moveStage(int $dealId, int $stageId): Deal
    {
        return $this->repository->moveToStage($dealId, $stageId);
    }

    public function destroy(int $id): bool
    {
        $this->repository->find($id);

        return $this->repository->delete($id);
    }
}
