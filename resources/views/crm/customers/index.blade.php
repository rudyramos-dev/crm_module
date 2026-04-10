@extends('layouts.crm')

@section('title', 'Clientes')

@section('page-title')
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-slate-900">Clientes</h1>
        <a href="{{ route('crm.customers.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
            Nuevo cliente
        </a>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nombre</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Empresa</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Teléfono</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Deals</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="px-4 py-3">
                                <a href="{{ route('crm.customers.show', $customer) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $customer->email }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $customer->company ?: '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $customer->phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $customer->deals_count ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('crm.customers.edit', $customer) }}" class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                        Editar
                                    </a>
                                    <x-confirm-button :action="route('crm.customers.destroy', $customer)" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                                No hay clientes registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
@endsection
