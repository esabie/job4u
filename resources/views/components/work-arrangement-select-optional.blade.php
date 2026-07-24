@props([
    'value' => null,
])

<div>
    <label class="block text-sm font-semibold text-slate-700 mb-2">
        Work Arrangement
    </label>
    <select
        name="work_arrangement"
        {{ $attributes->merge(['class' => 'w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500']) }}
    >
        <option value="">Any arrangement</option>
        @foreach (\App\Enums\WorkArrangement::cases() as $arrangement)
            <option value="{{ $arrangement->value }}" @selected(old('work_arrangement', $value) === $arrangement->value)>
                {{ $arrangement->value }}
            </option>
        @endforeach
    </select>
</div>
