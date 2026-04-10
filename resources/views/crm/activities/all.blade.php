@extends('layouts.crm')

@section('title', 'Actividades')

@section('page-title')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-slate-900">Todas las actividades</h1>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ filter: 'all' }" class="space-y-4">
        <div class="flex flex-wrap gap-2">
            <button type="button" @click="filter = 'all'" :class="filter === 'all' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-300'" class="rounded-md px-3 py-2 text-sm font-medium transition">Todas</button>
            <button type="button" @click="filter = 'call'" :class="filter === 'call' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-300'" class="rounded-md px-3 py-2 text-sm font-medium transition">Llamada</button>
            <button type="button" @click="filter = 'email'" :class="filter === 'email' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-300'" class="rounded-md px-3 py-2 text-sm font-medium transition">Email</button>
            <button type="button" @click="filter = 'meeting'" :class="filter === 'meeting' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-300'" class="rounded-md px-3 py-2 text-sm font-medium transition">Reunión</button>
            <button type="button" @click="filter = 'note'" :class="filter === 'note' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-300'" class="rounded-md px-3 py-2 text-sm font-medium transition">Nota</button>
        </div>

        <x-card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Tipo</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Cliente</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Descripcion</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Deal</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Programada</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Estado</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Accion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($activities as $activity)
                            @php
                                $typeColor = match ($activity->type->value) {
                                    'call' => '#6366f1',
                                    'email' => '#f59e0b',
                                    'meeting' => '#3b82f6',
                                    default => '#64748b',
                                };
                            @endphp
                            <tr x-show="filter === 'all' || filter === '{{ $activity->type->value }}'">
                                <td class="px-4 py-3">
                                    <x-badge :color="$typeColor" :text="ucfirst($activity->type->value)" />
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    <a href="{{ route('crm.customers.show', $activity->customer) }}" class="font-medium text-indigo-600 hover:text-indigo-700">
                                        {{ $activity->customer->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $activity->description }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    @if ($activity->deal)
                                        <a href="{{ route('crm.deals.show', $activity->deal) }}" class="font-medium text-indigo-600 hover:text-indigo-700">
                                            {{ $activity->deal->title }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $activity->scheduled_at?->diffForHumans() ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if ($activity->completed_at)
                                        <x-badge color="#22c55e" text="Completada" />
                                    @else
                                        <x-badge color="#eab308" text="Pendiente" :dark="true" />
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if (! $activity->completed_at)
                                        <form action="{{ route('crm.customers.activities.complete', [$activity->customer, $activity]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 ring-1 ring-slate-300 transition hover:bg-slate-200">
                                                Marcar completada
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-5 text-center text-slate-500">No hay actividades registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
