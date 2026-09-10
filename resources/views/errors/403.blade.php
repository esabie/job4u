@extends('errors.layout')

@section('title', 'Access denied')
@section('eyebrow', 'Access denied')
@section('heading', 'You do not have access')
@section('message', 'This page is only available to authorized accounts. If you think this is a mistake, contact support.')

@section('actions')
    <a href="{{ url('/') }}"
       class="inline-flex w-full items-center justify-center rounded-lg bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white hover:bg-blue-800 transition">
        Back to home
    </a>
    <a href="{{ route('login') }}"
       class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Sign in
    </a>
@endsection
