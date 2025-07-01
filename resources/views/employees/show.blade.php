@extends('layouts.default')

@section('title', 'Employee Details')

@section('content')
    <h1>Employee Details</h1>
    <a href="{{ route('home.employees') }}" class="btn btn-secondary mb-3">Back to List</a>
    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @else
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $employee['name'] }}</h5>
                <p class="card-text"><strong>ID:</strong> {{ $employee['id'] }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $employee['email'] }}</p>
                <p class="card-text"><strong>Phone:</strong> {{ $employee['phone'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Company:</strong> {{ $employee['company']['name'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Address:</strong> {{ $employee['address']['street'] ?? 'N/A' }}, {{ $employee['address']['city'] ?? 'N/A' }}, {{ $employee['address']['zipcode'] ?? 'N/A' }}</p>
                <p class="card-text"><strong>Website:</strong> {{ $employee['website'] ?? 'N/A' }}</p>
            </div>
        </div>
    @endif
@endsection
