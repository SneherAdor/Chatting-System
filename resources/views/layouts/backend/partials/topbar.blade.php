
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      @php 
        $siteName = \DB::table('general_settings')->where('id', '1')->value('name'); 
        $logo = \DB::table('general_settings')->where('id', '1')->value('logo'); 
      @endphp
      <span class="logo-mini">
        
        @if(isset($logo))
            <img src="{{ url('storage/logo/' . $logo) }}" class="img-circle"  width="48" height="48">
        @else
            <img src="{{ url('assets/backend/dist/img/logo.png') }}" class="img-circle">
        @endif
      </span>

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
        @if(isset($logo))
            <img src="{{ url('storage/logo/'.$logo) }}" class="img-circle"  width="48" height="48">
        @else
            <img src="{{ url('assets/backend/dist/img/logo.png') }}" class="img-circle">
        @endif
          {{ $siteName }}
        
       </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(isset(Auth::user()->photo))
                <img src="{{ url('storage/users/'.Auth::user()->photo) }}" class="user-image" alt="User Image">
              @else
                <img src="{{ url('assets/backend/dist/img/user.png') }}" class="user-image" alt="User Image">
              @endif
              
              {{-- <span class="hidden-xs">{{Auth::user()->name}}</span> --}}
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

              @if(isset(Auth::user()->photo))
                <img class="profile-user-img img-responsive img-circle" src="{{ url('storage/users/'.Auth::user()->photo) }}" alt="User profile picture">
              @else
                <img src="{{ url('assets/backend/dist/img/user.png') }}" class="img-circle" alt="User Image">
              @endif
                

                <p>
                  {{Auth::user()->name}}
                  <small>{{ucwords(Auth::user()->getRoleNames()->implode(''))}}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('users/profile/' . Auth::user()->id) }}" class="btn btn-default btn-flat"> @lang('dashboard.profile') </a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Sign out') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>