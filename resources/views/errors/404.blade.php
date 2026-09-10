@extends('errors.layout')

@section('title', 'Page not found')
@section('eyebrow', 'Not found')
@section('heading', 'We could not find that page')
@section('message', 'The link may be broken, or the page may have been moved. Check the URL or head back to the homepage.')

@section('actions')
    <a href="{{ url('/') }}"
       class="inline-flex w-full items-center justify-center rounded-lg bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white hover:bg-blue-800 transition">
        Back to home
    </a>
    <a href="{{ route('jobs.index') }}"
       class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Browse jobs
    </a>
@endsection
