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
                <h4 class="fw-bold">News List</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('news-updates.create') }}" class="btn btn-primary">Add New</a>
                </div>

                {{-- <h2 class="mb-4">Periodicals List</h2> --}}
                <div class="table-responsive" style="overflow-x: auto;">
                    <table id="periodicalsTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('#periodicalsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('news-updates.index') }}",
            order: [
                [2, 'desc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $('td:eq(4)', row).css('white-space', 'nowrap'); // Prevent wrap on action column
            }
        });
    });
</script>
