@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xl text-gray-600']) }}>
    {{ $value ?? $slot }}
</label>