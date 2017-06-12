<header id="main-top-header" class="print-hidden">
    <div class="navbar botBorder" id="navto">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle navbtn" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">{{ config('app.name') }}</a>
                <div class="navbar-brand brand-pic">

                </div>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li><a href="#">ABOUT</a> </li>
                    <li><a href="#">CONTACT</a> </li>
                    @if (Auth::guest())
                        <li><a href="{{ route('users.login') }}">LOGIN</a></li>
                        <li><a href="{{ route('users.register') }}">REGISTER</a></li>
                    @else
                        <li><a href="{{ route('checklists.index') }}">CHECKLISTS</a> </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('users.profile', ['user_id' => Auth::user()->id])  }}">Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('users.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('users.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>