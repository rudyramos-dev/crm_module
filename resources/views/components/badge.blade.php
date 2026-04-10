@props([
    'color' => '#4f46e5',
    'text' => '',
    'dark' => false,
])

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold ' . ($dark ? 'text-gray-800' : 'text-white'),
        'style' => "background-color: {$color};",
    ]) }}
>
    {{ $text }}
</span>
