@props([
    'job',
    'saved' => false,
])

@php
    $buttonClass = 'inline-flex items-center justify-center gap-1.5 text-sm font-semibold transition';
@endphp

@auth
    @if (auth()->user()->isCandidate())
        @if ($saved)
            <form method="POST" action="{{ route('candidate.saved.destroy', $job) }}" class="inline">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    {{ $attributes->class([$buttonClass, 'text-[#1E3A6D] hover:underline']) }}
                    title="Remove from saved jobs"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 shrink-0">
                        <path d="M5.25 3.75A1.5 1.5 0 0 1 6.75 2.25h10.5a1.5 1.5 0 0 1 1.5 1.5v16.878a.75.75 0 0 1-1.17.624L12 17.25l-5.58 3.752a.75.75 0 0 1-1.17-.624V3.75Z" />
                    </svg>
                    Saved
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('candidate.saved.store', $job) }}" class="inline">
                @csrf
                <button
                    type="submit"
                    {{ $attributes->class([$buttonClass, 'text-slate-600 hover:text-[#1E3A6D] hover:underline']) }}
                    title="Save this job"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                    Save
                </button>
            </form>
        @endif
    @endif
@else
    <a href="{{ route('login') }}"
       {{ $attributes->class([$buttonClass, 'text-slate-600 hover:text-[#1E3A6D] hover:underline']) }}
       title="Log in to save this job">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
        </svg>
        Save
    </a>
@endauth
