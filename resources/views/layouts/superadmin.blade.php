<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SuperAdmin Panel - Pasar Desa')</title>
    
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
    <aside class="w-64 bg-gray-900 text-white flex flex-col shadow-2xl z-20">
        <div class="h-16 flex items-center justify-center border-b border-gray-800">
            <h1 class="text-xl font-bold text-gold"><i class="fas fa-crown text-gold mr-2"></i> SuperAdmin</h1>
        </div>
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('superadmin.pasar.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 transition-colors border-l-4 {{ request()->routeIs('superadmin.pasar.*') ? 'border-gold bg-gray-800' : 'border-transparent' }}">
                        <i class="fas fa-map-marked-alt w-6 text-gold"></i>
                        <span>Kelola Semua Pasar</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-gray-800">
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
                <button class="text-gray-500 hover:text-gray-900 focus:outline-none xl:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Super Administrator</span>
                <div class="w-10 h-10 rounded-full bg-gold flex items-center justify-center text-white font-bold">
                    SA
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
