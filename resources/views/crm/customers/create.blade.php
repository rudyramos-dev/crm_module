@extends('layouts.crm')

@section('title', 'Nuevo cliente')

@section('page-title')
    <h1 class="text-2xl font-bold text-slate-900">Nuevo cliente</h1>
@endsection

@section('content')
    <x-card title="Datos del cliente">
        <form action="{{ route('crm.customers.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('name') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('email') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">Teléfono</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('phone') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="company" class="mb-1 block text-sm font-medium text-slate-700">Empresa</label>
                    <input id="company" name="company" type="text" value="{{ old('company') }}" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('company') ? 'border-red-500' : 'border-slate-300' }}">
                    @error('company')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="address" class="mb-1 block text-sm font-medium text-slate-700">Dirección</label>
                <textarea id="address" name="address" rows="3" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('address') ? 'border-red-500' : 'border-slate-300' }}">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="mb-1 block text-sm font-medium text-slate-700">Notas</label>
                <textarea id="notes" name="notes" rows="4" class="w-full rounded-md border px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none {{ $errors->has('notes') ? 'border-red-500' : 'border-slate-300' }}">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Guardar
                </button>
                <a href="{{ route('crm.customers.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                    Cancelar
                </a>
            </div>
        </form>
    </x-card>
@endsection
