@props([
    'answers',
])

@if ($answers->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'bg-white rounded-2xl p-6 shadow-sm']) }}>
        <h3 class="font-semibold text-slate-800 mb-4">
            Application Answers
        </h3>

        <dl class="space-y-4">
            @foreach ($answers as $answer)
                <div>
                    <dt class="text-sm font-semibold text-slate-700">
                        {{ $answer->jobQuestion->question }}
                    </dt>
                    <dd class="mt-1 text-sm text-slate-600 whitespace-pre-line">
                        @if ($answer->jobQuestion->type === \App\Enums\QuestionType::YesNo)
                            {{ ucfirst($answer->answer) }}
                        @else
                            {{ $answer->answer }}
                        @endif
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
@endif
