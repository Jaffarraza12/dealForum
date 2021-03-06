<style >

</style>
<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('users_manage')
                <li class="nav-item">

                    <a href="{{ route('admin.category.index') }}" class="nav-link {{ request()->is('categories') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-file">

                        </i>
                        Category
                    </a>
                </li>
                @endcan
                 <li class="nav-item">
                    <a href="{{ route('companies.index') }}" class="nav-link {{ request()->is('companies') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-building">

                        </i>
                        Companies
                    </a>
                </li>
                 <li class="nav-item" >
                    <a href="{{ route('deals.index') }}" class="nav-link {{ request()->is('deals') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-tag">

                        </i>
                        Deals
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('coupons.index') }}" class="nav-link {{ request()->is('coupons') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fw fa-percent">

                        </i>
                        Coupons
                    </a>
                </li>
                 @can('users_manage')
                <li class="nav-item nav-dropdown">
                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items" style="display: none;">
                        <li class="nav-item" style="display: none;" >
                            <a href="{{ route("admin.abilities.index") }}" class="nav-link {{ request()->is('admin/abilities') || request()->is('admin/abilities/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt nav-icon">

                                </i>
                                {{ trans('cruds.ability.title') }}
                            </a>
                        </li>
                        <li class="nav-item" style="display: none;">
                            <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                        <li class="nav-item" style="display: none;">
                            <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    </ul>
                </li>
             @endcan 
              <li class="nav-item">
                <a href="/public/validate-coupon" class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-fw fa-check-circle">

                    </i>
                    Validate Coupon
                </a>    
            </li>  
             @can('users_manage')
            <li class="nav-item">
                <a href="{{ route('admin.setting') }}" class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-fw fa-cog">

                    </i>
                    Settings
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item"> <a href="/public/chats/1" class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-fw fa-comment">

                    </i>
                    Chatting Module
                </a></li>
                </ul>    
            </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('auth.change_password') }}" class="nav-link {{ request()->is('change_password') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-fw fa-key">

                    </i>
                    Change Password
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button" style="display: none;"></button>
</div>