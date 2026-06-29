<style>
    .glow-datetime {
        font-weight: bold;
        font-size: 1rem;
        /* Adjust size as needed */
        color: #ffffff;
        /* Bold white */
        text-shadow: none;
        /* Remove any glow */
        transition: none;
        /* No animation needed */
    }

    /* Blinking animation for date */
    @keyframes blink {

        0%,
        50%,
        100% {
            opacity: 1;
        }

        25%,
        75% {
            opacity: 0;
        }
    }

    .blink-date {
        animation: blink 6s infinite;
    }
</style>



<!-- Spinner Start -->
<div id="spinner"
    class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->


<!-- Navbar start -->
<div class="container-fluid sticky-top px-0">
    {{-- <div class="nav-bg"> --}}
        <div class="container-fluid topbar d-none d-lg-block">
            <div class="container px-0">
                <div class="topbar-top d-flex justify-content-between flex-lg-wrap">
                    <div class="top-info flex-grow-0">
                        <span> <img src="{{ asset('storage/img/Government_of_Kerala_Logo.png') }}"
                                class="img-fluid me-2" style="width: 30px; height: 30px;"
                                alt="Government of Kerala Logo">
                        </span>

                        <div class="pe-2 me-3 border-end border-white d-flex align-items-center">
                            <p class="mb-0 text-white fs-6 fw-bold">KLA</p>
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
                            {{-- <i class="fas fa-calendar-alt text-white border-end border-secondary pe-2 me-2"> <span
                                    class="text-body">{{ date('D') }} {{ date('d') }} {{ date('M') }}
                                    {{ date('Y') }}</span></i> --}}
                            <!-- Date -->
                            <i class="fas fa-calendar-alt text-white border-end border-secondary pe-2 me-2">
                                <span class="glow-datetime blink-date" id="current-date">
                                    {{ date('D') }} {{ date('d') }} {{ date('M') }} {{ date('Y') }}
                                </span>
                            </i>

                            <!-- Time -->
                            <span class="glow-datetime" id="kolkata-time">Loading IST...</span>
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
        <div class="container-fluid nav-bg">
            <div class="container px-0">
                <nav class="navbar navbar-light navbar-expand-xl">
                    <a href="{{ route('home.index') }}" class="navbar-brand mt-3">
                        <p class="text-primary display-6 mb-2" style="line-height: 0;">INTRANET</p>
                        <small class="fw-normal" style="letter-spacing: 3px;">Kerala Legislature
                            Secretariat</small>
                    </a>
                    <button class="navbar-toggler py-2 px-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse py-3 justify-content-end" id="navbarCollapse">
                        <div class="navbar-nav border-top border-xl-0">
                            {{-- <a href="{{ route('home.index') }}"
                                class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a> --}}
                            {{-- <a href="{{ route('home.index-other') }}"
                                class="nav-item nav-link {{ request()->routeIs('home.index-other') ? 'active' : '' }}">Home
                                I</a> --}}
                            <div class="nav-item dropdown">
                                <a href="{{ route('home.index') }}"
                                    class="nav-link dropdown-toggle {{ request()->routeIs('home.order-circular') || request()->routeIs('home.order-circular.*') ? 'active' : '' }}"
                                    data-bs-toggle="dropdown">
                                    Orders/Circulars
                                </a>
                                <div class="dropdown-menu m-0 drop-bg rounded-0">
                                    <a class="dropdown-item" href="{{ route('home.order-circular', 'go') }}">Government
                                        Order</a>
                                    <a class="dropdown-item" href="{{ route('home.order-circular', 'oo') }}">Office
                                        Order</a>
                                    <a class="dropdown-item"
                                        href="{{ route('home.order-circular', 'cr') }}">Circular</a>
                                </div>
                            </div>

                            <div class="nav-item dropdown">
                                <a href="{{ route('home.index') }}"
                                    class="nav-link dropdown-toggle {{ request()->routeIs('home.employees') || request()->routeIs('home.employees.*') ? 'active' : '' }}"
                                    data-bs-toggle="dropdown">
                                    Employee Corner
                                </a>
                                <div class="dropdown-menu m-0 drop-bg rounded-0">
                                    <a class="dropdown-item" href="{{ route('home.employees') }}">Current
                                        Employees</a>
                                    {{-- <a class="dropdown-item" href="{{ route('home.retired-staff') }}">Retired
                                        Employees</a> --}}
                                </div>
                            </div>


                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    IT Complaint Register
                                    <span class="badge bg-danger ms-1"
                                        style="font-size: 0.7rem; vertical-align: top;">{{
    \App\Models\ComplaintRegister::where('status', 'Open')->count() }}</span>
                                </a>
                                <div class="dropdown-menu m-0 drop-bg rounded-0">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#complaintregisterModal">
                                        <i class="bi bi-plus-circle me-2"></i> Raise Ticket
                                    </a>
                                    <!-- <a class="dropdown-item" href="/complaintregister/live-screen" target="_blank">
                                        <i class="bi bi-display me-2 text-primary"></i>  
                                    </a> -->
                                </div>
                            </div>

                            <a href="http://172.24.18.28/attendance-mgmt-backend/booking_tv" class="nav-item nav-link"
                                target="_blank">
                                Today's Meetings
                            </a>

                            <a href="{{ route('home.upload-request') }}"
                                class="nav-item nav-link {{ request()->routeIs('home.upload-request') ? 'active' : '' }}">
                                Upload Request
                            </a>

                            <a href="{{ route('home.advanced-search') }}">
                                <button
                                    class="btn-search btn border border-primary btn-md-square rounded-circle bg-white my-auto">
                                    <i class="fas fa-search text-primary"></i>
                                </button>
                            </a>
                        </div>
                    </div>
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