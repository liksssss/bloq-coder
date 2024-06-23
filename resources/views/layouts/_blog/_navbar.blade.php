<!-- Navigation Bar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light fixed-top shadow" style="background: #5BBCFF">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" style="font-weight: bold; font-family: Arial, Helvetica, sans-serif"
            href="{{ route('blog.home') }}">
            BLOQ CODER
        </a>
        <!-- Toggler/collapsible Button -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <!-- Home Link:start -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.home') }}">
                        {{ trans('blog.menu.home') }}
                    </a>
                </li>
                <!-- Home Link:end -->
                <!-- Categories Link:start -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.categories') }}">
                        {{ trans('blog.menu.categories') }}
                    </a>
                </li>
                <!-- Categories Link:end -->
                <!-- Tags Link:start -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.tags') }}">
                        {{ trans('blog.menu.tags') }}
                    </a>
                </li>
                <!-- Tags Link:end -->
                <!-- Authentication Links:start -->
                @auth
                    <li class="nav-item dropdown">
                        <!-- Authenticated User Dropdown -->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user fa-lg mr-1"></i>
                            <strong>{{ auth()->user()->name }}</strong>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                            <!-- Dashboard Link -->
                            @if (auth()->check() && !auth()->user()->hasRole('Pengunjung'))
                                <a class="dropdown-item" href="{{ route('dashboard.index') }}">
                                    {{ trans('blog.menu.dashboard') }}
                                </a>
                            @endif
                            <!-- Logout Link -->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <!-- Logout Form -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <!-- Login Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                @endauth
                <!-- Authentication Links:end -->
                {{-- <!-- Language Switcher:start -->
                <li class="nav-item dropdown">
                    <!-- Current Language Display -->
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @switch(app()->getLocale())
                            @case('id')
                                <i class="flag-icon flag-icon-id"></i>
                            @break

                            @case('en')
                                <i class="flag-icon flag-icon-gb"></i>
                            @break
                        @endswitch
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                        <!-- Switch to Indonesian -->
                        <a class="dropdown-item" href="{{ route('localization.switch', ['language' => 'id']) }}">
                            {{ trans('localization.id') }}
                        </a>
                        <!-- Switch to English -->
                        <a class="dropdown-item" href="{{ route('localization.switch', ['language' => 'en']) }}">
                            {{ trans('localization.en') }}
                        </a>
                    </div>
                </li>
                <!-- Language Switcher:end --> --}}
            </ul>
        </div>
    </div>
</nav>
