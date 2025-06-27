@extends('layouts.default')

{{-- @section('title', 'Employees List') --}}

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
                    <table id="employeeTable" class="table table-bordered display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Section</th>
                                <th>Pen</th>
                                {{-- <th>Photo</th> --}}
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>

                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#employeeTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('employees.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Index column
                    { data: 'name', name: 'name' },
                    { data: 'designation', name: 'designation' },
                    { data: 'section', name: 'section' },
                    { data: 'pen', name: 'pen' }
                    // Add other columns based on your data structure
                ]
            });
        });
    </script>
@endsection
