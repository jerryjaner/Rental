@php

$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp


<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{($route == 'home')?'active':''}}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ route('familyprofile.index') }}"  class="nav-link {{($route == 'familyprofile.index')?'active':''}}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>
                        Family Profile
                    </p>
                </a>
            </li> --}}

            <li class="nav-item">
                <a href="{{ route('room.index') }}"  class="nav-link {{($route == 'room.index')?'active':''}}">
                    <i class="nav-icon fas fa-door-open"></i>
                    <p>
                        Apartment Room
                    </p>
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('apartment.index') }}"  class="nav-link {{($route == 'apartment.index')?'active':''}}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>
                       Apartment Rent
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{($route == 'users.index')?'active':''}}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('Users') }}
                    </p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <i class="nav-icon far fa-address-card"></i>
                    <p>
                        Products
                    </p>
                </a>
            </li> --}}

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="mr-2 fas fa-sign-out-alt"></i>
                        {{ __('Log Out') }}
                    </a>
                </form>

            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->


