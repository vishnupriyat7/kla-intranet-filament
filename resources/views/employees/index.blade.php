@extends('layouts.default')

@section('title', 'Employees List')

@section('content')

    <div class="container-fluid populer-news py-5">
        <div class="container py-5">
            <h1>Employees</h1>
        </div>
        <div class="container py-12 d-flex justify-content-center">
            <div class="col-12">
                @if(isset($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee['id'] }}</td>
                                    <td>{{ $employee['name'] }}</td>
                                    <td>{{ $employee['email'] }}</td>
                                    <td>{{ $employee['phone'] ?? 'N/A' }}</td>
                                    <td>{{ $employee['company']['name'] ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('home.employee-show', $employee['id']) }}"
                                            class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
