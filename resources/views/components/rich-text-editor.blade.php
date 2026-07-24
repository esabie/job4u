@props([
    'name' => 'description',
    'value' => '',
    'placeholder' => 'Describe the role, responsibilities, and requirements...',
    'required' => false,
])

@php
    $initialValue = old($name, $value);
@endphp

<div
    data-rich-text-editor
    data-placeholder="{{ $placeholder }}"
    @if($required) data-required="true" @endif
    class="rich-text-editor rounded-xl border border-gray-300 overflow-hidden bg-white focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500"
>
    <div data-rich-text-area class="min-h-[220px] text-slate-800"></div>

    <textarea
        data-rich-text-input
        name="{{ $name }}"
        class="hidden"
        @if($required) required @endif
    >{{ $initialValue }}</textarea>
</div>
