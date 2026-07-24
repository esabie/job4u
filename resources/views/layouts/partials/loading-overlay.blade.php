<div
    id="global-loader"
    class="fixed inset-0 z-[9999] items-center justify-center bg-white/75 backdrop-blur-sm transition-opacity duration-300"
    style="display: none;"
    aria-hidden="true"
    aria-live="assertive"
    aria-busy="false"
>
    <div class="flex flex-col items-center gap-5 rounded-3xl border border-slate-200/80 bg-white px-10 py-8 shadow-2xl shadow-[#1E3A6D]/10">
        <x-spinner size="xl" color="brand" />
        <p id="global-loader-message" class="text-sm font-semibold tracking-wide text-[#1E3A6D]">
            Loading...
        </p>
    </div>
</div>

<template id="button-spinner-template">
    <svg class="h-4 w-4 job4u-spinner shrink-0" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <circle class="job4u-spinner__track" cx="22" cy="22" r="18" stroke="currentColor" stroke-width="3" stroke-opacity="0.2"/>
        <circle class="job4u-spinner__arc" cx="22" cy="22" r="18" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
    </svg>
</template>
