@extends('layouts.default')

@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-3" id="order-circular">
        <div class="container">
            <!-- Title -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">{{ $orderType }}</h1>
                <button class="btn-search btn bg-prev-btn my-auto">
                    <a href="{{ route('home.advanced-search') }}"
                        style="color: #000000; font-weight: 400; text-decoration: none;">
                        Previous Orders
                        {{-- <i class="fas fa-search text-primary fs-4"></i> --}}
                    </a>
                </button>
            </div>
            </br>
            @if ($orderTypeKey == 'go')
                <!-- Tabs for Manuscript, Routine, Print -->
                <div class="border mb-4 rounded mb-4">
                    <ul class="nav nav-pills d-flex text-center">
                        <li class="nav-item flex-fill">
                            <a class="nav-link active py-3 border-end" data-bs-toggle="tab" href="#manuscript">
                                <span class="text-dark">Manuscript</span>
                            </a>
                        </li>
                        <li class="nav-item flex-fill">
                            <a class="nav-link py-3 border-end" data-bs-toggle="tab" href="#routine">
                                <span class="text-dark">Routine</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item flex-fill">
                            <a class="nav-link py-3" data-bs-toggle="pill" href="#print">
                                <span class="text-dark">Print</span>
                            </a>
                        </li> --}}
                        @if ($hasPrintOrders)
                            <li class="nav-item flex-fill">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#print">
                                    <span class="text-dark">Print</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Content for each order type (Manuscript, Routine, Print) -->
                <div class="tab-content p-3">
                    <!-- Manuscript Tab -->
                    <div id="manuscript" class="tab-pane fade show active">
                        @include('orders-circular.monthly_orders', [
                            'orders' => $orders,
                            'months' => $months,
                            'type' => 'M',
                        ])
                    </div>

                    <!-- Routine Tab -->
                    <div id="routine" class="tab-pane fade">
                        @include('orders-circular.monthly_orders', [
                            'orders' => $orders,
                            'months' => $months,
                            'type' => 'R',
                        ])
                    </div>

                    <!-- Print Tab -->
                    {{-- <div id="print" class="tab-pane fade">
                        @include('orders-circular.monthly_orders', [
                            'orders' => $orders,
                            'months' => $months,
                            'type' => 'P',
                        ])
                    </div> --}}

                    @if ($hasPrintOrders)
                        <!-- Print Tab -->
                        <div id="print" class="tab-pane fade">
                            @include('orders-circular.monthly_orders', [
                                'orders' => $orders,
                                'months' => $months,
                                'type' => 'P',
                            ])
                        </div>
                    @endif
                </div>
            @endif
            @if ($orderTypeKey == 'oo' || $orderTypeKey == 'cr')
                <!-- Month Tabs for Office Order & Circular -->
                <div class="tab-class">
                    <div class="d-flex justify-content-between border-bottom mb-1">
                        <ul class="nav nav-pills d-inline-flex text-center">
                            @foreach ($months as $month)
                                <li class="nav-item mb-3">
                                    <a class="nav-link d-flex py-2 bg-light rounded-pill me-2 {{ $month['no'] == date('m') ? 'active' : '' }}"
                                        data-bs-toggle="pill" href="#tab-{{ $month['no'] }}">
                                        <span class="text-dark" style="width: 175px;">{{ $month['name'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Month-wise Order Listings -->
                    <div class="tab-content p-3">
                        @foreach ($months as $month)
                            <div id="tab-{{ $month['no'] }}"
                                class="tab-pane fade show {{ $month['no'] == date('m') ? 'active' : '' }}">
                                <div class="row g-4">
                                    <div class="col-12 p-4">
                                        @php
                                            $filteredOrders = $orders->filter(function ($order) use ($month) {
                                                return \Carbon\Carbon::parse($order->date)->format('m') ==
                                                    str_pad($month['no'], 2, '0', STR_PAD_LEFT);
                                            });
                                            $hasOrders = $filteredOrders->isNotEmpty();
                                        @endphp

                                        @if (!$hasOrders)
                                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                <span>No {{ $orderTypeKey == 'oo' ? 'Office Order' : 'Circular' }} uploaded
                                                    for this month.</span>
                                            </div>
                                        @else
                                            <div class="table-responsive">
                                                <table id="orderTable-{{ $month['no'] }}"
                                                    class="table table-bordered table-striped table-hover yajra-table">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th class="text-center fw-bold fs-6 text-white">#</th>
                                                            <th class="text-center fw-bold fs-6 text-white">Number</th>
                                                            <th class="text-center fw-bold fs-6 text-white">Date</th>
                                                            <th class="text-center fw-bold fs-6 text-white">Title</th>
                                                            <th class="text-center fw-bold fs-6 text-white">View</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Single Product End -->
@endsection

<!-- 🔹 Single PDF Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfViewer" src="" width="100%" height="700px" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        var pdfModal = document.getElementById("pdfModal");

        pdfModal.addEventListener("show.bs.modal", function(event) {
            var link = event.relatedTarget; // Link that triggered the modal
            var pdfUrl = link.getAttribute("data-pdf");
            var pdfTitle = link.getAttribute("data-title");

            // Set modal title and PDF source
            document.getElementById("pdfModalLabel").textContent = pdfTitle;
            document.getElementById("pdfViewer").src = pdfUrl;
        });

        pdfModal.addEventListener("hidden.bs.modal", function() {
            document.getElementById("pdfViewer").src = ""; // Reset iframe when modal is closed
        });


        // Initialize DataTables when a tab is shown
        let initializedTables = {};
        // Handle both tab (Manuscript, Routine, Print) and pill (month tabs) toggles
        $('a[data-bs-toggle="tab"], a[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
            var targetId = $(e.target).attr("href");
            var monthNo = targetId.replace('#tab-', '') || null; // Extract month number from tab ID
            // var tableId = `#orderTable-${monthNo}`;
            // Determine go_type for Government Order tabs
            if (targetId === '#manuscript') {
                goType = 'M';
            } else if (targetId === '#routine') {
                goType = 'R';
            } else if (targetId === '#print') {
                goType = 'P';
            }
            else {
                goType = null; // Default for Office Order or Circular
            }

            // Use a unique table ID based on month and go_type
            var tableId = monthNo ? `#orderTable-${monthNo}` : `#orderTable-${goType || 'default'}`;

            if (!initializedTables[tableId]) {
                $(tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('home.order-circular', ['type' => $orderTypeKey]) }}',
                        data: function(d) {
                            if (monthNo) {
                                d.month = monthNo;
                            }
                            if (goType) {
                                d.go_type = goType;
                            }
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-center fs-6'
                        },
                        {
                            data: 'number',
                            name: 'number',
                            className: 'text-nowrap fs-10 text-dark', // No wrap, medium font, dark text
                            // render: function(data, type, row) {
                            //     // Parse DD-MM-YYYY date format
                            //     let year = 'Unknown';
                            //     if (row.date) {
                            //         const [day, month, yearStr] = row.date.split('-');
                            //         const parsedDate = new Date(
                            //             `${yearStr}-${month}-${day}`);
                            //         if (!isNaN(parsedDate)) {
                            //             year = parsedDate.getFullYear();
                            //         }
                            //     }
                            //     return `${data}/${year}/KLA`;
                            // }

                        },
                        {
                            data: 'date',
                            name: 'date',
                            className: 'text-nowrap fs-10 text-dark' // No wrap, medium font, dark text
                        },
                        {
                            data: 'title',
                            name: 'title',
                            className: 'fw-normal fs-10 text-dark' // Italic, normal weight, medium font, dark text
                        },
                        {
                            data: 'view',
                            name: 'view',
                            orderable: false,
                            searchable: false,
                            className: 'text-nowrap text-center fs-5' // Center-align, medium font
                        }
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(1)', row).css('white-space',
                            'nowrap'); // Prevent wrap on index column
                        $('td:eq(2)', row).css('white-space',
                            'nowrap'); // Prevent wrap on index column


                    }

                });

                initializedTables[tableId] = true;
            }
        });

        // Initialize current tab table
        $('a.nav-link.active').trigger('shown.bs.tab');
    });
</script>
