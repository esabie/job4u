@extends('layouts.employer')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- ===================== -->
    <!-- HEADER -->
    <!-- ===================== -->
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h1 class="text-4xl font-extrabold text-[#1E3A6D]">
                Post a Premium Listing
            </h1>
            <p class="mt-2 text-slate-600 max-w-xl">
                Promote high-priority roles with enhanced visibility and access to a stronger candidate
                pool. Premium Listings are built for speed, reach and quality hiring outcomes.
            </p>
        </div>

        <a href="{{ route('employer.dashboard') }}"
           class="px-5 py-2.5 rounded-xl border border-slate-300
                  text-slate-600 font-semibold hover:bg-slate-100 transition">
            Cancel
        </a>
    </div>

    <!-- ===================== -->
    <!-- FORM CARD -->
    <!-- ===================== -->
    <form method="POST"
          action="{{ route('employer.jobs.store') }}"
          class="bg-white rounded-3xl shadow-sm border p-10 space-y-10">
        @csrf

        <!-- ===================== -->
        <!-- BASIC INFO -->
        <!-- ===================== -->
        <div>
            <h2 class="text-lg font-bold text-slate-900 mb-6">
                Job Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Job Title -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Job Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="e.g. Senior Product Manager"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Company Name
                    </label>
                    <input
                        type="text"
                        name="company_name"
                        value="{{ old('company_name') }}"
                        placeholder="e.g. Tech Company Ltd"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Location
                    </label>
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="e.g. Accra, Ghana"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>

                <!-- Employment Type -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Employment Type
                    </label>
                    <select
                        name="employment_type"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                        <option value="">Select type</option>
                        <option>Full Time</option>
                        <option>Part Time</option>
                    </select>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Category
                    </label>
                    <select
                        name="category"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                        <option value="">Select category</option>
                        <option>Administration</option>
                        <option>Construction</option>
                        <option>Finance</option>
                        <option>Healthcare</option>
                        <option>Hospitality</option>
                        <option>Legal</option>
                        <option>Technology</option>
                        <option>Other</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- SALARY -->
        <!-- ===================== -->
        <div>
            <h2 class="text-lg font-bold text-slate-900 mb-6">
                Salary Range (Optional)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Currency -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Currency
                    </label>
                    <select
                        name="currency"
                        class="w-full rounded-xl border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select currency</option>

                        <option value="AED">AED – UAE Dirham</option>
                        <option value="AUD">AUD – Australian Dollar</option>
                        <option value="BRL">BRL – Brazilian Real</option>
                        <option value="CAD">CAD – Canadian Dollar</option>
                        <option value="CHF">CHF – Swiss Franc</option>
                        <option value="CNY">CNY – Chinese Yuan</option>
                        <option value="DKK">DKK – Danish Krone</option>
                        <option value="EGP">EGP – Egyptian Pound</option>
                        <option value="EUR">EUR – Euro</option>
                        <option value="GHS">GHS – Ghana Cedi</option>
                        <option value="GBP">GBP – Great British Pound</option>
                        <option value="HKD">HKD – Hong Kong Dollar</option>
                        <option value="INR">INR – Indian Rupee</option>
                        <option value="JPY">JPY – Japanese Yen</option>
                        <option value="KES">KES – Kenyan Shilling</option>
                        <option value="KRW">KRW – South Korean Won</option>
                        <option value="MAD">MAD – Moroccan Dirham</option>
                        <option value="MXN">MXN – Mexican Peso</option>
                        <option value="NGN">NGN – Nigerian Naira</option>
                        <option value="NOK">NOK – Norwegian Krone</option>
                        <option value="NZD">NZD – New Zealand Dollar</option>
                        <option value="PLN">PLN – Polish Zloty</option>
                        <option value="RUB">RUB – Russian Ruble</option>
                        <option value="SAR">SAR – Saudi Riyal</option>
                        <option value="SEK">SEK – Swedish Krona</option>
                        <option value="SGD">SGD – Singapore Dollar</option>
                        <option value="TRY">TRY – Turkish Lira</option>
                        <option value="TZS">TZS – Tanzanian Shilling</option>
                        <option value="UGX">UGX – Ugandan Shilling</option>
                        <option value="USD">USD – US Dollar</option>
                        <option value="ZAR">ZAR – South African Rand</option>

                    </select>
                </div>

                <!-- Minimum Salary -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Minimum Salary
                    </label>
                    <input
                        type="number"
                        name="salary_min"
                        value="{{ old('salary_min') }}"
                        placeholder="e.g. 12000"
                        class="w-full rounded-xl border-gray-300 px-4 py-3"
                    >
                </div>

                <!-- Maximum Salary -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Maximum Salary
                    </label>
                    <input
                        type="number"
                        name="salary_max"
                        value="{{ old('salary_max') }}"
                        placeholder="e.g. 18000"
                        class="w-full rounded-xl border-gray-300 px-4 py-3"
                    >
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- DESCRIPTION -->
        <!-- ===================== -->
        <div>
            <h2 class="text-lg font-bold text-slate-900 mb-6">
                Job Description
            </h2>

            <textarea
                name="description"
                rows="7"
                placeholder="Describe the role, responsibilities, and requirements..."
                class="w-full rounded-xl border-gray-300 px-4 py-4
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >{{ old('description') }}</textarea>
        </div>

        <!-- ===================== -->
        <!-- ACTIONS -->
        <!-- ===================== -->
        <div class="flex items-center justify-center gap-4 pt-6 border-t">

            <a href="{{ route('employer.dashboard') }}"
               class="px-6 py-3 rounded-xl border border-slate-300
                      text-slate-600 font-semibold hover:bg-slate-100 transition">
                Cancel
            </a>

            <button
                type="submit"
                class="px-10 py-3 rounded-xl bg-[#1E3A6D] text-white
                       font-semibold hover:bg-blue-700 transition shadow-md">
                Publish Listing
            </button>

        </div>

    </form>

</div>

@endsection
