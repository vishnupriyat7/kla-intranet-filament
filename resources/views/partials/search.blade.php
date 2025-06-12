@extends('layouts.default')
@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-5" id="search">
        <div class="container py-5">
            <h1>Search</h1>
            <div class="row g-4">
                <div class="col-12">
                    @foreach ($results as $result)
                        <div class="features-content d-flex flex-column mt-3">
                            {{-- <a href="{{ asset('storage/' . $result->path)}}" class="h6" target="_blank"><i
                                    class="fas fa-solid fa-paperclip me-1"></i>
                                {{ $result->title }}
                            </a> --}}
                            <a href="{{ asset('storage/' . $result->path) }}" class="h6"
                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                data-pdf="{{ asset('storage/' . $result->path) }}"
                                data-title="{{ $result->title }}">

                                <i class="fas fa-solid fa-paperclip me-1" style="color:rgb(60, 93, 240)"></i> {{ $result->title }}
                                {{ $result->title }}
                            </a>
                            <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($result->date)->format('M d Y') }}</small>
                            </br>
                        </div>
                    @endforeach
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
</script>
