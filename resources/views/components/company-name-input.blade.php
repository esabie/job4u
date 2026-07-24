@props([
    'name' => 'company_name',
    'value' => '',
    'placeholder' => 'e.g. Tech Company Ltd',
    'required' => false,
])

@php
    $suggestUrl = route('employer.companies.suggest');
    $initialValue = old($name, $value);
@endphp

<div
    x-data="companyAutocomplete(@js($suggestUrl), @js($initialValue))"
    @click.outside="close()"
    class="relative"
>
    <input
        type="text"
        name="{{ $name }}"
        x-model="query"
        @input.debounce.300ms="search()"
        @focus="search()"
        @keydown.arrow-down.prevent="highlightNext()"
        @keydown.arrow-up.prevent="highlightPrevious()"
        @keydown.enter.prevent="selectHighlighted()"
        @keydown.escape="close()"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500']) }}
        autocomplete="off"
        role="combobox"
        aria-autocomplete="list"
        :aria-expanded="open"
    >

    <ul
        x-show="open"
        x-cloak
        class="absolute z-20 mt-1 w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
        role="listbox"
    >
        <template x-for="(suggestion, index) in suggestions" :key="suggestion.name">
            <li>
                <button
                    type="button"
                    @click="select(suggestion)"
                    class="flex w-full items-center justify-between px-4 py-3 text-left text-sm transition hover:bg-slate-50"
                    :class="{ 'bg-blue-50': highlighted === index }"
                    role="option"
                    :aria-selected="highlighted === index"
                >
                    <span class="font-medium text-slate-900" x-text="suggestion.name"></span>
                    <span class="text-xs text-slate-500">
                        <span x-show="suggestion.is_mine">Your company</span>
                        <span
                            x-show="!suggestion.is_mine"
                            x-text="`${suggestion.job_count} job${suggestion.job_count === 1 ? '' : 's'} on Job4U`"
                        ></span>
                    </span>
                </button>
            </li>
        </template>
    </ul>

    <p class="mt-1 text-xs text-slate-500">
        Start typing to see companies already listed on Job4U.
    </p>
</div>
