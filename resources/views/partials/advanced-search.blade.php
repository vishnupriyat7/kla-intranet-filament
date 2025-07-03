@extends('layouts.default')
@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-4" id="search">
        <div class="container py-2">
            <h1>Advanced Search</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card mt-4">
                <div class="card-body">
                    <form id="advancedSearchForm" action="{{ route('home.advanced-search') }}" method="GET">
                        <div class="row g-4">
                            <!-- Order Type Selection -->
                            <div class="col-md-4">
                                <label for="orderType" class="form-label">Select Order Type *</label>
                                <select class="form-select" id="orderType" name="order_type" required>
                                    <option value="">Choose...</option>
                                    <option value="G" {{ request('order_type') == 'G' ? 'selected' : '' }}>Govt. Order
                                    </option>
                                    <option value="C" {{ request('order_type') == 'C' ? 'selected' : '' }}>Circular
                                    </option>
                                    <option value="O" {{ request('order_type') == 'O' ? 'selected' : '' }}>Office Order
                                    </option>
                                    {{-- <option value="news">News</option> --}}
                                </select>
                            </div>
                            <!-- Year Selection -->
                            <div class="col-md-4">
                                <label for="year" class="form-label">Select Year</label>
                                <select class="form-select" id="year" name="year">
                                    <option value="">Choose...</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                             {{-- Month Selection --}}
                            <div class="col-md-4">
                                <label for="month" class="form-label">Select Month</label>
                                <select class="form-select" id="month" name="month">
                                    <option value="">Choose...</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ request('month') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            {{-- <!-- Date Selection -->
                            <div class="col-md-4">
                                <label for="date" class="form-label">Select Date</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ request('date') }}">
                            </div> --}}
                            <!-- From Date Selection -->
                            <div class="col-md-4">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date"
                                    value="{{ request('from_date') }}">
                            </div>
                            <!-- To Date Selection -->
                            <div class="col-md-4">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date"
                                    value="{{ request('to_date') }}">
                            </div>

                            {{-- Input field to Serch Based on Keyword --}}
                            <div class="col-md-4">
                                <label for="keyword" class="form-label">
                                    Search By Keyword</label>
                                <input type="text" class="form-control" id="keyword" name="keyword"
                                    value="{{ request('keyword') }}">
                            </div>
                            <!-- Search Button -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary text-white">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div><br>
            <div class="card">
                <div class="card-header">
                    <h4>Search Results</h4>
                </div>
                <div class="card-body">
                    <div class="card-body" id="search-results">
                        @if (isset($results) && count($results) > 0)
                            @include('partials.advanced-search-results', [
                                'results' => $results,
                                'orderType' => $orderType,
                            ])
                        @else
                            <div class="alert alert-warning mt-4">Please select an Order Type to proceed with the search.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    });

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("advancedSearchForm");
        const fromDateInput = document.getElementById("from_date");
        const toDateInput = document.getElementById("to_date");
        const resultsContainer = document.getElementById("search-results");

        form.addEventListener("submit", function(e) {
            e.preventDefault();

            // Client-side validation for date range
            if (toDateInput.value && !fromDateInput.value) {
                alert("Please select a From Date when choosing a To Date.");
                return;
            }
            if (fromDateInput.value && toDateInput.value && fromDateInput.value > toDateInput.value) {
                alert("To Date cannot be earlier than From Date.");
                return;
            }

            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            fetch(form.action + "?" + params, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (resultsContainer) {
                        resultsContainer.innerHTML = html;
                    } else {
                        console.error("search-results element not found!");
                    }
                })
                .catch(error => {
                    console.error("AJAX Search Error:", error);
                });
        });
    });
</script>
