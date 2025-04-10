   <!-- Top Bar Start -->
   <div class="topbar">

<!-- LOGO -->
<div class="topbar-left">
    <a href="/" class="logo">
        <span>
            <h1>
                <b style="color: #38a4f8;">J</b>
                <b style="color: yellow;">A</b>
                <b style="color:rgb(204, 18, 120);">S</b>
            </h1>
        </span>

        <i>
            <h1>A</h1>
        </i>
    </a>
</div>

<nav class="navbar-custom">
    <ul class="navbar-right d-flex list-inline float-right mb-0">
        <li class="dropdown notification-list">
            <div class="dropdown notification-list nav-pro-img">
                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(Auth::user()->role_id == 1)
                        <img src="assets/images/profile-icon.png" alt="user" class="rounded-circle"> Administrator
                    @endif
                    @if(Auth::user()->role_id == 2)
                        Manager
                    @endif
                    @if(Auth::user()->role_id == 3)
                        Employee
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <a class="dropdown-item" href="/user-profile"><i class="mdi mdi-account-circle m-r-5"></i> Profile</a>
                    @if(Auth::user()->role_id == 1)
                    <a class="dropdown-item" href="/notifications"><i class="mdi mdi-bell-outline m-r-5"></i> Notification</a>
                    @endif
            
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="mdi mdi-power text-danger"></i> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </div>
            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>
    </ul>

</nav>

</div>
<!-- Top Bar End -->
