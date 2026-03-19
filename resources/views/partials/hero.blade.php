<!-- Hero Section Start -->
<div class="container-fluid hero py-5 position-relative">
    <!-- <div id="particles-js" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></div> -->

    @php
        // function files($record)
        // {
        //     return is_array($record->path) ? $record->path : [];
        // }
        function files($record)
        {
            if (is_array($record->path)) {
                return $record->path;
            }

            if (!empty($record->path)) {
                return [$record->path];
            }

            return [];
        }
    @endphp
    <div class="container py-3" style="position: relative; z-index: 1;">
        <div class="tab-class mb-1">
            <div class="row g-4">
                <div class="row">
                    <div class="col d-flex justify-content-end gap-2 flex-wrap">
                        {{-- <a href="{{ route('helpdesk.create') }}" class="btn btn-warning d-flex align-items-center"> --}}
                        <a href="#" class="btn btn-warning d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#helpdeskModal">

                            <i class="bi bi-tools me-1"></i>
                            IT Helpdesk
                            <span class="badge bg-danger ms-2">3</span>
                        </a>
                        </a>
                        <a href="{{ route('home.advanced-search') }}" class="btn btn-info">
                            <i class="bi bi-search me-1"></i><span class="ms-2">Advanced Search</span>
                        </a>
                        <a href="http://172.24.18.10/old/" target="_blank" class="btn btn-outline-success">
                            Intranet (Prev. Version)
                        </a>
                        <a href="http://10.1.14.36/" target="_blank" class="btn btn-danger d-flex align-items-center">
                            <span class="badge bg-warning text-dark me-2">LIVE</span>
                            <i class="bi bi-broadcast me-1"></i>
                            Webcasting
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-xxl-8">
                    <div class="d-flex flex-column flex-md-row justify-content-md-between border-bottom mb-4">
                        <h3 class="mb-4">What’s New</h3>
                        <ul class="nav nav-pills d-inline-flex text-center">

                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill active me-2" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 100px;">Circular</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 100px;">Office Order</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 100px;">GO RT</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-4">
                                    <span class="text-dark" style="width: 100px;">GO MS</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-5">
                                    <span class="text-dark" style="width: 100px;">GO P</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-6">
                                    <span class="text-dark" style="width: 100px;">News</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content mb-4">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($crcls as $crclr)
                                            @php $attachments = files($crclr); @endphp
                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill"
                                                    style="font-size:18px;color:rgb(60,93,240)"></i>

                                                {{-- TITLE --}}
                                                @if (count($attachments) === 1)
                                                    <a href="#" class="h6" data-bs-toggle="modal"
                                                        data-bs-target="#pdfModal"
                                                        data-pdf="{{ asset('storage/' . $attachments[0]) }}"
                                                        data-title="{{ $crclr->title }}">
                                                    @else
                                                        <span class="h6">
                                                @endif

                                                @if ($crclr->title_lingo == 'E')
                                                    Number {{ $crclr->number }} dated
                                                    {{ \Carbon\Carbon::parse($crclr->date)->format('d.m.Y') }}
                                                    – Kerala Legislative Assembly – {!! $crclr->title !!}
                                                @else
                                                    നമ്പര്‍ {{ $crclr->number }} തീയതി
                                                    {{ \Carbon\Carbon::parse($crclr->date)->format('d.m.Y') }}
                                                    – കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് – {!! $crclr->title !!}
                                                @endif

                                                @if (count($attachments) === 1)
                                                    </a>
                                                @else
                                                    </span>
                                                @endif

                                                {{-- ATTACHMENTS --}}
                                                @if (count($attachments) > 1)
                                                    <div class="mt-1">
                                                        @foreach ($attachments as $i => $file)
                                                            <a href="#" class="badge bg-primary me-1"
                                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                data-pdf="{{ asset('storage/' . $file) }}"
                                                                data-title="{{ $crclr->title }} (Attachment {{ $i + 1 }})">
                                                                Attachment {{ $i + 1 }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if ($crclr->link)
                                                    <div>Google form Link: <a href="{{ $crclr->link }}"
                                                            target="_blank">Click
                                                            here</a></div>
                                                @endif

                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($crclr->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'cr') }}"
                                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
                                            hover-bg-primary text-hover-white border-primary">View
                                                    All >></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($oos as $oo)
                                            @php $attachments = files($oo); @endphp

                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill"
                                                    style="font-size:18px;color:rgb(60,93,240)"></i>

                                                @if (count($attachments) === 1)
                                                    <a href="#" class="h6" data-bs-toggle="modal"
                                                        data-bs-target="#pdfModal"
                                                        data-pdf="{{ asset('storage/' . $attachments[0]) }}"
                                                        data-title="{{ $oo->title }}">
                                                    @else
                                                        <span class="h6">
                                                @endif

                                                @if ($oo->title_lingo == 'E')
                                                    Office Order No. {{ $oo->number }} dated
                                                    {{ \Carbon\Carbon::parse($oo->date)->format('d.m.Y') }}
                                                    – Kerala Legislative Assembly – {{ $oo->title }}
                                                @else
                                                    ഓഫീസ് ഉത്തരവ് നമ്പർ {{ $oo->number }} തീയതി
                                                    {{ \Carbon\Carbon::parse($oo->date)->format('d.m.Y') }}
                                                    – കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് – {{ $oo->title }}
                                                @endif

                                                @if (count($attachments) === 1)
                                                    </a>
                                                @else
                                                    </span>
                                                @endif

                                                @if (count($attachments) > 1)
                                                    <div class="mt-1">
                                                        @foreach ($attachments as $i => $file)
                                                            <a href="#" class="badge bg-primary me-1"
                                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                data-pdf="{{ asset('storage/' . $file) }}"
                                                                data-title="{{ $oo->title }} (Attachment {{ $i + 1 }})">
                                                                Attachment {{ $i + 1 }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($oo->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'oo') }}"
                                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark hover-bg-primary text-hover-white border-primary">
                                                    View All >>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($gort as $go)
                                            @php $attachments = files($go); @endphp

                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill"
                                                    style="font-size:20px;color:rgb(60,93,240)"></i>

                                                @if (count($attachments) === 1)
                                                    <a href="#" class="h6" data-bs-toggle="modal"
                                                        data-bs-target="#pdfModal"
                                                        data-pdf="{{ asset('storage/' . $attachments[0]) }}"
                                                        data-title="{{ $go->title }}">
                                                    @else
                                                        <span class="h6">
                                                @endif



                                                {{-- {{ $go->number }} dated
                                                        {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                        – Kerala Legislative Assembly – {{ $go->title }} --}}
                                                @if ($go->title_lingo == 'E')
                                                    G.O.(Rt) No. {{ $go->number }} dated
                                                    {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                    – Kerala Legislative Assembly – {{ $go->title }}
                                                @else
                                                    ജി.ഒ.(ആർ.ടി) നമ്പർ {{ $go->number }} തീയതി
                                                    {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                    – കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് – {{ $go->title }}
                                                @endif

                                                @if (count($attachments) === 1)
                                                    </a>
                                                @else
                                                    </span>
                                                @endif

                                                @if (count($attachments) > 1)
                                                    <div class="mt-1">
                                                        @foreach ($attachments as $i => $file)
                                                            <a href="#" class="badge bg-primary me-1"
                                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                data-pdf="{{ asset('storage/' . $file) }}"
                                                                data-title="{{ $go->title }} (Attachment {{ $i + 1 }})">
                                                                Attachment {{ $i + 1 }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($go->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'go') }}"
                                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
                                            hover-bg-primary text-hover-white border-primary">View
                                                    All >></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($goms as $go)
                                            @php $attachments = files($go); @endphp

                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill"
                                                    style="font-size:20px;color:rgb(60,93,240)"></i>

                                                @if (count($attachments) === 1)
                                                    <a href="#" class="h6" data-bs-toggle="modal"
                                                        data-bs-target="#pdfModal"
                                                        data-pdf="{{ asset('storage/' . $attachments[0]) }}"
                                                        data-title="{{ $go->title }}">
                                                    @else
                                                        <span class="h6">
                                                @endif

                                                {{-- {{ $go->number }} dated
                                                {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                – Kerala Legislative Assembly – {{ $go->title }} --}}


                                                @if ($go->title_lingo == 'E')
                                                    G.O.(Ms) No. {{ $go->number }} dated
                                                    {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                    – Kerala Legislative Assembly – {{ $go->title }}
                                                @else
                                                    ജി.ഒ.(എം.എസ്) നമ്പർ {{ $go->number }} തീയതി
                                                    {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                    – കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് – {{ $go->title }}
                                                @endif

                                                @if (count($attachments) === 1)
                                                    </a>
                                                @else
                                                    </span>
                                                @endif

                                                @if (count($attachments) > 1)
                                                    <div class="mt-1">
                                                        @foreach ($attachments as $i => $file)
                                                            <a href="#" class="badge bg-primary me-1"
                                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                data-pdf="{{ asset('storage/' . $file) }}"
                                                                data-title="{{ $go->title }} (Attachment {{ $i + 1 }})">
                                                                Attachment {{ $i + 1 }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($go->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'go') }}"
                                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
                                            hover-bg-primary text-hover-white border-primary">View
                                                    All >></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div id="tab-5" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($gop as $go)
                                            @php $attachments = files($go); @endphp

                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill"
                                                    style="font-size:20px;color:rgb(60,93,240)"></i>

                                                @if (count($attachments) === 1)
                                                    <a href="#" class="h6" data-bs-toggle="modal"
                                                        data-bs-target="#pdfModal"
                                                        data-pdf="{{ asset('storage/' . $attachments[0]) }}"
                                                        data-title="{{ $go->title }}">
                                                    @else
                                                        <span class="h6">
                                                @endif

                                                {{-- {{ $go->number }} dated
                                                {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                – Kerala Legislative Assembly – {{ $go->title }} --}}

                                                @if ($go->title_lingo == 'E')
                                                    G.O.(P) No. {{ $go->number }} dated
                                                    {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                    – Kerala Legislative Assembly – {{ $go->title }}
                                                @else
                                                    ജി.ഒ.(പി) നമ്പർ {{ $go->number }} തീയതി
                                                    {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                    – കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് – {{ $go->title }}
                                                @endif

                                                @if (count($attachments) === 1)
                                                    </a>
                                                @else
                                                    </span>
                                                @endif

                                                @if (count($attachments) > 1)
                                                    <div class="mt-1">
                                                        @foreach ($attachments as $i => $file)
                                                            <a href="#" class="badge bg-primary me-1"
                                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                data-pdf="{{ asset('storage/' . $file) }}"
                                                                data-title="{{ $go->title }} (Attachment {{ $i + 1 }})">
                                                                Attachment {{ $i + 1 }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($go->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'go') }}"
                                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
                                            hover-bg-primary text-hover-white border-primary">View
                                                    All >></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="tab-6" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($newsupdates as $news)
                                            <div class="mb-4">

                                                <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60,93,240)"></i>

                                                @if ($news->path)
                                                    <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                        data-pdf="{{ asset('storage/' . $news->path) }}"
                                                        data-title="{{ $news->title }}">

                                                        {!! $news->title !!}

                                                    </a>
                                                @else
                                                    <span class="h6">{!! $news->title !!}</span>
                                                @endif

                                                @if (count($attachments) > 1)
                                                    <div class="mt-1">
                                                        @foreach ($attachments as $i => $file)
                                                            <a href="#" class="badge bg-primary me-1"
                                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                                data-pdf="{{ asset('storage/' . $file) }}"
                                                                data-title="{{ $news->title }} (Attachment {{ $i + 1 }})">
                                                                Attachment {{ $i + 1 }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($news->date)->format('M d Y') }}
                                                </small>

                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('updatesmore') }}"
                                                    class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
                                            hover-bg-primary text-hover-white border-primary">View
                                                    All >></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border h-100 features" style="min-height: 600px;">
                                <h3 class="mb-5">Tools/Application</h3>
                                <div class="row g-4 text-center tools-application">
                                    <!-- Niyamasabha org -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://niyamasabha.org/" target="_blank">
                                            <i class="fas fa-university fa-2x mb-2" style="color:  #c53408"></i>
                                            <span style="font-size: .95em;">niyamasabha.org</span>
                                        </a>
                                    </div>
                                    <!-- E office -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark
                                            dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown">
                                            <img src="{{ asset('assets/img/e-office.png') }}" alt="e-Office"
                                                class="img-fluid mb-2" style="height: 40px;">
                                            <span>e-Office</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="https://e-kla.kerala.gov.in/SSOComponent/auth.php"
                                                target="_blank">e-Office</a>
                                            <a class="dropdown-item" href="https://forms.gle/7boYGXdTitmSyPXY7"
                                                target="_blank">EMD Creation</a>
                                            <a class="dropdown-item" href="https://forms.gle/26qZX9rGqsK8i7cd6"
                                                target="_blank">e-Mail ID Creation</a>
                                        </div>
                                    </div>
                                    <!-- Attendance -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://172.24.18.28/attendance-app/" target="_blank">
                                            <i class="fas fa-user-check fa-2x mb-2"
                                                style="color: rgb(60, 93, 240)"></i>
                                            <span>Attendance</span>
                                        </a>
                                    </div>
                                    <!-- e-Niyamasabha -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://eniyamasabha.in/auth/login" target="_blank">
                                            <img src="{{ asset('assets/img/e-niyamasabha.png') }}" alt="e-niyamsabha"
                                                class="img-fluid mb-2" style="height: 40px;">
                                            <!-- <i class="fas fa-landmark fa-2x mb-2" style="color:  #28a745"></i> -->
                                            <span style="font-size: .95em;">e-Niyamasabha</span>
                                        </a>
                                    </div>
                                    <!-- Official eMail -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://mail.gov.in/" target="_blank" role="button">
                                            <i class="fas fa-envelope fa-2x mb-2" style="color:  #6610f2"></i>
                                            <span>Official eMail</span>
                                        </a>

                                        <!-- <div class="dropdown-menu">
                                            <a class="dropdown-item" href="https://mail.gov.in/" target="_blank">
                                                <i class="fas fa-envelope me-2" style="color: #28a745"></i>
                                                New
                                            </a>
                                            <a class="dropdown-item" href="https://email.gov.in/" target="_blank">
                                                <i class="fas fa-envelope-open me-2" style="color: #6c757d"></i>
                                                Old
                                            </a>
                                        </div> -->
                                    </div>

                                    <!-- Overtime Allowance Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://172.24.18.16/login" target="_blank">
                                            <i class="fas fa-money-check-alt fa-2x mb-2" style="color:  #17a2b8"></i>
                                            <span>Overtime Allowance</span>
                                        </a>
                                    </div>
                                    <!-- Mail ID Dropdown -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-user-circle fa-2x mb-2" style="color: #dc3545"></i>
                                            <span>Contacts</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="https://speakerkerala.niyamasabha.nic.in/speakers-office"
                                                target="_blank"><i class="fas fa-user-tie me-2"></i>
                                                Speaker Office
                                            </a>
                                            <a class="dropdown-item"
                                                href="http://www.niyamasabha.org/codes/tele_offdyspeaker.htm"
                                                target="_blank"><i class="fas fa-id-badge me-2"></i>
                                                Deputy Speaker Office
                                            </a>
                                            <a class="dropdown-item"
                                                href="http://www.niyamasabha.org/codes/tele_legsec_2021.htm"
                                                target="_blank">
                                                <i class="fas fa-phone-volume me-2"></i>Officers / Sections
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                data-title="Official Mail IDs">
                                                <i class="fas fa-users me-2"></i>Official Mail IDs
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/contacts/Sectionsemail -new.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/contacts/Sectionsemail -new.pdf') }}"
                                                data-title="Section Mail IDs">
                                                <i class="fas fa-building me-2"></i>Section Mail IDs
                                            </a>
                                            <a class="dropdown-item"
                                                href="http://www.niyamasabha.org/codes/pa_MLAs.htm" target="_blank">
                                                <i class="fas fa-phone me-2"></i>PA to MLAs
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/contacts/Telephone Directory - 2024.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/contacts/Telephone Directory - 2024.pdf') }}"
                                                data-title="Telephone Directory">
                                                <i class="fas fa-address-book me-2"></i> Telephone Directory
                                            </a>
                                        </div>
                                    </div>
                                    <!-- User Manual Dropdown -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-book-open fa-2x mb-2" style="color: #187743"></i>
                                            <span>Reference Manuals</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/Hallbooking_Manual.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/Hallbooking_Manual.pdf') }}"
                                                data-title="Hall Booking Reference Manual">Hall Booking Reference
                                                Manual</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/ResettingPassword_KLS.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/ResettingPassword_KLS.pdf') }}"
                                                data-title="Official Mail Management">Official Mail Management</a>
                                            <span class="dropdown-item">
                                                <a class="btn-link"
                                                    href="{{ asset('storage/uploads/guidelines/GOnumber_guide.pdf') }}"
                                                    data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/uploads/guidelines/GOnumber_guide.pdf') }}"
                                                    data-title="GO Guide"> GO </a> /
                                                <a class="btn-link"
                                                    href="{{ asset('storage/uploads/guidelines/OfficeOrder_ guide.pdf') }}"
                                                    data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/uploads/guidelines/OfficeOrder_ guide.pdf') }}"
                                                    data-title="Office Order Guide">Office Order </a>in e-Office
                                            </span>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/e-officeguidelines.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/e-officeguidelines.pdf') }}"
                                                data-title="e-Office Guidelines">e-Office Guidelines</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/e-KLA_User Manual 7.0.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/e-KLA_User Manual 7.0.pdf') }}"
                                                data-title="e-Office User Manual">e-Office User Manual</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/HandbookMA A 23.07.2025-1.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/HandbookMA A 23.07.2025-1.pdf') }}"
                                                data-title="Members' Handbook">Members' Handbook</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/RTI -Quick reference Guide_KLS.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/RTI -Quick reference Guide_KLS.pdf') }}"
                                                data-title="RTI Quick Reference Guide">RTI Quick Reference Guide</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/RTI-portal-user-manual.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/RTI-portal-user-manual.pdf') }}"
                                                data-title="RTI Portal User Manual">RTI Portal User Manual</a>
                                        </div>
                                    </div>
                                    <!-- ID Card Proforma -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://192.168.11.12/idcard/index.php" target="_blank">
                                            <i class="fas fa-id-card fa-2x mb-2" style="color: #ffc107"></i>
                                            <span>ID Card Proforma</span>
                                        </a>
                                    </div>
                                    <!-- Centralised Storage -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://172.24.18.21:8080/share/page" target="_blank">
                                            <img src="{{ asset('assets/img/alfresco.png') }}"
                                                alt="Centralised Storage" class="img-fluid mb-2"
                                                style="height: 40px;">
                                            <span>Centralised Storage</span>
                                        </a>
                                    </div>
                                    <!-- LIS -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://172.24.18.18/" target="_blank">
                                            <i class="fas fa-book fa-2x mb-2" style="color: #fd7e14"></i>
                                            <span>Library & Information Services</span>
                                        </a>
                                    </div>
                                    <!-- Digital Archives -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://klaproceedings.niyamasabha.org/" target="_blank">
                                            <i class="fas fa-archive fa-2x mb-2" style="color: #20c997"></i>
                                            <span>Digital Archives</span>
                                        </a>
                                    </div>
                                    <!-- Spark Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://www.spark.gov.in/webspark/(S(xkipr1xy1kgrtv0xkzt3p12c))/sparklogin.aspx"
                                            target="_blank">
                                            <img src="{{ asset('assets/img/spark.png') }}" alt="Spark"
                                                class="img-fluid mb-2" style="height: 40px;">
                                            <span>Spark</span>
                                        </a>
                                    </div>
                                    <!-- Gem Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://gem.gov.in/" target="_blank">
                                            <img src="{{ asset('assets/img/gem.png') }}" alt="GeM"
                                                class="img-fluid mb-2" style="height: 40px;">
                                            <span>GeM</span>
                                        </a>
                                    </div>
                                    <!-- Income Tax e-filing Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://www.incometax.gov.in/iec/foportal/" target="_blank">
                                            <img src="{{ asset('assets/img/tax.png') }}" alt="Income Tax e-Filing"
                                                class="img-fluid mb-2" style="height: 40px;">
                                            <span>Income Tax</br>e-Filing</span>
                                        </a>
                                    </div>
                                    <!-- BIOMETRIC PUNCHING Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://kllegis.attendance.gov.in/" target="_blank">
                                            <i class="fas fa-fingerprint fa-2x mb-2" style="color: #fd7e14"></i>
                                            <span>AEBAS</span>
                                        </a>
                                    </div>
                                    <!--Annual Index of Records-  -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-book-open fa-2x mb-2" style="color: #d638bc"></i>
                                            <span>AIR</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/records/Annual Index-2014.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/records/Annual Index-2014.pdf') }}"
                                                data-title="Annual Index 2014">Annual Index Report 2014</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/records/Annual Index-2013.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/records/Annual Index-2013.pdf') }}"
                                                data-title="Annual Index 2013">Annual Index Report 2013</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/records/Annual Index-2012.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/records/Annual Index-2012.pdf') }}"
                                                data-title="Annual Index 2012">Annual Index Report 2012</a>
                                        </div>
                                    </div>
                                    <!--Vehicla Pass--->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark
                                            dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-clipboard fa-2x mb-2" style="color: #20579e"></i>
                                            <span>Application Forms</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/application-forms/Vehicle_Pass.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/application-forms/Vehicle_Pass.pdf') }}"
                                                data-title="Vehicle Pass">Vehicle Pass</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/application-forms/Library_Membership_form.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/application-forms/Library_Membership_form.pdf') }}"
                                                data-title="Library Membership">Library Membership</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/application-forms/Nomination_form_GPF.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/application-forms/Nomination_form_GPF.pdf') }}"
                                                data-title="GPF Nomination">GPF Nomination</a>
                                        </div>
                                    </div>
                                </div>
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
            <div class="container-fluid">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" width="100%" height="700px"
                        style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- IT Helpdesk Modal -->
