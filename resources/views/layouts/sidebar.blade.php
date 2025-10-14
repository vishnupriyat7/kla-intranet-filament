
    <div class="sidebar-logo">
        <a href="#">KLA INTRANET</a>
    </div>
    <!-- Sidebar Navigation -->
    <ul class="sidebar-nav p-0">
        <li class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="lni lni-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('periodicals.index') ? 'active' : '' }}">
            <a href="{{ route('periodicals.index') }}" class="sidebar-link">
                <i class="lni lni-user"></i>
                <span>Periodicals</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('news-updates.index') ? 'active' : '' }}">
            <a href="{{ route('news-updates.index') }}" class="sidebar-link">
                <i class="ri ri-news-line"></i>
                <span>News/Updates</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::routeIs('orders-circular.index') ? 'active' : '' }}">
            <a href="{{ route('orders-circular.index') }}" class="sidebar-link">
                <i class="ri ri-news-line"></i>
                <span>Orders / Circular</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link has-dropdown collapsed"
                data-bs-toggle="collapse" data-bs-target="#settings"
                aria-expanded="{{ Request::routeIs('periodical-masters.index') ? 'true' : 'false' }}"
                aria-controls="settings">
                <i class="lni lni-protection"></i>
                <span>Settings</span>
            </a>
            <ul id="settings"
                class="sidebar-dropdown list-unstyled collapse {{ Request::routeIs('periodical-masters.index') ? 'show' : '' }}"
                data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ route('periodical-masters.index') }}"
                        class="sidebar-link {{ Request::routeIs('periodical-masters.index') ? 'active' : '' }}">
                        <i class="lni lni-agenda"></i> Periodical Items
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="route('logout')" class="sidebar-link"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="lni lni-exit"></i>
                    <span>Log Out</span>
                </a>
            </form>
        </li>
    </ul>
    <!-- Sidebar Navigation Ends -->
