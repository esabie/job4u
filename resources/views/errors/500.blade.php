@extends('errors.layout')

@section('title', 'Something went wrong')
@section('eyebrow', 'Something went wrong')
@section('heading', 'We could not complete that request')
@section('message', 'An unexpected error occurred on our side. Please try again in a moment. If it keeps happening, contact support.')

@section('actions')
    <a href="{{ url('/') }}"
       class="inline-flex w-full items-center justify-center rounded-lg bg-[#1E3A6D] px-6 py-3.5 text-sm font-bold text-white hover:bg-blue-800 transition">
        Back to home
    </a>
@endsection
