<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container-fluid py-10 ">

        {{-- use card here --}}
        <div class = "card">
            <div class="card-header p-3">
                <h4 class="fw-bold">Orders / Circulars</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('orders-circular.create') }}" class="btn btn-primary">Add New</a>

                </div>
                <div class="table-responsive" style="overflow-x: auto;">
                    <table id="ordersCircularsTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>GO Type</th>
                                <th>Sub Type</th>
                                <th>Category</th>
                                <th>No</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Keyword</th>
                                {{-- <th>Path</th> --}}
                                <th>Requested Date</th>
                                <th>File</th>
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

        $('#ordersCircularsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders-circular.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'go_type',
                    name: 'go_type'
                },
                {
                    data: 'sub_type',
                    name: 'sub_type'
                },
                {
                    data: 'sub_sub_type',
                    name: 'sub_sub_type'
                },
                {
                    data: 'number',
                    name: 'number'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'keywords',
                    name: 'keywords'
                },
                // {
                //     data: 'path',
                //     name: 'path'
                // },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                    searchable: false
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
                $('td:eq(6)', row).css('white-space', 'nowrap'); // Prevent wrap on index column
                $('td:eq(9)', row).css('white-space', 'nowrap'); // Prevent wrap on index column
                $('td:eq(10)', row).css('white-space', 'nowrap'); // Prevent wrap on action column
                $('td:eq(12)', row).css('white-space', 'nowrap'); // Prevent wrap on action column
            }
        });
    });
</script>
