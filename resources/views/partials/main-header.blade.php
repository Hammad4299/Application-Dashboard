<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('root') }}">{{ config('app.name') }}</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li class="rightNav" ><a href="{{ route('root') }}">Home</a></li>
                    <li class="lione">
                        <a  data-toggle="dropdown" class="dropdown-toggle user1">
                            <div class="col-sm-12">
                                <div class="pull-right">
                                    <span>{{ Auth::user()->name }}</span>
                                    <span class="caret"></span>
                                </div>
                                <div class="pull-right" style="margin-right: 10px;">
                                    <img src="{{ Auth::user()->user_image_url }}"  class="user-header-image user-img" />
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu list">
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