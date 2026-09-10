@php
    $name = auth()->user()->name;
    $initials = collect(preg_split('/\s+/', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
@endphp

<a href="{{ route('profile.edit') }}"
   {{ $attributes->merge([
       'class' => 'group inline-flex items-center gap-2.5 text-slate-700 hover:text-[#1E3A6D] transition',
       'title' => 'View your profile',
       'aria-label' => 'View profile for '.$name,
   ]) }}>
    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#1E3A6D] text-[11px] font-bold tracking-wide text-white">
        {{ $initials }}
    </span>
    <span class="min-w-0 text-left">
        <span class="block truncate text-sm font-semibold leading-tight max-w-[140px] sm:max-w-[180px]">
            {{ $name }}
        </span>
        <span class="block text-xs font-medium text-slate-400 group-hover:text-[#1E3A6D]/70 leading-tight">
            View profile
        </span>
    </span>
</a>
