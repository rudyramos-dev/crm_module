@extends('layouts.crm')

@section('title', 'Detalle cliente')

@section('page-title')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-slate-900">{{ $customer->name }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('crm.customers.edit', $customer) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Editar cliente
            </a>
            <a href="{{ route('crm.customers.activities.create', $customer) }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-300 transition hover:bg-slate-100">
                Nueva actividad
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        <x-card title="Información del cliente">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $customer->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $customer->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Teléfono</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $customer->phone ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Empresa</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $customer->company ?: '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dirección</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $customer->address ?: '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Notas</p>
                    <p class="mt-1 text-sm text-slate-800">{{ $customer->notes ?: '-' }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="Contactos">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Nombre</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Teléfono</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Cargo</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Etiqueta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($customer->contacts as $contact)
                            <tr>
                                <td class="px-4 py-3 text-slate-700">{{ $contact->name }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $contact->email ?: '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $contact->phone ?: '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $contact->position ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    @if ($contact->is_primary)
                                        <x-badge text="Principal" color="#22c55e" :dark="true" />
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-slate-500">No hay contactos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-card title="Últimas actividades">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Tipo</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Descripción</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Fecha</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($customer->activities as $activity)
                            @php
                                $typeColor = match ($activity->type->value) {
                                    'call' => '#0ea5e9',
                                    'email' => '#6366f1',
                                    'meeting' => '#f59e0b',
                                    default => '#64748b',
                                };
                            @endphp
                            <tr>
                                <td class="px-4 py-3">
                                    <x-badge :text="ucfirst($activity->type->value)" :color="$typeColor" />
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ \Illuminate\Support\Str::limit($activity->description, 80) }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $activity->scheduled_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $activity->completed_at ? 'Completada' : 'Pendiente' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-5 text-center text-slate-500">No hay actividades recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-card title="Deals activos">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Título</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Etapa</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-600">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($customer->deals->where('status', \App\Enums\DealStatus::Active) as $deal)
                            <tr>
                                <td class="px-4 py-3 text-slate-700">{{ $deal->title }}</td>
                                <td class="px-4 py-3">
                                    <x-badge :text="$deal->pipelineStage?->name ?? 'Sin etapa'" :color="$deal->pipelineStage?->color ?? '#4f46e5'" />
                                </td>
                                <td class="px-4 py-3 text-slate-700">${{ number_format((float) $deal->value, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-5 text-center text-slate-500">No hay deals activos</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection
