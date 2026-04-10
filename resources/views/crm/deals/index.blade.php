@extends('layouts.crm')

@section('title', 'Pipeline')

@section('page-title')
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-slate-900">Pipeline de ventas</h1>
        <a href="{{ route('crm.deals.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
            Nuevo deal
        </a>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @livewire('kanban-board')

    <div
        x-data="{ show: false, message: '' }"
        x-show="show"
        x-transition
        @deal-moved.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
        class="fixed bottom-4 right-4 rounded-lg bg-green-600 px-4 py-3 text-sm text-white shadow-lg"
    >
        <span x-text="message"></span>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            const initSortable = () => {
                document.querySelectorAll('.deal-list').forEach((column) => {
                    if (column.dataset.sortableInitialized === 'true') {
                        return;
                    }

                    column.dataset.sortableInitialized = 'true';

                    Sortable.create(column, {
                        group: { name: 'deals', pull: true, put: true },
                        animation: 150,
                        ghostClass: 'opacity-50',
                        onEnd: function (evt) {
                            const dealId = evt.item.dataset.dealId;
                            const stageId = evt.to.dataset.stageId;

                            if (dealId && stageId) {
                                Livewire.dispatch('moveDeal', {
                                    dealId: parseInt(dealId, 10),
                                    stageId: parseInt(stageId, 10),
                                });
                            }
                        },
                    });
                });
            };

            initSortable();
            Livewire.hook('morph.updated', () => {
                initSortable();
            });
        });
    </script>
@endpush