<div class="modal fade" id="helpdeskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-tools"></i> IT Helpdesk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- <form action="{{ route('helpdesk.store') }}" method="POST"> --}}

            <form action="" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Employee</label>
                            <select class="form-select" name="employee_id" id="employeeSelect">
                                <option value="">Select Employee</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Section</label>
                            <input type="text" class="form-control" name="section" id="employeeSection" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Building</label>
                            <input type="text" class="form-control" name="building">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Floor</label>
                            <input type="text" class="form-control" name="floor">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Room No</label>
                            <input type="text" class="form-control" name="room_no">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Complaint Type</label>
                            <select class="form-select" name="complaint_type">
                                <option>Hardware</option>
                                <option>Software</option>
                                <option>Network</option>
                                <option>Printer</option>
                                <option>Email</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Issue Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-success">
                        Submit Ticket
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

{{-- Hero Section End --}}
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
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

        fetch("/employees/list")
            .then(response => response.json())
            .then(data => {

                let select = document.getElementById("employeeSelect");

                select.innerHTML = '<option value="">Select Employee</option>';

                data.forEach(emp => {

                    let option = document.createElement("option");

                    option.value = emp.pen;
                    option.text = emp.name + " - " + emp.pen;

                    option.dataset.section = emp.section;
                    option.dataset.name = emp.name;

                    select.appendChild(option);

                });

            })
            .catch(error => console.error("Employee API error:", error));

    });

    document.getElementById("employeeSelect")
        .addEventListener("change", function() {

            let section =
                this.options[this.selectedIndex].dataset.section;

            document.getElementById("employeeSection").value = section;

        });
</script>
