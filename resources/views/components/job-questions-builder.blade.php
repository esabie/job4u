@props([
    'questions' => [],
])

@php
    $initial = collect(old('questions', $questions))
        ->map(fn ($question) => [
            'id' => $question['id'] ?? ($question->id ?? null),
            'question' => $question['question'] ?? ($question->question ?? ''),
            'type' => $question['type'] ?? ($question->type?->value ?? $question->type ?? 'text'),
            'is_required' => (bool) ($question['is_required'] ?? ($question->is_required ?? true)),
        ])
        ->values()
        ->all();
@endphp

<div
    x-data="jobQuestionsBuilder(@js($initial))"
    class="space-y-4"
>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Application Questions
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                Optional. Add extra questions candidates must answer when applying.
            </p>
        </div>

        <button
            type="button"
            @click="addQuestion()"
            class="shrink-0 px-4 py-2 rounded-xl border border-[#1E3A6D]/30 text-[#1E3A6D]
                   text-sm font-semibold hover:bg-[#1E3A6D]/10 transition"
        >
            + Add Question
        </button>
    </div>

    <template x-if="questions.length === 0">
        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-sm text-slate-500 text-center">
            No extra questions yet. Candidates will only upload a CV unless you add questions here.
        </div>
    </template>

    <template x-for="(question, index) in questions" :key="index">
        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <p class="text-sm font-semibold text-slate-700" x-text="'Question ' + (index + 1)"></p>
                <button
                    type="button"
                    @click="removeQuestion(index)"
                    class="text-sm font-semibold text-red-600 hover:text-red-700"
                >
                    Remove
                </button>
            </div>

            <input type="hidden" :name="'questions[' + index + '][id]'" x-model="question.id">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Question</label>
                <input
                    type="text"
                    :name="'questions[' + index + '][question]'"
                    x-model="question.question"
                    placeholder="e.g. How many years of experience do you have?"
                    class="w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Answer type</label>
                    <select
                        :name="'questions[' + index + '][type]'"
                        x-model="question.type"
                        class="w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        @foreach (\App\Enums\QuestionType::cases() as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input
                            type="checkbox"
                            :name="'questions[' + index + '][is_required]'"
                            value="1"
                            x-model="question.is_required"
                            class="rounded border-gray-300 text-[#1E3A6D] focus:ring-[#1E3A6D]"
                        >
                        Required
                    </label>
                </div>
            </div>
        </div>
    </template>

    @error('questions')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
    @error('questions.*')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
