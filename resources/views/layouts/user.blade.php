<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasar Desa Indramayu')</title>

    {{-- Vite: TailwindCSS v4 + Custom Design System --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')
</head>

<body class="bg-[#fafafa] flex flex-col min-h-screen text-[#0f172a]">

    {{-- ============================================
         DESKTOP NAVIGATION – Glassmorphism Header
         ============================================ --}}
    <nav class="navbar-glass sticky top-0 z-50 text-white" aria-label="Navigasi Utama">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Brand Logo --}}
                <a href="{{ route('pasar.index') }}" class="flex-shrink-0 flex items-center gap-2.5 group"
                    aria-label="Beranda Pasar Desa">
                    <div
                        class="w-9 h-9 rounded-xl bg-[#eab308] flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fas fa-store text-[#0f172a] text-base"></i>
                    </div>
                    <span class="font-black text-lg tracking-tight text-white">
                        Pasar<span class="text-[#eab308]">Desa</span>
                    </span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-8" role="menubar">
                    <a href="{{ route('pasar.index') }}" class="nav-link" role="menuitem">Beranda</a>
                    <a href="{{ route('pasar.list') }}" class="nav-link" role="menuitem">Pasar</a>
                    <a href="{{ route('artikel.index') }}" class="nav-link" role="menuitem">Artikel</a>
                </div>

                {{-- Desktop: Ikon Kanan --}}
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('pasar.list') }}" class="btn-primary btn-gold text-sm px-4 py-2">
                        <i class="fas fa-map-marker-alt text-xs"></i>
                        Jelajahi Pasar
                    </a>
                </div>

                {{-- Mobile: Hamburger (hanya muncul jika JS dinonaktifkan / fallback) --}}
                <button id="mobile-menu-btn"
                    class="md:hidden text-white/70 hover:text-[#facc15] transition-colors focus:outline-none p-2 rounded-lg"
                    aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-drawer">
                    <i class="fas fa-bars text-lg" id="menu-icon"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Drawer (Desktop-fallback for very small screens) --}}
        <div id="mobile-drawer"
            class="hidden md:hidden absolute w-full left-0 top-full bg-[#0f172a]/95 backdrop-blur-xl border-t border-[#eab308]/20 shadow-2xl"
            role="dialog" aria-label="Menu Mobile">
            <div class="px-4 py-4 flex flex-col gap-2">
                <a href="{{ route('pasar.index') }}"
                    class="block px-4 py-3 text-sm font-semibold text-white/80 hover:text-[#facc15] hover:bg-white/5 rounded-xl transition-all">
                    <i class="fas fa-home mr-2 text-[#eab308]"></i>Beranda
                </a>
                <a href="{{ route('pasar.list') }}"
                    class="block px-4 py-3 text-sm font-semibold text-white/80 hover:text-[#facc15] hover:bg-white/5 rounded-xl transition-all">
                    <i class="fas fa-store mr-2 text-[#eab308]"></i>Pasar
                </a>
                <a href="{{ route('artikel.index') }}"
                    class="block px-4 py-3 text-sm font-semibold text-white/80 hover:text-[#facc15] hover:bg-white/5 rounded-xl transition-all">
                    <i class="fas fa-newspaper mr-2 text-[#eab308]"></i>Artikel
                </a>
            </div>
        </div>
    </nav>

    {{-- ============================================
         MAIN CONTENT
         ============================================ --}}
    <main class="flex-grow w-full pb-0 md:pb-0">
        @yield('content')
    </main>

    {{-- Bottom nav spacer on mobile --}}
    <div class="md:hidden bottom-nav-spacer"></div>

    {{-- ============================================
         FOOTER
         ============================================ --}}
    <footer class="footer-modern pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-[#eab308] flex items-center justify-center">
                            <i class="fas fa-store text-[#0f172a] text-sm"></i>
                        </div>
                        <span class="font-black text-base text-white tracking-tight">
                            Pasar<span class="text-[#eab308]">Desa</span>
                        </span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Informasi terlengkap seputar pasar desa di seluruh wilayah Indramayu dengan peta interaktif dan
                        transparansi fasilitas.
                    </p>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-[#eab308] uppercase tracking-widest mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="{{ route('pasar.index') }}"
                                class="text-sm text-slate-400 hover:text-[#facc15] transition-colors flex items-center gap-2">
                                <i class="fas fa-chevron-right text-[10px] text-[#eab308]"></i>Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pasar.list') }}"
                                class="text-sm text-slate-400 hover:text-[#facc15] transition-colors flex items-center gap-2">
                                <i class="fas fa-chevron-right text-[10px] text-[#eab308]"></i>Daftar Pasar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('artikel.index') }}"
                                class="text-sm text-slate-400 hover:text-[#facc15] transition-colors flex items-center gap-2">
                                <i class="fas fa-chevron-right text-[10px] text-[#eab308]"></i>Berita & Artikel
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-[#eab308] uppercase tracking-widest mb-4">Kontak</h3>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-map-marker-alt text-[#eab308] mt-0.5 w-4 text-center"></i>
                            <span>Indramayu, Jawa Barat</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-envelope text-[#eab308] mt-0.5 w-4 text-center"></i>
                            <span>info@pasardesa.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between gap-2">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Pasar Desa Indramayu. Hak Cipta
                    Dilindungi.</p>
                <p class="text-xs text-slate-600">Membangun ekonomi lokal bersama.</p>
            </div>
        </div>
    </footer>

    {{-- ============================================
         FLOATING BOTTOM NAVIGATION (Mobile Only)
         ============================================ --}}
    <nav class="md:hidden bottom-nav" aria-label="Navigasi Bawah">
        <a href="{{ route('pasar.index') }}"
            class="bottom-nav-item {{ request()->routeIs('pasar.index') ? 'active' : '' }}" aria-label="Beranda">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('pasar.list') }}"
            class="bottom-nav-item {{ request()->routeIs('pasar.list') ? 'active' : '' }}" aria-label="Pasar">
            <i class="fas fa-store"></i>
            <span>Pasar</span>
        </a>
        <a href="{{ route('artikel.index') }}"
            class="bottom-nav-item {{ request()->routeIs('artikel.*') ? 'active' : '' }}" aria-label="Artikel">
            <i class="fas fa-newspaper"></i>
            <span>Artikel</span>
        </a>
    </nav>

    {{-- Mobile Hamburger Script --}}
    <script>
        (function() {
            const btn = document.getElementById('mobile-menu-btn');
            const drawer = document.getElementById('mobile-drawer');
            const icon = document.getElementById('menu-icon');

            if (btn && drawer) {
                btn.addEventListener('click', function() {
                    const isOpen = !drawer.classList.contains('hidden');
                    drawer.classList.toggle('hidden');
                    btn.setAttribute('aria-expanded', !isOpen);
                    icon.className = isOpen ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
                });
            }
        })();
    </script>

    @yield('scripts')
</body>

</html>
