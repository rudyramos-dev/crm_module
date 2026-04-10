@extends('layouts.crm')

@section('title', 'Dashboard')

@section('page-title')
    <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
@endsection

@section('content')
    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Deals activos</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ $metrics['active_deals'] }}</p>
            <p class="mt-1 text-xs text-slate-400">En pipeline</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tasa de cierre</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ number_format($metrics['close_rate'], 1) }}%</p>
            <p class="mt-1 text-xs text-slate-400">Won / (Won + Lost)</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Valor en pipeline</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ money($metrics['pipeline_value']) }}</p>
            <p class="mt-1 text-xs text-slate-400">Deals activos</p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Deals ganados</p>
            <p class="mt-1 text-3xl font-bold text-slate-800">{{ $metrics['won_deals'] }}</p>
            <p class="mt-1 text-xs text-slate-400">Total histórico</p>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="mb-3 text-lg font-semibold text-slate-900">Actividades pendientes</h2>
        <x-card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Cliente</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Tipo</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Descripción</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Programada</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($pendingActivities as $activity)
                            @php
                                $typeColor = match ($activity->type->value) {
                                    'call' => '#6366f1',
                                    'email' => '#f59e0b',
                                    'meeting' => '#3b82f6',
                                    default => '#64748b',
                                };
                            @endphp
                            <tr>
                                <td class="px-4 py-3">
                                    <a href="{{ route('crm.customers.show', $activity->customer) }}" class="font-medium text-indigo-600 hover:text-indigo-700">
                                        {{ $activity->customer->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <x-badge :color="$typeColor" :text="ucfirst($activity->type->value)" />
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ \Illuminate\Support\Str::limit($activity->description, 80) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $activity->scheduled_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-slate-500">No hay actividades pendientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <div>
        <h2 class="mb-3 text-lg font-semibold text-slate-900">Deals recientes</h2>
        <x-card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Título</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Cliente</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Etapa</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Valor</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Creado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($recentDeals as $deal)
                            <tr>
                                <td class="px-4 py-3">
                                    <a href="{{ route('crm.deals.show', $deal) }}" class="font-medium text-indigo-600 hover:text-indigo-700">
                                        {{ $deal->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $deal->customer->name }}</td>
                                <td class="px-4 py-3">
                                    <x-badge :color="$deal->pipelineStage->color" :text="$deal->pipelineStage->name" />
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ money($deal->value) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $deal->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-slate-500">No hay deals recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
