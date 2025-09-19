<!-- Sidebar -->
<div id="sidebar" class="sidebar w-64 bg-macgray-800 text-white flex-shrink-0 flex flex-col h-full fixed md:relative z-40">
    <!-- Logo -->
    <div class="p-4 border-b border-macgray-700 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-md bg-macblue-500 flex items-center justify-center">
                <i data-feather="dollar-sign" class="text-white"></i>
            </div>
            <span class="font-semibold text-lg">Financia</span>
        </div>
        <div class="md:hidden">
            <button id="closeMenu" class="p-1 rounded-md hover:bg-macgray-700">
                <i data-feather="x"></i>
            </button>
        </div>
    </div>

    <!-- User Profile -->
    <div class="p-4 border-b border-macgray-700 flex items-center space-x-3">
        @if (Auth::user()->avatar)
            <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="User Avatar">
        @else
            <div class="w-10 h-10 rounded-full bg-macblue-500 flex items-center justify-center">
                <i data-feather="user" class="text-white"></i>
            </div>
        @endif
        <div>
            <div class="font-medium">{{ Auth::user()->name }}</div>
             <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-xs text-macgray-400 hover:text-white">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-2">
        <nav>
            <ul class="space-y-1 px-2">
                <!-- Home -->
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-macblue-700 text-white' : 'hover:bg-macgray-700' }}">
                        <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                            <i data-feather="home" class="w-4 h-4"></i>
                        </span>
                        <span>Home</span>
                    </a>
                </li>

                <!-- Items -->
                <li class="mt-4">
                    <div class="px-3 py-2 flex items-center justify-between rounded-md hover:bg-macgray-700 cursor-pointer">
                        <div class="flex items-center">
                            <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                                <i data-feather="box" class="w-4 h-4"></i>
                            </span>
                            <span>Items</span>
                        </div>
                        <i data-feather="chevron-down" class="w-4 h-4 transition-transform transform"></i>
                    </div>
                    <ul class="pl-4 mt-1 space-y-1 hidden">
                        <li>
                            <a href="{{ route('items.index') }}" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Items</a>
                        </li>
                    </ul>
                </li>

                <!-- Sales -->
                <li class="mt-4">
                    <div class="px-3 py-2 flex items-center justify-between rounded-md hover:bg-macgray-700 cursor-pointer">
                        <div class="flex items-center">
                            <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                                <i data-feather="shopping-cart" class="w-4 h-4"></i>
                            </span>
                            <span>Sales</span>
                        </div>
                        <i data-feather="chevron-down" class="w-4 h-4 transition-transform transform"></i>
                    </div>
                    <ul class="pl-4 mt-1 space-y-1 hidden">
                        <li><a href="{{ route('customers.index') }}" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Customers</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Quotes</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Invoices</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Sales Receipts</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Recurring Invoices</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Payments Received</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Credit Notes</a></li>
                    </ul>
                </li>

                <!-- Purchases -->
                <li class="mt-4">
                    <div class="px-3 py-2 flex items-center justify-between rounded-md hover:bg-macgray-700 cursor-pointer">
                        <div class="flex items-center">
                            <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                                <i data-feather="credit-card" class="w-4 h-4"></i>
                            </span>
                            <span>Purchases</span>
                        </div>
                        <i data-feather="chevron-down" class="w-4 h-4 transition-transform transform"></i>
                    </div>
                    <ul class="pl-4 mt-1 space-y-1 hidden">
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Vendors</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Expenses</a></li>
                    </ul>
                </li>

                <!-- Banking -->
                 <li class="mt-4">
                    <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-macgray-700">
                        <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                            <i data-feather="briefcase" class="w-4 h-4"></i>
                        </span>
                        <span>Banking</span>
                    </a>
                </li>

                <!-- Accountant -->
                <li class="mt-4">
                    <div class="px-3 py-2 flex items-center justify-between rounded-md hover:bg-macgray-700 cursor-pointer">
                        <div class="flex items-center">
                            <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                                <i data-feather="book" class="w-4 h-4"></i>
                            </span>
                            <span>Accountant</span>
                        </div>
                        <i data-feather="chevron-down" class="w-4 h-4 transition-transform transform"></i>
                    </div>
                    <ul class="pl-4 mt-1 space-y-1 hidden">
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Manual Journals</a></li>
                        <li><a href="#" class="sidebar-subitem block px-3 py-2 rounded-md text-sm text-macgray-300 hover:text-white">Chart of Accounts</a></li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="mt-4">
                    <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-macgray-700">
                        <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                            <i data-feather="bar-chart-2" class="w-4 h-4"></i>
                        </span>
                        <span>Reports</span>
                    </a>
                </li>

                <!-- Documents -->
                <li class="mt-4">
                    <a href="#" class="flex items-center px-3 py-2 rounded-md hover:bg-macgray-700">
                        <span class="sidebar-icon w-6 h-6 flex items-center justify-center mr-3 transition-transform">
                            <i data-feather="file-text" class="w-4 h-4"></i>
                        </span>
                        <span>Documents</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Bottom section -->
    <div class="p-4 border-t border-macgray-700">
        <a href="{{ route('settings.index') }}" class="flex items-center space-x-3 group {{ request()->routeIs('settings.index') || request()->routeIs('profile.edit') ? 'text-white' : 'text-macgray-400' }} hover:text-white">
            <div class="w-8 h-8 rounded-full {{ request()->routeIs('settings.index') || request()->routeIs('profile.edit') ? 'bg-macblue-700' : 'bg-macgray-700' }} group-hover:bg-macgray-600 flex items-center justify-center">
                <i data-feather="settings" class="w-4 h-4"></i>
            </div>
            <div class="text-sm">Settings</div>
        </a>
    </div>
</div>