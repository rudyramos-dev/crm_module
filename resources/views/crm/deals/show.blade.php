@extends('layouts.crm')

@section('title', 'Detalle Deal')

@section('page-title')
    <h1 class="text-2xl font-bold text-slate-900">Detalle del deal</h1>
@endsection

@section('content')
    <div class="space-y-6">
        <x-card title="Información del deal">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Título</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $deal->title }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Cliente</p>
                    <a href="{{ route('crm.customers.show', $deal->customer) }}" class="mt-1 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-700">
                        {{ $deal->customer->name }}
                    </a>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Etapa</p>
                    <div class="mt-1">
                        <x-badge :color="$deal->pipelineStage->color" :text="$deal->pipelineStage->name" />
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Valor</p>
                    <p class="mt-1 text-sm text-slate-800">{{ money($deal->value) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Fecha cierre esperada</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $deal->expected_close_date?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</p>
                    <p class="mt-1 text-sm text-slate-800">{{ ucfirst($deal->status->value) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Creado</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $deal->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </x-card>

        <div>
            <h2 class="mb-3 text-lg font-semibold text-slate-900">Actividades del deal</h2>
            <x-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-600">Tipo</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-600">Descripción</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-600">Programada</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-600">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($deal->activities as $activity)
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
                                        <x-badge :color="$typeColor" :text="ucfirst($activity->type->value)" />
                                    </td>
                                    <td class="px-4 py-3 text-slate-700">{{ $activity->description }}</td>
                                    <td class="px-4 py-3 text-slate-700">{{ $activity->scheduled_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($activity->completed_at)
                                            <x-badge color="#22c55e" text="Completada" />
                                        @else
                                            <x-badge color="#eab308" text="Pendiente" :dark="true" />
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-5 text-center text-slate-500">No hay actividades para este deal</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('crm.deals.edit', $deal) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Editar
            </a>
            <x-confirm-button :action="route('crm.deals.destroy', $deal)" label="Eliminar" message="¿Seguro que deseas eliminar este deal?" />
            <a href="{{ route('crm.deals.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                Volver
            </a>
        </div>
    </div>
@endsection
