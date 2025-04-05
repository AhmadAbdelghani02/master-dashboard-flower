@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 text-sm font-medium text-white rounded-md bg-gray-700 hover:bg-gray-600'
            : 'flex items-center px-4 py-2 text-sm font-medium text-white rounded-md hover:bg-gray-600' ;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
