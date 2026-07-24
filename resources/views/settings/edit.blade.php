@extends('layouts.employer')

@section('content')

<section class="bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-6 py-12">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
                Settings
            </h1>
            <p class="text-slate-600 mt-1">
                Manage your notification preferences and account.
            </p>
        </div>

        @if (session('status') === 'settings-updated')
            <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                Settings saved.
            </div>
        @endif

        <!-- NOTIFICATIONS -->
        <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-6">
                Email Notifications
            </h2>

            <form method="POST" action="{{ route('settings.update') }}" data-no-loader class="space-y-6">
                @csrf
                @method('PATCH')

                @if (auth()->user()->role === 'candidate')
                    <label class="flex items-start gap-3">
                        <input type="checkbox" name="notify_application_updates" value="1"
                               @checked(auth()->user()->notify_application_updates)
                               class="mt-1 rounded border-gray-300 text-[#1E3A6D] focus:ring-[#1E3A6D]">
                        <span>
                            <span class="block text-sm font-semibold text-slate-800">Application status updates</span>
                            <span class="block text-sm text-slate-500">Email me when an employer updates the status of one of my applications.</span>
                        </span>
                    </label>

                    <label class="flex items-start gap-3">
                        <input type="checkbox" name="notify_job_alerts" value="1"
                               @checked(auth()->user()->notify_job_alerts)
                               class="mt-1 rounded border-gray-300 text-[#1E3A6D] focus:ring-[#1E3A6D]">
                        <span>
                            <span class="block text-sm font-semibold text-slate-800">Job alerts</span>
                            <span class="block text-sm text-slate-500">Email me when a newly posted job matches one of my job alerts.</span>
                        </span>
                    </label>
                @else
                    <p class="text-sm text-slate-500">
                        Notification preferences are currently available to job seekers. Your account details can be managed below.
                    </p>
                @endif

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#1E3A6D] text-white
                                   font-semibold hover:bg-blue-700 transition">
                        Save Preferences
                    </button>
                </div>
            </form>
        </div>

        <!-- ACCOUNT -->
        <div class="bg-white rounded-2xl shadow-sm border p-8">
            <h2 class="text-lg font-bold text-slate-900 mb-4">
                Account
            </h2>
            <p class="text-sm text-slate-500 mb-4">
                Update your name, email, password, or delete your account.
            </p>
            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-slate-300
                      text-slate-700 font-semibold hover:bg-slate-100 transition">
                Manage Profile &amp; Security
            </a>
        </div>

    </div>
</section>

@endsection
