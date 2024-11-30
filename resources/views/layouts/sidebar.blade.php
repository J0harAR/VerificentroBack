<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a href="index">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('usuarios.index')}}">
                        <i class="bx bx-user"></i>
                        <span data-key="t-dashboard">@lang('translation.Users')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('roles.index')}}">
                        <i class="bx bxs-user-detail"></i>
                        <span data-key="t-dashboard">@lang('translation.Role')</span>
                    </a>
                </li>

              
            
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
