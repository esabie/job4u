@extends('errors.layout')

@section('title', 'Too many requests')
@section('eyebrow', 'Slow down')
@section('heading', 'You are doing that too quickly')
@section('message', 'For security, we temporarily limit repeated requests. Wait a moment, then try again.')

@section('actions')
    <button
        type="button"
        onclick="if (history.length > 1) { history.back(); } else { window.location.href = @js(url('/')); }"
        class="inline-flex w-full items-center justify-center rounded-lg bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white hover:bg-blue-800 transition"
    >
        Try again
    </button>
    <a href="{{ url('/') }}"
       class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Back to home
    </a>
@endsection
