<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Financia') - Accounting App</title>
    <link rel="icon" href="{{ asset('shil_logo.jpg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        macblue: { 50: '#f0f6ff', 100: '#e0edff', 200: '#c9e0ff', 300: '#a8ceff', 400: '#86b2ff', 500: '#5e8eff', 600: '#3d6bff', 700: '#2d5af1', 800: '#1f49d4', 900: '#1d3fab' },
                        macgray: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; -webkit-font-smoothing: antialiased; }
        .sidebar-item:hover .sidebar-icon { transform: scale(1.1); }
        .sidebar-subitem { transition: all 0.2s ease; }
        .sidebar-subitem:hover { background-color: rgba(255,255,255,0.1); }
        .content-area { scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
        .content-area::-webkit-scrollbar { width: 6px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 3px; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar-open { transform: translateX(0); }
        }
    </style>
</head>
<body class="h-full bg-macgray-50 flex overflow-hidden">

    @include('layouts.partials.sidebar')

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        @include('layouts.partials.header')

        <!-- Content area -->
        <main class="content-area flex-1 overflow-y-auto p-4 md:p-6 bg-macgray-50">
            @yield('content')
        </main>
        
        @include('layouts.partials.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        feather.replace();
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });

        const menuToggle = document.getElementById('menuToggle');
        const closeMenu = document.getElementById('closeMenu');
        const sidebar = document.getElementById('sidebar');

        if (menuToggle && closeMenu && sidebar) {
            menuToggle.addEventListener('click', () => sidebar.classList.add('sidebar-open'));
            closeMenu.addEventListener('click', () => sidebar.classList.remove('sidebar-open'));

            // Toggle submenus
            document.querySelectorAll('#sidebar nav li > div').forEach(item => {
                item.addEventListener('click', () => {
                    const submenu = item.nextElementSibling;
                    const chevron = item.querySelector('i[data-feather="chevron-down"]');
                    submenu.classList.toggle('hidden');
                    chevron.classList.toggle('rotate-180');
                });
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('sidebar-open');
                }
            });
        }
    </script>
</body>
</html>