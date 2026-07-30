@extends('layouts.employer')

@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-6 md:px-10 py-8 md:py-10 space-y-6">

    <div>
        <h1 class="text-3xl font-extrabold text-[#1E3A6D]">
            Profile
        </h1>
        <p class="text-slate-600 mt-1">
            @if (auth()->user()->isCandidate())
                Update your profile details, CV, and security settings.
            @else
                View your account information and update your security settings.
            @endif
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6 sm:p-8">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6 sm:p-8">
        @include('profile.partials.update-password-form')
    </div>

</div>

@endsection
