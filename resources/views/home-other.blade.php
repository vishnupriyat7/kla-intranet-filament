@extends('layouts.default')

@section('content')
    {{-- Hero Component --}}
    @include('partials.hero-other')
    {{-- Periodicals Component --}}
    @include('partials.periodicals')
    {{-- Useful Links Component --}}
    @include('partials.tools-application')

    {{-- Advanced Search Component --}}
@endsection
