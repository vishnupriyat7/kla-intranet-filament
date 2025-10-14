@extends('layouts.default')

@section('content')
    <!-- Single Product Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            {{-- <ol class="breadcrumb justify-content-start mb-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-dark">Single Page</li>
        </ol> --}}
            <div class="row g-4">
                <div class="row g-4">
                    @foreach ($newsupdates as $news)
                        <div class="features-content d-flex flex-column">
                            {{-- <a href="{{ asset('storage/' . $news->path) }}" class="h6" target="_blank"><i
                                    class="fas fa-comment-dots me-1"></i>
                                {{ $news->title }}
                            </a> --}}
                            <a href="#" class="h6 open-pdf-modal" data-pdf-url="{{ asset('storage/' . $news->path) }}"
                                data-title="{{ $news->title }}">
                                <i class="fas fa-comment-dots me-1"></i>
                                {{ $news->title }}
                            </a>
                            <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($news->date)->format('M d Y') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->

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
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdfLinks = document.querySelectorAll('.open-pdf-modal');
        const pdfModal = document.getElementById('pdfModal');
        const pdfViewer = document.getElementById('pdfViewer');
        const modalTitle = document.getElementById('pdfModalLabel');

        pdfLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const pdfUrl = this.getAttribute('data-pdf-url');
                const title = this.getAttribute('data-title');

                // Set the iframe source and modal title
                pdfViewer.src = pdfUrl;
                modalTitle.textContent = title || 'PDF Viewer';

                // Show the modal
                const bootstrapModal = new bootstrap.Modal(pdfModal);
                bootstrapModal.show();
            });
        });

        // Reset iframe src when modal is closed to prevent loading old PDFs
        pdfModal.addEventListener('hidden.bs.modal', function() {
            pdfViewer.src = '';
        });
    });
</script>
