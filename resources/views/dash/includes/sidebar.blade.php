<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.home') }}">{{ $website_title}}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.home') }}">TD</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ trans('dash.app') }}</li>

            <li class="nav-item {{ is_active('users') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-users"></i><span>{{ trans('users.module_title') }}</span></a>
            </li>

            <li class="nav-item {{ is_active('trips') ? 'active' : '' }}">
                <a href="{{ route('trips.index') }}" class="nav-link"><i class="fas fa-plane"></i><span>{{ trans('trips.module_title') }}</span></a>
            </li>
            <li class="nav-item {{ is_active('orders') ? 'active' : '' }}">
                <a href="{{ route('orders.index') }}" class="nav-link"><i class="fas fa-shopping-cart"></i><span>{{ trans('orders.module_title') }}</span></a>
            </li>
            <li class="nav-item {{ is_active('deals') ? 'active' : '' }}">
                <a href="{{ route('deals.index') }}" class="nav-link"><i class="fas fa-handshake"></i><span>{{ trans('deals.module_title') }}</span></a>
            </li>
            <li class="menu-header">{{ trans('dash.general') }}</li>
            <li class="nav-item {{ is_active('news') ? 'active' : '' }}">
                <a href="{{ route('news.index') }}" class="nav-link"><i class="far fa-file-alt"></i><span>{{ trans('news.module_title') }}</span></a>
            </li>
            <li class="nav-item {{ is_active('categories') ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link"><i class="fas fa-th-large"></i><span>{{ trans('categories.module_title') }}</span></a>
            </li>
            <li class="nav-item {{ is_active('help_supports') ? 'active' : '' }}">
                <a href="{{ route('help_supports.index') }}" class="nav-link"><i class="fas fa-headset"></i><span>{{ trans('help_supports.module_title') }}</span></a>
            </li>
            <li class="menu-header">{{ trans('dash.settings') }}</li>
        </ul>
    </aside>
</div>