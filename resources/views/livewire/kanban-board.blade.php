<div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity duration-200">
    <div class="mb-4">
        <label for="customer-filter" class="mb-1 block text-sm font-medium text-slate-700">Filtrar por cliente</label>
        <select
            id="customer-filter"
            wire:model.live="selectedCustomerId"
            class="w-full max-w-sm rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
        >
            <option value="">Todos los clientes</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-4 overflow-x-auto pb-4">
        @foreach ($this->kanbanData as $stage)
            <div class="min-w-64 w-64 flex-shrink-0 rounded-lg bg-slate-100 p-3">
                <div class="mb-3 flex items-center justify-between">
                    <span
                        class="rounded-full px-2 py-1 text-xs text-white"
                        @style(['background-color: ' . $stage->color])
                    >
                        {{ $stage->name }}
                    </span>
                    <div class="text-right text-xs text-slate-500">
                        <div>{{ $stage->deals->count() }} deals</div>
                        <div>${{ number_format((float) $stage->deals->sum('value'), 0, '.', ',') }}</div>
                    </div>
                </div>

                <div class="deal-list min-h-16" data-stage-id="{{ $stage->id }}">
                    @forelse ($stage->deals as $deal)
                        <div
                            class="mb-2 cursor-grab rounded-md border border-slate-200 bg-white p-3 shadow-sm"
                            data-deal-id="{{ $deal->id }}"
                            data-stage-id="{{ $stage->id }}"
                        >
                            <div class="text-sm font-medium text-slate-800">{{ $deal->title }}</div>
                            <div class="mt-1 text-xs text-slate-500">{{ $deal->customer?->name }}</div>
                            <div class="mt-2 text-sm font-semibold text-indigo-600">${{ number_format((float) $deal->value, 0, '.', ',') }}</div>
                            <div class="mt-1 text-xs text-slate-400">{{ (int) now()->diffInDays($deal->created_at) }} días</div>
                        </div>
                    @empty
                        <div class="rounded-md border-2 border-dashed border-slate-300 p-4 text-center text-xs text-slate-400">
                            Arrastra deals aquí
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
