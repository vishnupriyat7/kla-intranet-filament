<!-- Features Start -->
<div class="container-fluid features">
    <div class="container py-5">
        <div class="row g-4">
            {{-- @foreach ($periodicals as $periodical)
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            {{-- <a href="{{ asset('storage/' . $periodical->path) }}" class="h5" data-bs-toggle="modal"
                                data-bs-target="#pdfModal" data-pdf="{{ asset('storage/' . $periodical->path) }}"
                                data-title="{{ $periodical->periodicalMaster->name }}">
                                <i class="bi bi-eye-fill" style="font-size:18px;"></i>
                                {{ $periodical->periodicalMaster->name ?? 'N/A' }}
                            </a>
                            <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                {{ $periodical->date }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach --}}
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/arivoram.htm" target="_blank"
                                class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>Arivoram</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/documentation%20kerala.htm"
                                target="_blank" class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>Documentation Kerala</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/kllb.htm" target="_blank"
                                class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>KLLB</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/samajikan.htm" target="_blank"
                                class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>Samajikan</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/samnwayam.htm" target="_blank"
                                class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>Samnwayam</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/focus.htm" target="_blank"
                                class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>Focus</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/newsdigest.htm" target="_blank"
                                class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>News Digest</b>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="row g-4 align-items-center features-item">
                    <div class="col-8">
                        <div class="features-content d-flex flex-column">
                            <a href="http://www.niyamasabha.org/codes/publications/Mozhi/mozhi%20may%202025.pdf"
                                target="_blank" class="periodical-text">
                                <i class="fas fa-book"></i>
                                <b>Mozhi</b>
                            </a>
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

<!-- Features End -->
