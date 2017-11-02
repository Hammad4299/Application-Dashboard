<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-nav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('root') }}">@yield('appName',config('app.name'))</a>
        </div>
        <div class="collapse navbar-collapse" id="header-nav">
            {{--<ul class="nav navbar-nav">--}}

            {{--</ul>--}}
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span>
                                <img src="{{ Auth::user()->user_image_url }}"  class="user-header-image user-img" />
                                <span>{{ Auth::user()->name }}</span>
                            </span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('users.profile',['user_id'=>\Illuminate\Support\Facades\Auth::user()->id]) }}">Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('login-page') }}">Login</a></li>
                    <li><a href="{{ route('signup-page') }}">Sign Up</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>