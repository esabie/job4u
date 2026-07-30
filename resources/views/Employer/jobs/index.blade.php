@extends('layouts.employer')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10"
     x-data="{
        hideOpen: false,
        hideTitle: '',
        hideAction: '',
        openHide(title, action) {
            this.hideTitle = title;
            this.hideAction = action;
            this.hideOpen = true;
            document.body.classList.add('overflow-hidden');
        },
        closeHide() {
            this.hideOpen = false;
            this.hideTitle = '';
            this.hideAction = '';
            document.body.classList.remove('overflow-hidden');
        }
     }">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1E3A6D]">
                My Jobs
            </h1>
            <p class="mt-2 text-slate-600">
                Manage all jobs you’ve posted.
            </p>
        </div>

        <a href="{{ route('employer.jobs.create') }}"
           class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#1E3A6D] text-white font-semibold
                  hover:bg-blue-700 transition shadow-md shrink-0">
            + Post Job
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

        @if ($jobs->count() === 0)

            <div class="p-8 sm:p-12 text-center">
                <h3 class="text-lg font-semibold text-slate-800">
                    No jobs posted yet
                </h3>
                <p class="text-slate-600 mt-2">
                    Create your first job listing to start receiving applications.
                </p>

                <a href="{{ route('employer.jobs.create') }}"
                   class="inline-block mt-6 px-6 py-3 rounded-xl bg-[#1E3A6D]
                          text-white font-semibold hover:bg-blue-700 transition">
                    Post Your First Job
                </a>
            </div>

        @else

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[720px]">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-slate-600 font-semibold">
                            <th class="px-6 py-4">Job</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Posted</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach ($jobs as $job)
                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <x-company-logo :job="$job" size="sm" />
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-900 truncate">
                                                {{ $job->title }}
                                            </p>
                                            <p class="text-slate-500 text-xs truncate">
                                                {{ $job->location }} • {{ $job->employment_type }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-middle text-slate-700 whitespace-nowrap">
                                    {{ $job->category }}
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    @if ($job->is_active)
                                        <span class="inline-flex px-3 py-1 rounded-full
                                                     text-xs font-semibold
                                                     bg-green-100 text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full
                                                     text-xs font-semibold
                                                     bg-gray-200 text-gray-700">
                                            Hidden
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 align-middle text-slate-500 whitespace-nowrap">
                                    {{ $job->created_at->diffForHumans() }}
                                </td>

                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center justify-end gap-3 whitespace-nowrap">
                                        <a href="{{ route('employer.jobs.applications', $job) }}"
                                           class="text-[#1E3A6D] font-semibold hover:underline">
                                            Applications
                                        </a>

                                        <a href="{{ route('employer.jobs.edit', $job) }}"
                                           class="text-[#1E3A6D] font-semibold hover:underline">
                                            Edit
                                        </a>

                                        @if ($job->is_active)
                                            <button
                                                type="button"
                                                class="text-red-500 font-semibold hover:underline"
                                                @click="openHide(@js($job->title), @js(route('employer.jobs.destroy', $job)))">
                                                Hide
                                            </button>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $jobs->links() }}
            </div>

        @endif

    </div>

    <style>
        .job-hide-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .job-hide-modal__backdrop {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
        }

        .job-hide-modal__panel {
            position: relative;
            width: 100%;
            max-width: 28rem;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow:
                0 24px 48px -12px rgba(15, 23, 42, 0.25),
                0 0 0 1px rgba(15, 23, 42, 0.03);
            overflow: hidden;
        }

        .job-hide-modal__close {
            position: absolute;
            top: 0.85rem;
            right: 0.85rem;
            width: 2rem;
            height: 2rem;
            border: 0;
            border-radius: 0.5rem;
            background: transparent;
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .job-hide-modal__close:hover {
            background: #f1f5f9;
            color: #475569;
        }

        .job-hide-modal__body {
            padding: 1.5rem 1.5rem 1.25rem;
        }

        .job-hide-modal__header {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            padding-right: 1.5rem;
        }

        .job-hide-modal__icon {
            flex-shrink: 0;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            background: #eff6ff;
            color: #1e3a6d;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .job-hide-modal__title {
            margin: 0;
            font-size: 1.125rem;
            line-height: 1.35;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .job-hide-modal__subtitle {
            margin: 0.35rem 0 0;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #64748b;
        }

        .job-hide-modal__job {
            margin-top: 1.15rem;
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            background: #f8fafc;
        }

        .job-hide-modal__job-label {
            margin: 0;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #94a3b8;
        }

        .job-hide-modal__job-title {
            margin: 0.25rem 0 0;
            font-size: 0.925rem;
            font-weight: 600;
            color: #1e293b;
            line-height: 1.4;
        }

        .job-hide-modal__note {
            margin: 0.9rem 0 0;
            font-size: 0.8rem;
            line-height: 1.5;
            color: #64748b;
        }

        .job-hide-modal__footer {
            display: flex;
            flex-direction: column-reverse;
            gap: 0.65rem;
            padding: 1rem 1.5rem 1.25rem;
            border-top: 1px solid #eef2f7;
            background: #fafbfc;
        }

        .job-hide-modal__btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 2.65rem;
            padding: 0.65rem 1rem;
            border-radius: 0.7rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .job-hide-modal__btn--ghost {
            border: 1px solid #dbe2ea;
            background: #fff;
            color: #334155;
        }

        .job-hide-modal__btn--ghost:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .job-hide-modal__btn--primary {
            border: 1px solid #1e3a6d;
            background: #1e3a6d;
            color: #fff;
            width: 100%;
        }

        .job-hide-modal__btn--primary:hover {
            background: #162d57;
            border-color: #162d57;
        }

        .job-hide-modal__btn--primary:disabled {
            cursor: wait;
            opacity: 0.8;
        }

        .job-hide-modal__form {
            width: 100%;
        }

        @media (min-width: 640px) {
            .job-hide-modal__body {
                padding: 1.75rem 1.75rem 1.35rem;
            }

            .job-hide-modal__footer {
                flex-direction: row;
                justify-content: flex-end;
                align-items: center;
                padding: 1rem 1.75rem 1.35rem;
            }

            .job-hide-modal__form {
                width: auto;
            }

            .job-hide-modal__btn--primary {
                width: auto;
                min-width: 7.5rem;
            }

            .job-hide-modal__btn--ghost {
                min-width: 6.5rem;
            }
        }
    </style>

    <div
        x-show="hideOpen"
        x-cloak
        class="job-hide-modal"
        aria-modal="true"
        role="dialog"
        aria-labelledby="hide-job-title"
        @keydown.escape.window="closeHide()"
    >
        <div
            class="job-hide-modal__backdrop"
            @click="closeHide()"
            x-show="hideOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <div
            class="job-hide-modal__panel"
            @click.stop
            x-show="hideOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 sm:scale-95"
        >
            <button type="button" class="job-hide-modal__close" @click="closeHide()" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="job-hide-modal__body">
                <div class="job-hide-modal__header">
                    <div class="job-hide-modal__icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>

                    <div>
                        <h2 id="hide-job-title" class="job-hide-modal__title">
                            Hide this job posting?
                        </h2>
                        <p class="job-hide-modal__subtitle">
                            This role will be removed from the public job board immediately.
                        </p>
                    </div>
                </div>

                <div class="job-hide-modal__job">
                    <p class="job-hide-modal__job-label">Job</p>
                    <p class="job-hide-modal__job-title" x-text="hideTitle"></p>
                </div>

                <p class="job-hide-modal__note">
                    You can reactivate it later from Edit.
                </p>
            </div>

            <div class="job-hide-modal__footer">
                <button type="button" class="job-hide-modal__btn job-hide-modal__btn--ghost" @click="closeHide()">
                    Cancel
                </button>

                <form method="POST" class="job-hide-modal__form" :action="hideAction" data-loader-message="Hiding job...">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="job-hide-modal__btn job-hide-modal__btn--primary"
                        data-loading-text="Hiding...">
                        Hide job
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
