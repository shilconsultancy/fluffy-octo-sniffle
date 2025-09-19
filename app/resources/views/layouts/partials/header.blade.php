<!-- Top bar -->
<header class="bg-white border-b border-macgray-200 py-3 px-4 md:px-6 flex items-center justify-between">
    <div class="flex items-center">
        <!-- Mobile menu button -->
        <button id="menuToggle" class="p-2 rounded-md bg-white text-macgray-600 md:hidden mr-2">
            <i data-feather="menu" class="h-6 w-6"></i>
        </button>
        <h1 class="text-xl font-semibold text-macgray-800">
            @yield('title', 'Dashboard')
        </h1>
    </div>
    <div class="flex items-center space-x-2 md:space-x-4">
        <button class="p-2 rounded-full hover:bg-macgray-100 text-macgray-600">
            <i data-feather="search"></i>
        </button>
        <button class="p-2 rounded-full hover:bg-macgray-100 text-macgray-600">
            <i data-feather="bell"></i>
        </button>
    </div>
</header>