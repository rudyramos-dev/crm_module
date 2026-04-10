@props([
    'action',
    'label' => 'Eliminar',
    'message' => '¿Estás seguro?',
])

<form action="{{ $action }}" method="POST" class="inline" x-data>
    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-red-700"
        x-on:click.prevent="if (confirm(@js($message))) { $el.form.submit(); }"
    >
        {{ $label }}
    </button>
</form>
