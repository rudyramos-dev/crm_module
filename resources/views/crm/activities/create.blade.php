@extends('layouts.crm')

@section('title', 'Nueva actividad')

@section('page-title')
    <h1 class="text-2xl font-bold text-slate-900">Nueva actividad</h1>
@endsection

@section('content')
    <x-card title="Registrar actividad para {{ $customer->name }}">
        <form action="{{ route('crm.customers.activities.store', $customer) }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="type" class="mb-1 block text-sm font-medium text-slate-700">Tipo</label>
                    <select id="type" name="type" required class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('type') ? 'border-red-500' : 'border-slate-300' }}">
                        <option value="call" @selected(old('type') === 'call')>Llamada</option>
                        <option value="email" @selected(old('type') === 'email')>Email</option>
                        <option value="meeting" @selected(old('type') === 'meeting')>Reunión</option>
                        <option value="note" @selected(old('type') === 'note')>Nota</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deal_id" class="mb-1 block text-sm font-medium text-slate-700">Deal</label>
                    <select id="deal_id" name="deal_id" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('deal_id') ? 'border-red-500' : 'border-slate-300' }}">
                        <option value="">Sin deal</option>
                        @foreach ($deals as $deal)
                            <option value="{{ $deal->id }}" @selected((string) old('deal_id') === (string) $deal->id)>{{ $deal->title }}</option>
                        @endforeach
                    </select>
                    @error('deal_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Descripción</label>
                <textarea id="description" name="description" rows="4" required class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('description') ? 'border-red-500' : 'border-slate-300' }}">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="scheduled_at" class="mb-1 block text-sm font-medium text-slate-700">Programada para</label>
                <input id="scheduled_at" name="scheduled_at" type="datetime-local" value="{{ old('scheduled_at') }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('scheduled_at') ? 'border-red-500' : 'border-slate-300' }}">
                @error('scheduled_at')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Guardar
                </button>
                <a href="{{ route('crm.customers.show', $customer) }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                    Cancelar
                </a>
            </div>
        </form>
    </x-card>
@endsection
