<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Your account's profile information and email address.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label :value="__('Name')" />
            <p class="mt-1 text-gray-900">{{ $user->name }}</p>
        </div>

        <div>
            <x-input-label :value="__('Email')" />
            <p class="mt-1 text-gray-900">{{ $user->email }}</p>
        </div>
    </div>
</section>
