<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    
    <x-nav-link :href="route('risks.index')" :active="request()->routeIs('risks.index')">
        {{ __('Risk Register') }}
    </x-nav-link>
    
    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
        {{ __('Risk Categories') }}
    </x-nav-link>
    
    @if (Auth::user()->role === 'admin')
        <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
            {{ __('User Management') }}
        </x-nav-link>
    @endif
</div>
<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        
        <x-responsive-nav-link :href="route('risks.index')" :active="request()->routeIs('risks.index')">
            {{ __('Risk Register') }}
        </x-responsive-nav-link>
        
        <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
            {{ __('Risk Categories') }}
        </x-responsive-nav-link>
        
        @if (Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                {{ __('User Management') }}
            </x-responsive-nav-link>
        @endif
    </div>
</div>