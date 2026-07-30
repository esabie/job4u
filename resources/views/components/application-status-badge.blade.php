@props(['status'])

@php
    $statusEnum = $status instanceof \App\Enums\ApplicationStatus
        ? $status
        : \App\Enums\ApplicationStatus::tryFromMixed(is_object($status) ? ($status->value ?? null) : $status);
@endphp

@if ($statusEnum)
    <span {{ $attributes->merge(['class' => 'inline-flex px-3 py-1 rounded-full text-xs font-semibold '.$statusEnum->badgeClasses()]) }}>
        {{ $statusEnum->label() }}
    </span>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700']) }}>
        {{ ucfirst((string) $status) }}
    </span>
@endif
