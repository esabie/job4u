@extends('errors.layout')

@section('title', 'Sign in required')
@section('eyebrow', 'Sign in required')
@section('heading', 'Please sign in to continue')
@section('message', 'You need an active account session to view this page.')

@section('actions')
    <a href="{{ route('login') }}"
       class="inline-flex w-full items-center justify-center rounded-lg bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white hover:bg-blue-800 transition">
        Sign in
    </a>
    <a href="{{ url('/') }}"
       class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Back to home
    </a>
@endsection
