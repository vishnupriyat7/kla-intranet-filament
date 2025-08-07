<!-- Hero Section Start -->
<div class="container-fluid hero py-5 position-relative">
    <!-- <div id="particles-js" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></div> -->
    <div class="container py-3" style="position: relative; z-index: 1;">
        <div class="tab-class mb-1">
            <div class="row g-4">
                <div class="col-xl-7 col-xxl-7">
                    <div class="d-flex flex-column flex-md-row justify-content-md-between border-bottom mb-4">
                        <h3 class="mb-4">What’s New</h3>
                        <ul class="nav nav-pills d-inline-flex text-center">
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill active me-2" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 100px;">GO MS</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 100px;">GO RT</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 100px;">Office Order</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-4">
                                    <span class="text-dark" style="width: 100px;">Circular</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2" data-bs-toggle="pill" href="#tab-5">
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
                                        @foreach ($goms as $go)
                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill" style="font-size:20px;color:rgb(60, 93, 240)"></i>
                                                <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/' . $go->path) }}"
                                                    data-title="{{ $go->title }}">
                                                    @if($go->title_lingo == 'E')
                                                        G. O. (Ms.) No.
                                                        {{ $go->number }} dated
                                                        {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                        - Kerala Legislative Assembly - {{ $go->title }}
                                                    @else
                                                        സ. ഉ. (കയ്യെഴുത്ത്) നം.
                                                        {{ $go->number }} തീയതി
                                                        {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                        - കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് - {{ $go->title }}
                                                    @endif
                                                </a>
                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($go->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'go') }}" class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
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
                                        @foreach ($gort as $go)
                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill" style="font-size:20px;color:rgb(60, 93, 240)"></i>
                                                <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/' . $go->path) }}"
                                                    data-title="{{ $go->title }}">
                                                    @if($go->title_lingo == 'E')
                                                        G. O. (Rt.) No.
                                                        {{ $go->number }} dated
                                                        {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                        - Kerala Legislative Assembly - {{ $go->title }}
                                                    @else
                                                        സ. ഉ. (സാധാ) നം.
                                                        {{ $go->number }} തീയതി
                                                        {{ \Carbon\Carbon::parse($go->date)->format('d.m.Y') }}
                                                        - കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് - {{ $go->title }}
                                                    @endif
                                                </a>
                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($go->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'go') }}" class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
                                            hover-bg-primary text-hover-white border-primary">View
                                                    All >></a>
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
                                        @foreach ($oos as $oo)
                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60, 93, 240)"></i>
                                                <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/' . $oo->path) }}"
                                                    data-title="{{ $oo->title }}">
                                                    @if($oo->title_lingo == 'E')
                                                        Office Order No.
                                                        {{ $oo->number }} dated
                                                        {{ \Carbon\Carbon::parse($oo->date)->format('d.m.Y') }}
                                                        - Kerala Legislative Assembly - {{ $oo->title }}
                                                    @else
                                                        ഓഫീസ് ഉത്തരവ് നമ്പർ
                                                        {{ $oo->number }} തീയതി
                                                        {{ \Carbon\Carbon::parse($oo->date)->format('d.m.Y') }}
                                                        - കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് - {{ $oo->title }}
                                                    @endif
                                                </a>
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
                        <div id="tab-4" class="tab-pane fade show p-0">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="features-content d-flex flex-column mt-3">
                                        @foreach ($crcls as $crclr)
                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60, 93, 240)"></i>
                                                <a href="#" class="h6" data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/' . $crclr->path) }}"
                                                    data-title="{{ $crclr->title }}">
                                                    {{-- <i class="fas fa-solid fa-paperclip me-1"></i> --}}
                                                    @if($crclr->title_lingo == 'E')
                                                        Number.
                                                        {{ $crclr->number }} dated
                                                        {{ \Carbon\Carbon::parse($crclr->date)->format('d.m.Y') }}
                                                        - Kerala Legislative Assembly - {{ $crclr->title }}
                                                    @else
                                                        നമ്പര്‍.
                                                        {{ $crclr->number }} തീയതി
                                                        {{ \Carbon\Carbon::parse($crclr->date)->format('d.m.Y') }}
                                                        - കേരള നിയമസഭാ സെക്രട്ടേറിയറ്റ് - {{ $crclr->title }}
                                                    @endif
                                                </a>
                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($crclr->date)->format('M d Y') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('home.order-circular', 'cr') }}" class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
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
                                        @foreach ($newsupdates as $news)
                                            <div class="mb-4">
                                                <i class="bi bi-eye-fill" style="font-size:18px;color:rgb(60, 93, 240)"></i>
                                                <a href="{{ asset('storage/' . $news->path) }}" class="h6"
                                                    data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/' . $news->path) }}"
                                                    data-title="{{ $news->title }}">
                                                    {{-- <i class="fas fa-comment-dots me-1"></i> --}}
                                                    {{ $news->title }}
                                                </a>
                                                <small class="text-body d-block">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($news->date)->format('M d Y') }}</small>
                                            </div>
                                        @endforeach
                                        <div class="mt-2 d-flex justify-content-center">
                                            <div class="col-4">
                                                <a href="{{ route('updatesmore') }}" class="btn btn-outline-primary w-100 py-3 mb-4 rounded-pill text-dark
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
                <div class="col-xxl-5 col-xl-5">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border h-100" style="min-height: 600px;">
                                <h3 class="mb-5">Tools/Application</h3>
                                <div class="row g-4 text-center tools-application">
                                    <!-- E office -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://e-kla.kerala.gov.in/SSOComponent/auth.php" target="_blank">
                                            <i class="fas fa-laptop-code fa-2x mb-2" style="color: #ec4297"></i>
                                            <span>E office</span>
                                        </a>
                                    </div>
                                    <!-- Attendance -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://172.24.18.28/attendance-app/" target="_blank">
                                            <i class="fas fa-user-check fa-2x mb-2" style="color: rgb(60, 93, 240)"></i>
                                            <span>Attendance</span>
                                        </a>
                                    </div>
                                    <!-- e-Niyamasabha -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://eniyamasabha.in/auth/login" target="_blank">
                                            <i class="fas fa-university fa-2x mb-2" style="color:  #6610f2"></i>
                                            <span>e-Niyamasabha</span>
                                        </a>
                                    </div>
                                    <!-- Official eMail -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://email.gov.in/" target="_blank">
                                            <i class="fas fa-envelope fa-2x mb-2" style="color: #28a745"></i>
                                            <span>Official eMail</span>
                                        </a>
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
                                            {{-- <span class="dropdown-item">
                                                <i class="fas fa-angle-right text-white me-2"></i>
                                                <a class="btn-link"
                                                    href="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                    data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                    data-title="Employees"> Employees </a> /
                                                <a class="btn-link"
                                                    href="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                    data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                    data-pdf="{{ asset('storage/uploads/guidelines/OfficeOrder_ guide.pdf') }}"
                                                    data-title="Office Order Guide">Sections </a>
                                                <a class="btn-link" href="http://192.168.11.12/mailid-sect.html"
                                                    target="_blank">Sections</a>
                                            </span> --}}
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/contacts/AllemployeeMail ID.pdf') }}"
                                                data-title="Employees"><i class="fas fa-users me-2"></i>Employees</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/contacts/Sectionsemail -new.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/contacts/Sectionsemail -new.pdf') }}"
                                                data-title="Sections"><i class="fas fa-building me-2"></i>Sections</a>

                                            <a class="dropdown-item" href="http://www.niyamasabha.org/codes/pa_MLAs.htm"
                                                target="_blank"><i class="fas fa-user-tie me-2"></i>PA to MLAs</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/contacts/Telephone Directory - 2024.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/contacts/Telephone Directory - 2024.pdf') }}"
                                                data-title="Telephone Directory"><i
                                                    class="fas fa-address-book me-2"></i>Telephone Directory </a>
                                            <a class="dropdown-item"
                                                href="http://www.niyamasabha.org/codes/tele_legsec_2021.htm"
                                                target="_blank"><i class="fas fa-phone-volume me-2"></i>KLA</a>
                                        </div>
                                    </div>
                                    <!-- User Manual Dropdown -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle"
                                            href="#" role="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-book-open fa-2x mb-2" style="color: #4647bb"></i>
                                            <span>User Manual</span>
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
                                                {{-- <i class="fas fa-angle-right text-white me-2"></i> --}}
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
                                                data-title="e-Office (e-KLA)">e-Office (e-KLA)</a>
                                            <a class="dropdown-item"
                                                href="{{ asset('storage/uploads/guidelines/e-KLA_User Manual 7.0.pdf') }}"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal"
                                                data-pdf="{{ asset('storage/uploads/guidelines/e-KLA_User Manual 7.0.pdf') }}"
                                                data-title="e-KLA">e-KLA</a>
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
                                            <i class="fas fa-database fa-2x mb-2" style="color: #b4d131"></i>
                                            <span>Centralised Storage</span>
                                        </a>
                                    </div>
                                    <!-- LIS -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="http://172.24.18.18/" target="_blank">
                                            <i class="fas fa-book fa-2x mb-2" style="color: #fd7e14"></i>
                                            <span>LIS</span>
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
                                            <i class="fas fa-wallet fa-2x mb-2" style="color: #e6214c"></i>
                                            <span>Spark</span>
                                        </a>
                                    </div>
                                    <!-- Gem Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://gem.gov.in/" target="_blank">
                                            <i class="fas fa-shopping-cart fa-2x mb-2" style="color: #007bff"></i>
                                            <span>Gem</span>
                                        </a>
                                    </div>
                                    <!-- Income Tax e-filing Portal -->
                                    <div class="col-4 mb-4">
                                        <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                            href="https://www.incometax.gov.in/iec/foportal/" target="_blank">
                                            <i class="fas fa-file-invoice-dollar fa-2x mb-2" style="color: #28a745"></i>
                                            <span>Income Tax e-filing</span>
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
                                            <i class="fas fa-clipboard fa-2x mb-2" style="color: #d638bc"></i>
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
                    <iframe id="pdfViewer" src="" width="100%" height="700px" style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hero Section End --}}
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
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
