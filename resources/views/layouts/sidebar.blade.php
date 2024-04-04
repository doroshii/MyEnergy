
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('buildings.index') }}" class="waves-effect">
                        <i class="bx bx-buildings"></i>
                        <span key="t-layouts">Buildings</span>
                    </a>
                </li>

                @can(['create-user', 'edit-user', 'delete-user'])
                <li class="menu-title" key="t-menu">Access</li>

                <li>
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-contacts">Users</span>
                    </a>
                </li>
                @endcan
                
                @can(['create-role', 'edit-role', 'delete-role'])
                <li>
                    <a href="{{ route('roles.index') }}" class="waves-effect">
                        <i class="bx bx-briefcase-alt"></i>
                        <span key="t-ecommerce">Roles</span>
                    </a>
                </li>
                @endcan

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
