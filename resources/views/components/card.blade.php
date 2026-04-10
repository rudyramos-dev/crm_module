@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-lg bg-white p-6 shadow']) }}>
    @if ($title)
        <h3 class="mb-4 text-lg font-semibold text-slate-900">{{ $title }}</h3>
    @endif

    {{ $slot }}
</div>
