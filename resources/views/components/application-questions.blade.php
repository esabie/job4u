@props([
    'questions',
])

@if ($questions->isNotEmpty())
    <div class="space-y-5 pt-2 border-t border-slate-200">
        <h3 class="text-sm font-semibold text-slate-800">
            Additional Questions
        </h3>

        @foreach ($questions as $question)
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    {{ $question->question }}
                    @unless ($question->is_required)
                        <span class="font-normal text-slate-500">(optional)</span>
                    @endunless
                </label>

                @if ($question->type === \App\Enums\QuestionType::Textarea)
                    <textarea
                        name="answers[{{ $question->id }}]"
                        rows="4"
                        @required($question->is_required)
                        class="w-full border rounded-lg px-3 py-2"
                    >{{ old('answers.'.$question->id) }}</textarea>
                @elseif ($question->type === \App\Enums\QuestionType::YesNo)
                    <select
                        name="answers[{{ $question->id }}]"
                        @required($question->is_required)
                        class="w-full border rounded-lg px-3 py-2"
                    >
                        <option value="" @selected(old('answers.'.$question->id) === null || old('answers.'.$question->id) === '')>
                            Select an answer
                        </option>
                        <option value="yes" @selected(old('answers.'.$question->id) === 'yes')>Yes</option>
                        <option value="no" @selected(old('answers.'.$question->id) === 'no')>No</option>
                    </select>
                @else
                    <input
                        type="text"
                        name="answers[{{ $question->id }}]"
                        value="{{ old('answers.'.$question->id) }}"
                        @required($question->is_required)
                        class="w-full border rounded-lg px-3 py-2"
                    >
                @endif

                <x-input-error :messages="$errors->get('answers.'.$question->id)" class="mt-1" />
            </div>
        @endforeach
    </div>
@endif
