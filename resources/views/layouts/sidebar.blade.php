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

                <li>
                    <a href="{{route('citas.index')}}">
                        <i class='bx bx-calendar-event'></i>
                        <span data-key="t-dashboard">@lang('translation.Date')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('estaciones.index')}}">
                    <i class='bx bx-buildings'></i>
                        <span data-key="t-dashboard">@lang('translation.Building')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('horarios.index')}}">
                    <i class='bx bx-time'></i>
                        <span data-key="t-dashboard">@lang('translation.schedule')</span>
                    </a>
                </li>

              
            
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
