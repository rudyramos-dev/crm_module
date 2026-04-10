<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Collection;

final class ActivityService
{
    public function listByCustomer(int $customerId): Collection
    {
        return Activity::query()
            ->where('customer_id', $customerId)
            ->with(['deal'])
            ->orderBy('scheduled_at', 'desc')
            ->get();
    }

    public function store(array $data): Activity
    {
        return Activity::query()->create($data);
    }

    public function markCompleted(int $id): Activity
    {
        $activity = Activity::query()->findOrFail($id);
        $activity->completed_at = now();
        $activity->save();

        return $activity;
    }
}
