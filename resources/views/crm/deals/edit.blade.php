@extends('layouts.crm')

@section('title', 'Editar Deal')

@section('page-title')
    <h1 class="text-2xl font-bold text-slate-900">Editar Deal</h1>
@endsection

@section('content')
    <x-card title="Editar deal">
        <form action="{{ route('crm.deals.update', $deal) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="customer_id" class="mb-1 block text-sm font-medium text-slate-700">Cliente</label>
                    <select id="customer_id" name="customer_id" required class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('customer_id') ? 'border-red-500' : 'border-slate-300' }}">
                        <option value="">Selecciona un cliente</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected((string) old('customer_id', $deal->customer_id) === (string) $customer->id)>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Título</label>
                    <input id="title" name="title" type="text" maxlength="255" required value="{{ old('title', $deal->title) }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('title') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="value" class="mb-1 block text-sm font-medium text-slate-700">Valor</label>
                    <input id="value" name="value" type="number" step="0.01" min="0" required value="{{ old('value', $deal->value) }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('value') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('value')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pipeline_stage_id" class="mb-1 block text-sm font-medium text-slate-700">Etapa</label>
                    <select id="pipeline_stage_id" name="pipeline_stage_id" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('pipeline_stage_id') ? 'border-red-500' : 'border-slate-300' }}">
                        @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}" @selected((string) old('pipeline_stage_id', $deal->pipeline_stage_id ?? optional($stages->firstWhere('is_default', true))->id) === (string) $stage->id)>{{ $stage->name }}</option>
                        @endforeach
                    </select>
                    @error('pipeline_stage_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expected_close_date" class="mb-1 block text-sm font-medium text-slate-700">Fecha cierre esperada</label>
                    <input id="expected_close_date" name="expected_close_date" type="date" value="{{ old('expected_close_date', optional($deal->expected_close_date)->format('Y-m-d')) }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('expected_close_date') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('expected_close_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Estado</label>
                    <select id="status" name="status" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('status') ? 'border-red-500' : 'border-slate-300' }}">
                        <option value="active" @selected(old('status', $deal->status->value) === 'active')>Activo</option>
                        <option value="won" @selected(old('status', $deal->status->value) === 'won')>Ganado</option>
                        <option value="lost" @selected(old('status', $deal->status->value) === 'lost')>Perdido</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Actualizar deal
                </button>
                <a href="{{ route('crm.deals.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">Cancelar</a>
            </div>
        </form>
    </x-card>
@endsection
