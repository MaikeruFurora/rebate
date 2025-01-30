<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo-->
            <div>
                <a href="#" class="logo">
                    <img src="{{ asset('assets/images/rebate-1.png') }}" class="logo-lg" alt="" height="40">
                    <img src="{{ asset('assets/images/rebate-1.png') }}" class="logo-sm" alt="" height="25">
                </a>
            </div>
            <!-- End Logo-->

            <div class="menu-extras topbar-custom navbar p-0">

                <ul class="mb-0 nav navbar-right ml-auto list-inline">
                    
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <!-- <img src="assets/images/logo-sm.png" alt="user-img" class="rounded-circle"> -->
                            <span class="profile-username">{{ strtoupper(auth()->user()->getFullname()) }}</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li> <a class="text-danger dropdown-item" style="cursor:pointer"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off mr-2"></i>Sign out</a></li>
                        </ul>
                    </li>

                    <li class="menu-item dropdown notification-list list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>

            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div>
        <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">

            <div id="navigation">

                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="{{ route('authenticate.dashboard') }}"><i class="ti-home"></i> Dashboard</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('authenticate.approval') }}"><i class="ti-shield"></i> Approval</a>
                    </li>
                    @if(in_array(auth()->user()->RebateRole,App\Helper\Helper::$rebateRole['menu_bar']) || in_array(auth()->user()->Position_id,['177','185','186','179']))
                    <li class="has-submenu getReport" style="cursor:pointer">
                        <a data-toggle="modal" data-target="#dateRangeModal"><i class="ti-calendar"></i> Report</a>
                    </li>
                    @endif
                    @if(in_array(auth()->user()->RebateRole,['X']))
                    <li class="has-submenu">
                        <a href="{{ route('authenticate.category') }}"><i class="ti-layout-grid2-alt"></i> Categories</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{ route('authenticate.audit.log') }}"><i class="ti-notepad"></i> Audit Records</a>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="ti-user"></i> Users <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('authenticate.user') }}">Users</a></li>
                                    <li><a href="{{ route('authenticate.user.access') }}">Access</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                  
                    @endif
                    <li class="has-submenu">
                        <a class="text-danger" style="cursor:pointer"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off"></i>Sign out</a>
                        <form id="logout-form" action="{{ route('authenticate.signout') }}" method="POST" class="d-none">@csrf</form>
                    </li>

                </ul>
                <!-- End navigation menu -->
            </div>
            <!-- end #navigation -->
        </div>
        <!-- end container -->
    </div>
    <!-- end navbar-custom -->
</header>