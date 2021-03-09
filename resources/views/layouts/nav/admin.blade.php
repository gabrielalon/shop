<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            {{ __('admin.navbar.brand') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.account.dashboard') }}" class="nav-link">
                        {{ __('admin.navbar.dashboard') }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="dropdownAccountMenu" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ __('admin.navbar.account.submenu') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownAccountMenu">
                        <a class="dropdown-item" href="{{ route('admin.account.index') }}">
                            {{ __('admin.navbar.account.admin') }}
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="dropdownB2BMenu" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ __('admin.navbar.b2b.submenu') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownB2BMenu">
                        <a class="dropdown-item" href="{{ route('admin.b2b.contractor.index') }}">
                            {{ __('admin.navbar.b2b.contractor') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.b2b.project.index') }}">
                            {{ __('admin.navbar.b2b.project') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.b2b.ticket.index') }}">
                            {{ __('admin.navbar.b2b.ticket') }}
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="dropdownContentMenu" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {{ __('admin.navbar.content.submenu') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownContentMenu">
                        <a class="dropdown-item" href="{{ route('admin.content.blog.category.index') }}">
                            {{ __('admin.navbar.content.blog.category') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.content.blog.entry.index') }}">
                            {{ __('admin.navbar.content.blog.entry') }}
                        </a>
                    </div>
                </li>
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->login() }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.account.profile') }}">{{ __('admin.account.profile') }}</a>

                        <a class="dropdown-item" href="{{ route('admin.account.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('admin.account.logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.account.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
