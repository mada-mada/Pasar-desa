<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasar Desa Indramayu')</title>
    <meta name="description" content="@yield('meta_description', 'Portal pasar desa Indramayu untuk mencari lokasi, hari buka, fasilitas, artikel, dan rute pasar secara cepat.')">
    <meta property="og:title" content="@yield('title', 'Pasar Desa Indramayu')">
    <meta property="og:description" content="@yield('meta_description', 'Portal pasar desa Indramayu untuk mencari lokasi, hari buka, fasilitas, artikel, dan rute pasar secara cepat.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('logo.png'))">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')
</head>

<body class="flex min-h-screen flex-col bg-[#fafafa] text-[#0f172a]">
    <nav class="navbar-glass sticky top-0 z-50 text-white" aria-label="Navigasi Utama">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="{{ route('pasar.index') }}" class="flex items-center gap-2.5" aria-label="Beranda Pasar Desa">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eab308] shadow-lg">
                        <i class="fas fa-store text-base text-[#0f172a]"></i>
                    </div>
                    <span class="text-lg font-black tracking-tight text-white">
                        Pasar<span class="text-[#eab308]">Desa</span>
                    </span>
                </a>

                <div class="hidden items-center gap-8 md:flex" role="menubar">
                    <a href="{{ route('pasar.index') }}" class="nav-link {{ request()->routeIs('pasar.index') ? 'nav-link--active' : '' }}" role="menuitem">Beranda</a>
                    <a href="{{ route('pasar.list') }}" class="nav-link {{ request()->routeIs('pasar.list') || request()->routeIs('pasar.show') ? 'nav-link--active' : '' }}" role="menuitem">Pasar</a>
                    <a href="{{ route('artikel.index') }}" class="nav-link {{ request()->routeIs('artikel.*') ? 'nav-link--active' : '' }}" role="menuitem">Artikel</a>
                </div>

                <button id="mobile-menu-btn"
                    class="rounded-lg p-2 text-white/70 transition-colors hover:text-[#facc15] focus:outline-none md:hidden"
                    aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-drawer">
                    <i class="fas fa-bars text-lg" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <div id="mobile-drawer"
            class="absolute left-0 top-full hidden w-full border-t border-[#eab308]/20 bg-[#0f172a]/95 backdrop-blur-xl shadow-2xl md:hidden"
            role="dialog" aria-label="Menu Mobile">
            <div class="flex flex-col gap-2 px-4 py-4">
                <a href="{{ route('pasar.index') }}" class="mobile-drawer-link">
                    <i class="fas fa-home"></i>Beranda
                </a>
                <a href="{{ route('pasar.list') }}" class="mobile-drawer-link">
                    <i class="fas fa-store"></i>Pasar
                </a>
                <a href="{{ route('pasar.index') }}#peta-pasar" class="mobile-drawer-link">
                    <i class="fas fa-map-location-dot"></i>Peta
                </a>
                <a href="{{ route('artikel.index') }}" class="mobile-drawer-link">
                    <i class="fas fa-newspaper"></i>Artikel
                </a>
            </div>
        </div>
    </nav>

    @yield('context_bar')

    <main class="w-full flex-grow">
        @yield('content')
    </main>

    <footer class="footer-modern pt-12 pb-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div>
                    <div class="mb-4 flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#eab308]">
                            <i class="fas fa-store text-sm text-[#0f172a]"></i>
                        </div>
                        <span class="text-base font-black tracking-tight text-white">
                            Pasar<span class="text-[#eab308]">Desa</span>
                        </span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Informasi pasar desa di Indramayu dengan fokus pada hari operasional, navigasi cepat, peta interaktif, dan transparansi fasilitas.
                    </p>
                </div>

                <div>
                    <h3 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#eab308]">Tautan Cepat</h3>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('pasar.index') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Beranda</a></li>
                        <li><a href="{{ route('pasar.list') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Daftar Pasar</a></li>
                        <li><a href="{{ route('pasar.index') }}#peta-pasar" class="footer-link"><i class="fas fa-chevron-right"></i>Peta Interaktif</a></li>
                        <li><a href="{{ route('artikel.index') }}" class="footer-link"><i class="fas fa-chevron-right"></i>Artikel</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#eab308]">Kontak</h3>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5"><i class="fas fa-map-marker-alt mt-0.5 w-4 text-center text-[#eab308]"></i><span>Indramayu, Jawa Barat</span></li>
                        <li class="flex items-start gap-2.5"><i class="fas fa-envelope mt-0.5 w-4 text-center text-[#eab308]"></i><span>info@pasardesa.id</span></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col items-center justify-between gap-2 border-t border-white/10 pt-6 md:flex-row">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Pasar Desa Indramayu. Hak Cipta Dilindungi.</p>
                <p class="text-xs text-slate-600">Membangun ekonomi lokal bersama data yang lebih mudah diakses.</p>
            </div>
        </div>
    </footer>

    <script>
        (function() {
            const btn = document.getElementById('mobile-menu-btn');
            const drawer = document.getElementById('mobile-drawer');
            const icon = document.getElementById('menu-icon');

            if (!btn || !drawer || !icon) return;

            btn.addEventListener('click', function() {
                const isOpen = !drawer.classList.contains('hidden');
                drawer.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(!isOpen));
                icon.className = isOpen ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
            });
        })();
    </script>

    @yield('scripts')
</body>

</html>
