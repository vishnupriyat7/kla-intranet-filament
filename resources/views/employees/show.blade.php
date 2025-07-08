@extends('layouts.default')

@section('title', 'Employee Details')

@section('content')
    <div class="container-fluid populer-news py-5">
        <div class="container py-5">
            <h1>Employees</h1>
        </div>
        <div class="container py-12 d-flex justify-content-center">
            <div class="col-12">
                <h1>Employee Details</h1>
                <a href="{{ route('home.employees') }}" class="btn btn-secondary mb-3">Back to List</a>
                @if(isset($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $filteredEmployee['name'] }}</h5>
                            <p class="card-text"><strong>Designation:</strong> {{ $filteredEmployee['designation'] ?? 'N/A' }}
                            </p>
                            <p class="card-text"><strong>Section:</strong> {{ $filteredEmployee['section'] ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Pen:</strong> {{ $filteredEmployee['pen'] ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Attendance Id:</strong>
                                {{ $filteredEmployee['attendanceId'] ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Mobile:</strong> {{ $filteredEmployee['mobile'] ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Email:</strong> {{ $filteredEmployee['email'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
