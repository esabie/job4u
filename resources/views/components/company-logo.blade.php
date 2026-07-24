@props([
    'job',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-10 w-10 text-xs',
        'md' => 'h-12 w-12 text-sm',
        'lg' => 'h-16 w-16 text-base',
        'xl' => 'h-20 w-20 text-lg',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $initials = strtoupper(substr($job->company_name, 0, 2));
@endphp

@if ($job->company_logo)
    <img
        {{ $attributes->merge(['class' => "{$sizeClass} rounded-xl object-cover border border-slate-200 bg-white shrink-0"]) }}
        src="{{ Storage::url($job->company_logo) }}"
        alt="{{ $job->company_name }} logo"
    >
@else
    <div
        {{ $attributes->merge(['class' => "{$sizeClass} rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#1E3A6D] font-bold shrink-0"]) }}
        aria-hidden="true"
    >
        {{ $initials }}
    </div>
@endif
