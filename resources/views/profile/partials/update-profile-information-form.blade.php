<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            @if ($user->isCandidate())
                {{ __('Your name and email are fixed. Update your other profile details and keep a CV ready for quick applications.') }}
            @else
                {{ __('Your name and email are fixed and cannot be changed from this page.') }}
            @endif
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" class="mt-1 block w-full bg-slate-50 text-slate-700"
                          :value="$user->name" :disabled="true" readonly />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" class="mt-1 block w-full bg-slate-50 text-slate-700"
                          :value="$user->email" :disabled="true" readonly />
        </div>
    </div>

    @if ($user->isCandidate())
        <form method="post"
              action="{{ route('profile.update') }}"
              enctype="multipart/form-data"
              class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                  :value="old('phone', $user->phone)" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                                  :value="old('location', $user->location)"
                                  placeholder="e.g. Accra, Ghana" />
                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                </div>
            </div>

            <div>
                <x-input-label for="headline" :value="__('Professional headline')" />
                <x-text-input id="headline" name="headline" type="text" class="mt-1 block w-full"
                              :value="old('headline', $user->headline)"
                              placeholder="e.g. Product Manager | Fintech" />
                <x-input-error class="mt-2" :messages="$errors->get('headline')" />
            </div>

            <div>
                <x-input-label for="summary" :value="__('About you')" />
                <textarea id="summary" name="summary" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="A short summary of your experience and what you're looking for...">{{ old('summary', $user->summary) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('summary')" />
            </div>

            <div>
                <x-input-label for="cv" :value="__('Saved CV')" />

                @if ($user->hasSavedCv())
                    <div class="mt-2 mb-3 flex flex-col sm:flex-row sm:items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <a href="{{ asset('storage/'.$user->cv_path) }}"
                           target="_blank"
                           class="text-sm font-semibold text-[#1E3A6D] hover:underline">
                            View current CV
                        </a>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remove_cv" value="1"
                                   class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            Remove saved CV
                        </label>
                    </div>
                @endif

                <input id="cv" name="cv" type="file"
                       accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                       class="mt-1 block w-full text-sm text-slate-600" />
                <p class="mt-1 text-sm text-slate-500">
                    PDF, DOC, or DOCX. Max 2 MB. This CV can be reused when you apply for jobs.
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('cv')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    @endif
</section>
