<aside id="leftsidebar" class="sidebar">

    <!-- Menu -->
    <div class="menu">
        <ul class="list">

            <li class="header">MAIN NAVIGATION</li>

            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/properties*') ? 'active' : '' }}">
                <a href="{{ route('admin.properties.index') }}">
                    <i class="material-icons">home</i>
                    <span>Property</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                <a href="{{ route('admin.settings') }}">
                    <i class="material-icons">settings</i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/profile') ? 'active' : '' }}">
                <a href="{{ route('admin.profile') }}">
                    <i class="material-icons">user</i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="{{ Request::is('admin/profile') ? 'active' : '' }}">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="material-icons">input</i> {{ __('Sign Out') }}
                </a>
            </li>

        </ul>
    </div>
    <!-- #Menu -->

</aside>