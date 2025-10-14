@extends('layouts.default')

@section('content')
    {{-- Hero Component --}}
    @include('partials.hero')
    {{-- Periodicals Component --}}

    {{-- Useful Links Component --}}
    {{-- @include('partials.tools-application') --}}

     @include('partials.periodicals')

    {{-- Advanced Search Component --}}
@endsection
