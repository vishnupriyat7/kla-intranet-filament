<!-- Hero Section Start -->
<div class="container-fluid hero py-5 position-relative">
    <div id="particles-js" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></div>
    <div class="container py-5" style="position: relative; z-index: 1;">
        <div class="tab-class mb-1">
            <div class="row g-4">
                <div class="col-lg-12 col-xl-12">

                    <div class="row g-4">
                        <!-- Government Order Column -->
                        <div class="col-lg-4 col-md-6">
                            <div class="features-content d-flex flex-column mt-3">
                                <h3 class="mb-4">Government Order</h3>
                                @foreach ($gos as $go)
                                                            <div class="mb-4">
                                                                <i class="bi bi-eye-fill" style="font-size:20px;color:rgb(60, 93, 240)"></i>
                                                                <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                    data-pdf="{{ asset('storage/' . $go->path) }}" data-title="{{ $go->title }}">
                                                                    G.O.({{ $go->go_type == 'M' ? 'Ms' :
                                    ($go->go_type == 'R' ? 'Rt' :
                                        ($go->go_type == 'P' ? 'P' : '')) }}).No.{{ $go->number }}-{{ substr($go->title, 0, 30) }}...
                                                                </a>
                                                                <small class="text-body d-block">
                                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($go->date)->format('M d Y') }}
                                                                </small>
                                                            </div>
                                @endforeach
                                <div class="mt-2 d-flex justify-content-center">
                                    <div class="col-12">
                                        <a href="{{ route('home.order-circular', 'go') }}"
                                            class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark hover-bg-primary text-hover-white border-primary">View
                                            All >></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Office Order Column -->
                        <div class="col-lg-4 col-md-6">
                            <div class="features-content d-flex flex-column mt-3">
                                <h3 class="mb-4">Office Order</h3>
                                @foreach ($oos as $oo)
                                    <div class="mb-4">
                                        <i class="bi bi-eye-fill" style="font-size:20px;color:rgb(60, 93, 240)"></i>
                                        <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                            data-pdf="{{ asset('storage/' . $oo->path) }}" data-title="{{ $oo->title }}">
                                            O.O.No.{{ $oo->number }}-{{ substr($oo->title, 0, 30) }}...
                                        </a>
                                        <small class="text-body d-block">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($oo->date)->format('M d Y') }}
                                        </small>
                                    </div>
                                @endforeach
                                <div class="mt-2 d-flex justify-content-center">
                                    <div class="col-12">
                                        <a href="{{ route('home.order-circular', 'oo') }}"
                                            class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark hover-bg-primary text-hover-white border-primary">View
                                            All >></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Circular Column -->
                        <div class="col-lg-4 col-md-6">
                            <div class="features-content d-flex flex-column mt-3">
                                <h3 class="mb-4">Circular</h3>
                                @foreach ($crcls as $crcl)
                                    <div class="mb-4">
                                        <i class="bi bi-eye-fill" style="font-size:20px;color:rgb(60, 93, 240)"></i>
                                        <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                            data-pdf="{{ asset('storage/' . $crcl->path) }}"
                                            data-title="{{ $crcl->title }}">
                                            No.{{ $crcl->number }}-{{ substr($crcl->title, 0, 30) }}...
                                        </a>
                                        <small class="text-body d-block">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($crcl->date)->format('M d Y') }}
                                        </small>
                                    </div>
                                @endforeach
                                <div class="mt-2 d-flex justify-content-center">
                                    <div class="col-12">
                                        <a href="{{ route('home.order-circular', 'cr') }}"
                                            class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark hover-bg-primary text-hover-white border-primary">View
                                            All >></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- News Column -->
                <div class="col-lg-12 col-md-12">
                    <div class="features-content d-flex flex-column mt-3">
                        {{-- <h3 class="mb-4">Circular</h3> --}}
                        <h1 class="mb-4">What’s New</h1>
                        @foreach ($newsupdates as $news)
                            <div class="mb-4">
                                <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60, 93, 240)"></i>
                                <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                    data-pdf="{{ asset('storage/' . $news->path) }}" data-title="{{ $news->title }}">
                                    {{ $news->title }}
                                </a>
                                <small class="text-body d-block">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($news->date)->format('M d Y') }}
                                </small>
                            </div>
                        @endforeach
                        <div class="mt-2 d-flex justify-content-center">
                            <div class="col-12">
                                <a href="{{ route('updatesmore') }}"
                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark hover-bg-primary text-hover-white border-primary">View
                                    All >></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

{{-- Hero Section End --}}
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 50, // Reduced for lightweight performance
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#3c5df0" // Matches your theme (blue color)
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                }
            },
            "opacity": {
                "value": 0.5,
                "random": true,
                "anim": {
                    "enable": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#3c5df0",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 2, // Slow movement for subtle effect
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "repulse" // Particles move away from cursor
                },
                "onclick": {
                    "enable": true,
                    "mode": "push" // Add particles on click
                },
                "resize": true
            }
        },
        "retina_detect": true
    });

    document.addEventListener("DOMContentLoaded", function () {
        var pdfModal = document.getElementById("pdfModal");

        pdfModal.addEventListener("show.bs.modal", function (event) {
            var link = event.relatedTarget; // Link that triggered the modal
            var pdfUrl = link.getAttribute("data-pdf");
            var pdfTitle = link.getAttribute("data-title");

            // Set modal title and PDF source
            document.getElementById("pdfModalLabel").textContent = pdfTitle;
            document.getElementById("pdfViewer").src = pdfUrl;
        });

        pdfModal.addEventListener("hidden.bs.modal", function () {
            document.getElementById("pdfViewer").src = ""; // Reset iframe when modal is closed
        });
    });
</script>
