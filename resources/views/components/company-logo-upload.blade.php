@props([
    'job' => null,
])

<div>
    <label class="block text-sm font-semibold text-slate-700 mb-2">
        Company Logo <span class="font-normal text-slate-500">(optional)</span>
    </label>

    @if ($job?->company_logo)
        <div class="mb-4 flex items-center gap-4">
            <x-company-logo :job="$job" size="lg" />
            <p class="text-sm text-slate-600">
                Current logo. Upload a new file below to replace it.
            </p>
        </div>
    @endif

    <input
        type="file"
        name="company_logo"
        accept="image/jpeg,image/png"
        class="w-full rounded-xl border border-gray-300 px-4 py-3
               file:mr-4 file:rounded-lg file:border-0 file:bg-[#1E3A6D]/10
               file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#1E3A6D]
               hover:file:bg-[#1E3A6D]/15"
    >

    <p class="mt-2 text-sm text-slate-500">
        Accepted formats: JPG or PNG. Maximum file size: 2 MB.
    </p>

    <div class="mt-3 rounded-xl border border-blue-100 bg-blue-50/60 px-4 py-3">
        <p class="text-sm text-slate-700">
            <span class="font-semibold text-[#1E3A6D]">Tip:</span>
            Adding your company logo helps job seekers recognize your brand at a glance,
            which can lead to more applications on your listing.
        </p>
    </div>

    @error('company_logo')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
