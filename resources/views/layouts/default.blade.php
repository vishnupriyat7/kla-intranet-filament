<!DOCTYPE html>
<html lang="en">

    @include('partials.header')

<body>

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')
    @include('partials.helpdesk-modal')

    @yield('scripts')

</body>

</html>
