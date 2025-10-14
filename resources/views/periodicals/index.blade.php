<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-10">
        {{-- add card here --}}
        <div class="card">
            <div class="card-header p-3">
                <h4 class="fw-bold">Periodicals</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('periodicals.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <table id="periodicalsTable" class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Path</th>
                            <th>Date</th>
                            <th>Keywords</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('#periodicalsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('periodicals.index') }}",
            order: [
                [3, 'desc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'periodical_name',
                    orderable: true,
                },
                {
                    data: 'path',
                    name: 'path'
                },

                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'keywords',
                    name: 'keywords'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $('td:eq(6)', row).css('white-space', 'nowrap'); // Prevent wrap on index column
                $('td:eq(7)', row).css('white-space', 'nowrap'); // Prevent wrap on action column
            }
        });
    });
</script>
