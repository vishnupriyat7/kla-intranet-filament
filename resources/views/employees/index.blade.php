@extends('layouts.default')

@section('title', 'Employees List')

@section('content')
    <div class="container-fluid populer-news py-3">
        <div class="container">
            <h1>Employees</h1>
        </div>
        <div class="container d-flex justify-content-center">
            <div class="card w-100">
                <div class="card-body">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="employeeModalBody">
                    Loading...
                </div>
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
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [1, 'asc']
            });

            $('#employeeTable').on('click', '.view-employee', function () {
                let employeeId = $(this).data('id');
                $('#employeeModalBody').html('Loading...');
                $('#employeeModal').modal('show');

                $.ajax({
                    url: `/employees/${employeeId}`, // assumes route('employees.show', id)
                    type: 'GET',
                    success: function (response) {
                        $('#employeeModalBody').html(response);
                    },
                    error: function () {
                        $('#employeeModalBody').html('<div class="alert alert-danger">Failed to load employee details.</div>');
                    }
                });
            });
        });
    </script>
@endsection
