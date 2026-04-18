<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasar Desa Indramayu')</title>

    <!-- Tailwind CSS -->
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
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">

    @yield('styles')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="navbar-glass sticky top-0 z-50 text-white shadow-lg relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer"
                    onclick="window.location.href='{{ route('pasar.index') }}'">
                    <div class="w-10 h-10 rounded-full bg-gold flex items-center justify-center">
                        <i class="fas fa-store text-blue-deep text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-wide text-white">Pasar<span
                            class="text-gold">Desa</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('pasar.index') }}"
                        class="text-gray-100 hover:text-gold transition-colors font-medium hover-underline-animation text-lg">Beranda</a>
                    <a href="{{ route('artikel.index') }}"
                        class="text-gray-100 hover:text-gold transition-colors font-medium hover-underline-animation text-lg">Artikel</a>
                    <a href="{{ route('pasar.list') }}"
                        class="text-gray-100 hover:text-gold transition-colors font-medium hover-underline-animation text-lg">Pasar</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-white hover:text-gold focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu"
            class="hidden md:hidden absolute w-full left-0 top-full bg-blue-deep/95 backdrop-blur-md shadow-xl border-t border-blue-800">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('pasar.index') }}"
                    class="block px-4 py-2 text-center text-lg font-medium text-white hover:text-gold transition-colors rounded-lg hover:bg-blue-800/50">Beranda</a>
                <a href="{{ route('artikel.index') }}"
                    class="block px-4 py-2 text-center text-lg font-medium text-white hover:text-gold transition-colors rounded-lg hover:bg-blue-800/50">Artikel</a>
                <a href="{{ route('pasar.list') }}"
                    class="block px-4 py-2 text-center text-lg font-medium text-white hover:text-gold transition-colors rounded-lg hover:bg-blue-800/50">Pasar</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-deep text-white pt-12 pb-8 border-t-4 border-gold mt-auto z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-full bg-gold flex items-center justify-center">
                            <i class="fas fa-store text-blue-deep"></i>
                        </div>
                        <span class="font-bold text-xl text-white">Pasar<span class="text-gold">Desa</span></span>
                    </div>
                    <p class="text-gray-300">Menyajikan informasi terlengkap seputar pasar desa di seluruh wilayah
                        Indramayu dengan peta interaktif dan transparansi fasilitas.</p>
                </div>
                <div>
                    <h3 class="text-gold font-semibold text-lg mb-4 uppercase tracking-wider">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pasar.index') }}"
                                class="text-gray-300 hover:text-gold transition-colors"><i
                                    class="fas fa-chevron-right text-xs mr-2 text-gold"></i>Beranda Pasar</a></li>
                        <li><a href="{{ route('artikel.index') }}"
                                class="text-gray-300 hover:text-gold transition-colors"><i
                                    class="fas fa-chevron-right text-xs mr-2 text-gold"></i>Berita & Artikel</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gold font-semibold text-lg mb-4 uppercase tracking-wider">Kontak</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-map-marker-alt mr-2 text-gold w-5 text-center"></i> Indramayu, Jawa Barat
                        </li>
                        <li><i class="fas fa-envelope mr-2 text-gold w-5 text-center"></i> info@pasardesa.id</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-blue-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Pasar Desa Indramayu. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
    // Langsung tembak ID-nya, tidak perlu tunggu DOMContentLoaded
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    if (btn && menu) {
        btn.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });
    }
</script>
    @yield('scripts')
</body>

</html>
