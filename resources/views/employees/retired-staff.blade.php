@extends('layouts.default')

@section('title', 'Retired Employees List')

@section('content')
    <div class="container-fluid populer-news py-3">
        <div class="container">
            <h1>Retired Employees</h1>
        </div>
        <div class="container d-flex justify-content-center">
            <div class="card w-100">
                <div class="card-body">
                    <div class="col-12">
                        @if (isset($error))
                            <div class="alert alert-danger">{{ $error }}</div>
                        @else
                            <table id="retiredEmployeeTable" class="table table-bordered display">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>District</th>
                                        <th>Address</th>
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

    <div class="modal fade" id="retiredEmployeeModal" tabindex="-1" aria-labelledby="retiredEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="retiredEmployeeModalLabel">Retired Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="retiredEmployeeModalBody">
                    Loading...
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#retiredEmployeeTable').DataTable({
                processing: true,
                serverSide: false, // Adjusted since we're using Eloquent directly
                ajax: '{{ route('retired-staff.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name_eng', name: 'name_eng' },
                    { data: 'retired_as', name: 'retired_as' },
                    { data: 'retired_on', name: 'retired_on' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ],
                order: [0, 'asc'],
                pageLength: 25,
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                language: {
                    emptyTable: "No retired employees found",
                    processing: "Loading retired employees..."
                }
            });

            $('#retiredEmployeeTable').on('click', '.view-retired-employee', function () {
                let employeeId = $(this).data('id');
                $('#retiredEmployeeModalBody').html('Loading...');
                $('#retiredEmployeeModal').modal('show');

                $.ajax({
                    url: '{{ route('retired-staff.show', ['id' => ':id']) }}'.replace(':id',
                        employeeId),
                    type: 'GET',
                    success: function (response) {
                        $('#retiredEmployeeModalBody').html(response);
                    },
                    error: function () {
                        $('#retiredEmployeeModalBody').html(
                            '<div class="alert alert-danger">Failed to load retired employee details.</div>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
