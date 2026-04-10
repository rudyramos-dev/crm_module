<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Deal;
use App\Repositories\Contracts\DealRepositoryInterface;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __construct(
        private readonly DealRepositoryInterface $repository,
    ) {}

    public function index(): View
    {
        return view('crm.dashboard.index', [
            'metrics' => $this->repository->getDashboardMetrics(),
            'pendingActivities' => Activity::query()
                ->where('scheduled_at', '>=', now())
                ->whereNull('completed_at')
                ->with('customer')
                ->orderBy('scheduled_at')
                ->limit(10)
                ->get(),
            'recentDeals' => Deal::query()
                ->with(['customer', 'pipelineStage'])
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}
