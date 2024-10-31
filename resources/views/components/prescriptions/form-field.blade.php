@props(['type' => 'text', 'name', 'label' => '', 'placeholder' => '', 'required' => false, 'value' => ''])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-gray-700 text-sm font-bold mb-2">
            {{ $label }}
        </label>
    @endif

    @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            placeholder="{{ $placeholder }}"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500
                    @error($name) border-red-500 @enderror"
            rows="5"
        >{{ $value }}</textarea>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            {{ $required ? 'required' : '' }}
            placeholder="{{ $placeholder }}"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500
                    @error($name) border-red-500 @enderror"
        >
    @endif

    @error($name)
        <div class="text-red-500 text-sm mt-1">
            {{ $message }}
        </div>
    @enderror
</div>
