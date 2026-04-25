<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Pasar Desa')</title>
    
    <!-- Tailwind CSS (CDN for rapid implementation with config) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            DEFAULT: '#D4AF37',
                            light: '#FDE047',
                            dark: '#b5952f'
                        },
                        blue: {
                            deep: '#1E3A8A',
                            light: '#3B82F6',
                            dark: '#1e40af'
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @yield('styles')
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-20 hidden lg:hidden"></div>
    <aside id="sidebar" class="w-64 bg-blue-deep text-white flex flex-col shadow-2xl z-30 absolute inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition duration-300 ease-in-out">
        <div class="h-16 flex items-center justify-center border-b border-blue-800">
            <h1 class="text-xl font-bold text-gold"><i class="fas fa-store mr-2"></i> Pasar Desa</h1>
        </div>
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.pasar.index') }}" class="flex items-center px-6 py-3 hover:bg-blue-dark transition-colors border-l-4 {{ request()->routeIs('admin.pasar.*') ? 'border-gold bg-blue-dark' : 'border-transparent' }}">
                        <i class="fas fa-map-marked-alt w-6 text-gold"></i>
                        <span>Kelola Pasar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.artikel.index') }}" class="flex items-center px-6 py-3 hover:bg-blue-dark transition-colors border-l-4 {{ request()->routeIs('admin.artikel.*') ? 'border-gold bg-blue-dark' : 'border-transparent' }}">
                        <i class="fas fa-newspaper w-6 text-gold"></i>
                        <span>Artikel</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-blue-800">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 glass">
            <div class="flex items-center">
                <button id="mobile-menu-btn" class="text-gray-500 hover:text-blue-deep focus:outline-none lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Administrator</span>
                <div class="w-10 h-10 rounded-full bg-gold flex items-center justify-center text-white font-bold">
                    A
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            if (overlay) overlay.classList.toggle('hidden');
        }

        if (btn) btn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
