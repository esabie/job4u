@props([
    'size' => 'md',
    'color' => 'brand',
])

@php
    $sizes = [
        'sm' => 'h-4 w-4',
        'md' => 'h-8 w-8',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16',
    ];

    $colors = [
        'brand' => 'text-[#1E3A6D]',
        'white' => 'text-white',
        'slate' => 'text-slate-500',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $colors[$color] ?? $colors['brand'];
@endphp

<div {{ $attributes->merge(['class' => "inline-flex flex-col items-center gap-3 {$colorClass}"]) }} role="status" aria-live="polite" aria-label="Loading">
    <svg class="{{ $sizeClass }} job4u-spinner" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle class="job4u-spinner__track" cx="22" cy="22" r="18" stroke="currentColor" stroke-width="3" stroke-opacity="0.15"/>
        <circle class="job4u-spinner__arc" cx="22" cy="22" r="18" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
    </svg>

    @if(trim($slot) !== '')
        <span class="text-sm font-medium text-slate-600">{{ $slot }}</span>
    @endif
</div>
