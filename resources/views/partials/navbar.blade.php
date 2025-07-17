<!-- Spinner Start -->
<div id="spinner"
    class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->


<!-- Navbar start -->
<div class="container-fluid sticky-top px-0">
    {{-- <div class="nav-bg"> --}}
    <div class="container-fluid topbar bg-dark d-none d-lg-block">
        <div class="container px-0">
            <div class="topbar-top d-flex justify-content-between flex-lg-wrap">
                <div class="top-info flex-grow-0">
                    <span><img src="storage/img/Government_of_Kerala_Logo.png"
                                class="img-fluid me-2"
                                style="width: 30px; height: 30px;" alt="">
                    </span>
                    <div class="pe-2 me-3 border-end border-white d-flex align-items-center">
                        <p class="mb-0 text-white fs-6 fw-normal">KLA</p>
                    </div>
                    <div class="overflow-hidden" style="width: 900px;">
                        <div id="note" class="ps-2">

                            <a href="{{ route('home.index') }}">
                                <p class="mb-0 link-hover">Welcome to INTRANET Service of KERALA LEGISLATURE
                                    SECRETARIAT</p>
                            </a>
                        </div>
                    </div>

                    <div class="top-link flex-lg-wrap">
                        <i class="fas fa-calendar-alt text-white border-end border-secondary pe-2 me-2"> <span
                                class="text-body">{{ date('D') }} {{ date('d') }} {{ date('M') }}
                                {{ date('Y') }}</span></i>
                        {{-- <span class="text-body">Thiruvananthapuram</span> --}}
                        <!-- Replace static location with live time -->
                        <span class="text-body" id="kolkata-time">Loading IST...</span>
                        {{-- <div class="d-flex icon">
                            <p class="mb-0 text-white me-2">Follow Us:</p>
                            <a href="" class="me-2"><i class="fab fa-facebook-f text-body link-hover"></i></a>
                            <a href="" class="me-2"><i class="fab fa-twitter text-body link-hover"></i></a>
                            <a href="" class="me-2"><i class="fab fa-instagram text-body link-hover"></i></a>
                            <a href="" class="me-2"><i class="fab fa-youtube text-body link-hover"></i></a>
                            <a href="" class="me-2"><i class="fab fa-linkedin-in text-body link-hover"></i></a>
                            <a href="" class="me-2"><i class="fab fa-skype text-body link-hover"></i></a>
                            <a href="" class=""><i class="fab fa-pinterest-p text-body link-hover"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-light navbar-expand-xl">
                <a href="{{ route('home.index') }}" class="navbar-brand mt-3">
                    <p class="text-primary display-6 mb-2" style="line-height: 0;">INTRANET</p>
                    <small class="text-body fw-normal" style="letter-spacing: 5px;">Kerala Legislature
                        Secretariat</small>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">
                    <div class="navbar-nav mx-auto border-top">
                        <a href="{{ route('home.index') }}"
                            class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                        {{-- <a href="{{ route('home.index-other') }}"
                            class="nav-item nav-link {{ request()->routeIs('home.index-other') ? 'active' : '' }}">Home
                            I</a> --}}


                        <div class="nav-item dropdown">
                            <a href="{{ route('home.index') }}"
                                class="nav-link dropdown-toggle {{ request()->routeIs('home.order-circular') || request()->routeIs('home.order-circular.*') ? 'active' : '' }}"
                                data-bs-toggle="dropdown"> Orders/Circulars
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a class="dropdown-item" href="{{ route('home.order-circular', 'go') }}">
                                    Government
                                    Order </a>
                                <a class="dropdown-item" href="{{ route('home.order-circular', 'oo') }}">Office
                                    Order</a>
                                <a class="dropdown-item" href="{{ route('home.order-circular', 'cr') }}">Circular
                                </a>
                            </div>
                        </div>

                        {{-- <div class="nav-item dropdown">
                            <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                Tools/Applications
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a class="dropdown-item" href="http://172.24.18.28/attendance-app/"
                                    target="_blank">Attendance</a>
                                <a class="dropdown-item" href="https://email.gov.in/" target="_blank">Official
                                    eMail</a>
                                <a class="dropdown-item" href="#"> Mail ID &raquo; </a>
                                <div class="dropdown-submenu">
                                    <a class="dropdown-item" href="">Employees</a>
                                    <a class="dropdown-item" href="">Section</a>
                                </div>
                                <a class="dropdown-item" href="https://eniyamasabha.in/auth/login"
                                    target="_blank">e-Niyamasabha</a>
                                <li>
                                    <a class="dropdown-item" href="" target="_blank">ERP Module</a>
                                </li>
                                <a class="dropdown-item" href="http://192.168.11.12/idcard/index.php" target="_blank">ID
                                    Card Proforma</a>
                                <a class="dropdown-item" href="http://192.168.11.12/hallbooking/index.php"
                                    target="_blank">Conference Hall Booking</a>
                                <a class="dropdown-item" href="http://172.24.18.21:8080/share/page"
                                    target="_blank">Centralised Storage</a>
                                <a class="dropdown-item" href="http://172.24.18.18/" target="_blank">LIS</a>
                                <a class="dropdown-item" href="http://klaproceedings.niyamasabha.org/"
                                    target="_blank">Digital Archives of Assembly Documents</a>
                                <a class="dropdown-item" href="http://172.24.18.16/login" target="_blank">Overtime
                                    Allowance Portal</a>
                                <a class="dropdown-item"
                                    href="https://www.spark.gov.in/webspark/(S(n425hz24mxho4mv4ojp4yzk0))/sparklogin.aspx"
                                    target="_blank">Spark</a>
                                <a class="dropdown-item" href="https://prism.kerala.gov.in/" target="_blank">Prism</a>
                                <a class="dropdown-item" href="https://score.kerala.gov.in/" target="_blank">Score</a>



                            </div>
                        </div> --}}
                        {{-- <div class="nav-item dropdown">
                            <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                User Manuals
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a class="dropdown-item" href="http://192.168.11.12/data/Resetting 20of 20NIC 20eMail 20Password_KLS.pdf/"
                                    target="_blank">Guidelines For Official Mail Management</a>
                                <a class="dropdown-item"
                                    href="{{ asset('storage/uploads/guidelines/ResettingPassword_KLS.pdf') }}"
                                    target="_blank">Guidelines For Official Mail Management</a>

                                <a class="d-flex flex-column align-items-center text-decoration-none text-dark"
                                    href="https://email.gov.in/" target="_blank">


                            </div>
                        </div> --}}

                        {{-- <div class="nav-item dropdown">
                            <a href="{{ route('home.index') }}" class="nav-link dropdown-toggle"
                                data-bs-toggle="dropdown"> Periodicals
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                @foreach ($periodicals as $periodical)
                                <a href="{{ asset('storage/' . $periodical->path) }}" class="dropdown-item"
                                    data-bs-toggle="modal" data-bs-target="#pdfModal"
                                    data-pdf="{{ asset('storage/' . $periodical->path) }}"
                                    data-title="{{ $periodical->periodicalMaster->name }}">
                                    {{ $periodical->periodicalMaster->name ?? 'N/A' }}
                                </a>
                                @endforeach


                            </div>
                        </div> --}}
                        <a href="{{ route('home.employees') }}"
                            class="nav-item nav-link {{ request()->routeIs('home.employees') ? 'active' : '' }}">Employee
                            Corner</a>
                        <a href="{{ route('home.upload-request') }}"
                            class="nav-item nav-link {{ request()->routeIs('home.upload-request') ? 'active' : '' }}">Upload
                            Request</a>
                        {{-- <a href="contact.html" class="nav-item nav-link">Search</a> --}}
                        <button
                            class="btn-search btn border border-primary btn-md-square rounded-circle bg-white my-auto">
                            <a href="{{ route('home.advanced-search') }}"><i
                                    class="fas fa-search text-primary"></i></a>
                        </button>

                    </div>
                    {{-- <div class="d-flex flex-nowrap border-top pt-3 pt-xl-0">
                        <div class="d-flex">
                            <img src="img/weather-icon.png" class="img-fluid w-100 me-2" alt="">
                            <div class="d-flex align-items-center">
                                <strong class="fs-4 text-secondary">31°C</strong>
                                <div class="d-flex flex-column ms-2" style="width: 150px;">
                                    <span class="text-body">NEW YORK,</span>
                                    <small>Mon. 10 jun 2024</small>
                                </div>
                            </div>
                        </div>
                        <button
                            class="btn-search btn border border-primary btn-md-square rounded-circle bg-white my-auto"
                            data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                class="fas fa-search text-primary"></i></button>
                    </div> --}}
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->


<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords"
                        aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->
<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                {{-- <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords"
                        aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div> --}}
                <div class="w-75 mx-auto">
                    <form method="GET" action="{{ route('home.search') }}" class="d-flex">
                        <input type="search" name="anysearch" class="form-control p-3 me-2" placeholder="keywords"
                            aria-describedby="search-icon-1" value="{{ request('any-search') }}">
                        <button type="submit" class="btn btn-primary p-3"><i
                                class="fa fa-search text-white"></i></button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->

<script>
    function updateKolkataTime() {
        // Create a new Date object in UTC
        const now = new Date();

        // Convert to IST by adding 5.5 hours
        const istOffsetMs = 5.5 * 60 * 60 * 1000;
        const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
        const istTime = new Date(utcTime + istOffsetMs);

        let hours = istTime.getHours();
        const minutes = istTime.getMinutes().toString().padStart(2, '0');
        const seconds = istTime.getSeconds().toString().padStart(2, '0');

        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12; // Convert 0 -> 12

        const formattedTime = `${hours}:${minutes}:${seconds} ${ampm}`;
        document.getElementById('kolkata-time').innerText = `Time: ${formattedTime}`;
    }

    // Initial call
    updateKolkataTime();

    // Update every second
    setInterval(updateKolkataTime, 1000);
</script>
