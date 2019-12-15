  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ Request::is('/') ? 'active' : '' }}">
          <a href="{{ url('/') }}">
            <i class="fa fa-dashboard"></i> <span>@lang('sidebar.dashboard')</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
          <li class="treeview {{ Request::is('users*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-th"></i> <span>@lang('sidebar.users')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('create_user')
            <li class="{{ Request::is('users/create') ? 'active' : '' }}">
              <a href="{{ url('users/create') }}"><i class="fa fa-circle-o">
              </i> @lang('sidebar.Add New')</a>
            </li>
            @endcan
            @can('view_user')
            <li class="{{ Request::is('users') ? 'active' : '' }}">
              <a href="{{ url('users') }}"><i class="fa fa-circle-o"></i> @lang('sidebar.View Users')</a>
            </li>
            @endcan
          </ul>
        </li>
        @can('view_role')
        <li class="{{ Request::is('roles') ? 'active' : '' }}">
          <a href="{{ url('roles') }}">
            <i class="fa fa-edit"></i> <span> @lang('sidebar.Roles & Permissions')</span>
          </a>
        </li>
        @endcan
        @can('view_activities')
        <li class="{{ Request::is('activities') ? 'active' : '' }}">
          <a href="{{ url('activities') }}">
            <i class="fa fa-files-o"></i> <span> @lang('sidebar.Activities')</span>
          </a>
        </li>
        @endcan
        @can('view_settings')
            <li class="treeview {{ Request::is('settings*') ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-wrench"></i> <span> @lang('sidebar.Settings') </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('settings/general') ? 'active' : '' }}">
              <a href="{{ url('settings/general') }}"><i class="fa fa-circle-o">
              </i> @lang('sidebar.General')</a>
            </li>
            <li class="{{ Request::is('settings/login-url') ? 'active' : '' }}">
              <a href="{{ url('settings/login-url') }}"><i class="fa fa-circle-o">
              </i> @lang('dashboard.login_url_redirect')</a>
            </li>
            <li class="{{ Request::is('settings/github') || Request::is('settings/facebook') || Request::is('settings/google') ? 'active' : '' }}">
              <a href="{{ url('settings/github') }}"><i class="fa fa-circle-o">
              </i> @lang('dashboard.oauth_settings')</a>
            </li>
            <li class="{{ Request::is('settings/mail') ? 'active' : '' }}">
              <a href="{{ url('settings/mail') }}"><i class="fa fa-circle-o">
              </i> @lang('dashboard.mail_setup')</a>
            </li>
            <li class="{{ Request::is('settings/options') ? 'active' : '' }}">
              <a href="{{ url('settings/options') }}"><i class="fa fa-circle-o">
              </i> @lang('dashboard.sign_up')</a>
            </li>
          </ul>
        </li>
        @endcan
    </section>
    <!-- /.sidebar -->
  </aside>