@extends('errors.layout')

@section('title', 'Temporarily unavailable')
@section('eyebrow', 'Unavailable')
@section('heading', 'We will be right back')
@section('message', 'Job4U is temporarily unavailable while we perform maintenance. Please try again shortly.')

@section('actions')
    <a href="{{ url('/') }}"
       class="inline-flex w-full items-center justify-center rounded-lg bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white hover:bg-blue-800 transition">
        Try again
    </a>
@endsection
