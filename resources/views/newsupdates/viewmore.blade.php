@extends('layouts.default')

@section('content')
<!-- Single Product Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        {{-- <ol class="breadcrumb justify-content-start mb-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-dark">Single Page</li>
        </ol> --}}
        <div class="row g-4">
            <div class="row g-4">
                @foreach ($newsupdates as $news)
                    <div class="features-content d-flex flex-column">
                        <a href="{{ asset('storage/' . $news->path)}}" class="h6" target="_blank"><i
                                class="fas fa-comment-dots me-1"></i>
                            {{ $news->title }}
                        </a>
                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($news->date)->format('M d Y') }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Single Product End -->
@endsection
