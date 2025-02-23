<div class="app-menu navbar-menu">
    <!-- LOGO -->


    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <x-nav-link class="nav-link menu-link" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </x-nav-link>

                </li> <!-- end Dashboard Menu -->
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <x-nav-link class="nav-link menu-link" :href="route('users.index')" :active="request()->routeIs('users.index')">
                            <i class="ri-user-line"></i> <span data-key="t-manager">Managers</span>
                        </x-nav-link>
                    </li>

                    <li class="nav-item">

                        <x-nav-link class="nav-link menu-link" :href="route('places.index')" :active="request()->routeIs('places.index') || request()->routeIs('places.show')">
                            <i class="ri-layout-3-line"></i><span data-key="t-places">Manage Places</span>
                        </x-nav-link>

                    </li>
                @endif
                <li class="menu-title"><span data-key="t-bookings">Booking requests</span></li>


                <li class="nav-item">

                    <x-nav-link class="nav-link menu-link" :href="route('pending_booking')" :active="request()->routeIs('pending_booking')">
                        <i class="ri-discuss-line"></i><span data-key="t-pending">Pending</span>
                    </x-nav-link>
                    <x-nav-link class="nav-link menu-link" :href="route('approved_booking')" :active="request()->routeIs('approved_booking')">
                        <i class="ri-chat-check-line"></i><span data-key="t-approved">Approved</span>
                    </x-nav-link>
                    <x-nav-link class="nav-link menu-link" :href="route('rejected_booking')" :active="request()->routeIs('rejected_booking')">
                        <i class="ri-chat-delete-line"></i><span data-key="t-rejected">Rejected</span>
                    </x-nav-link>

                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
