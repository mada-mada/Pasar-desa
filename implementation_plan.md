# Redesign UI/UX Portal Pasar Desa — Persona-Driven

Rancangan perubahan menyeluruh terhadap tampilan UI/UX portal **Pasar Desa Indramayu** berdasarkan 4 user persona: Teh Nengsih (Ibu RT), Pak Budi (Pengepul), Rina (Food Vlogger), dan Gilang (Mahasiswa Riset Desktop).

---

## User Review Required

> [!IMPORTANT]
> Redesign ini tetap menggunakan stack Laravel Blade + Vite + Tailwind CSS v4 + Outfit font yang sudah ada. **Tidak ada perubahan backend/database**. Semua perubahan murni di frontend (views, CSS, JS).

> [!WARNING]
> Beberapa perubahan cukup signifikan (layout homepage, card design, map interaction). Mohon review setiap komponen di bawah sebelum saya mulai implementasi.

---

## Analisis Gap: Persona vs UI Saat Ini

### Masalah Yang Ditemukan

| Persona | Pain Point | Gap di UI Saat Ini |
|---------|-----------|-------------------|
| **Teh Nengsih** (Pemula, Mobile) | Cari jadwal pasaran, peta lokasi, cek fasilitas | ❌ Jadwal pasaran hanya di badge card kecil, sulit di-scan. ❌ Tidak ada filter hari pasaran. ❌ Fasilitas hanya terlihat di halaman detail |
| **Pak Budi** (Menengah, Mobile) | Cari pasar yang BUKA HARI INI, rute antar desa | ❌ Tidak ada indikator "Buka Hari Ini" yang menonjol. ❌ Search bar berfungsi tapi jadwal pasaran tidak di-highlight di homepage |
| **Rina** (Tinggi, Mobile) | Visual menarik, foto pasar, artikel interaktif, peta akurat | ⚠️ Design sudah lumayan tapi masih "safe". ❌ Foto artikel tidak optimal di mobile. ❌ Peta tidak bisa diklik langsung dari card |
| **Gilang** (Sangat Tinggi, Desktop) | Dashboard padat, peta fullscreen, banyak data sekali lihat | ❌ Desktop hanya versi "melar" dari mobile. ❌ Grid 3-kolom tidak memanfaatkan layar lebar. ❌ Peta 380px terlalu kecil untuk riset |

---

## Design Direction

**Nama Estetika:** *Warm Civic Pragmatism* — perpaduan antara kehangatan visual (untuk Teh Nengsih & Rina) dengan utilitas data-dense (untuk Pak Budi & Gilang). Tetap menggunakan palet Jet Black + Gold + Electric Blue yang sudah ada.

**DFII Score:** 12/15 (Excellent)
- Aesthetic Impact: 4/5 — warm, distinctive, non-generic
- Context Fit: 5/5 — civic information portal for diverse users
- Implementation Feasibility: 4/5 — pure CSS/Blade, no new dependencies
- Performance Safety: 4/5 — progressive enhancement
- Consistency Risk: -1 — manageable with existing design system

---

## Proposed Changes

### Komponen 1: Homepage (`index.blade.php` & `user/pasar/index.blade.php`)

---

#### [MODIFY] [index.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/index.blade.php) — *Redirect/merged*

> [!NOTE]
> File `index.blade.php` di root views dan `user/pasar/index.blade.php` memiliki konten yang sama. Perubahan akan difokuskan di `user/pasar/index.blade.php` sebagai source-of-truth.

#### [MODIFY] [index.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/user/pasar/index.blade.php) — *Homepage Utama*

**Perubahan untuk semua persona:**

1. **"Pasar Buka Hari Ini" Quick-Access Strip** *(Teh Nengsih & Pak Budi)*
   - Tambah horizontal scrollable chip/pill row setelah search bar
   - Menampilkan filter hari operasional: `Hari Ini`, `Senin`, `Selasa`, `Rabu`, `Kamis`, `Jumat`, `Sabtu`, `Minggu`
   - Chip "Hari Ini" di-highlight otomatis dengan warna gold (match via `Carbon::now()->translatedFormat('l')`)
   - Klik chip langsung filter daftar pasar di bawah via query param `?hari=Senin`

2. **Enhanced Pasar Card** *(Semua persona)*
   - Tambah **indikator status "BUKA HARI INI"** berupa dot hijau + teks di badge kartu
   - Badge hari pasaran diperbesar dan diberi warna kontras lebih tinggi
   - Jam operasional ditampilkan lebih menonjol
   - Fasilitas count di footer diberi icon yang lebih besar dan clickable
   - **Quick-action**: Tombol "Rute" kecil langsung buka Google Maps *(Pak Budi)*

3. **Map Section Enhancement** *(Semua persona)*
   - Desktop: Peta diperbesar dari 380px → **500px**
   - Desktop: Tambah panel sidebar kecil di kiri peta (overlay) menampilkan list pasar yang bisa diklik untuk zoom
   - Mobile: Peta tetap collapsible via FAB, tapi FAB lebih menarik dengan label "Lihat Peta 🗺️"
   - Marker popup ditambah tombol "Rute" *(Pak Budi)*

4. **Desktop-Specific: Data-Dense Layout** *(Gilang)*
   - Grid di desktop naik dari 3 kolom → **4 kolom** di layar ≥1280px
   - Tambah komponen **"Quick Stats Dashboard"** setelah hero di desktop: card berisi total pasar, jumlah kecamatan, pasar buka hari ini
   - Peta dan daftar pasar bisa ditampilkan **side-by-side** di desktop ≥1440px

5. **Hero Section Polish** *(Rina)*
   - Tambah subtle animated gradient noise overlay di hero untuk visual premium
   - Micro-animation pada search bar focus: glow effect diperkuat
   - Quick stats dipoles: animasi counter saat scroll masuk viewport

---

### Komponen 2: Daftar Pasar (`user/pasar/list.blade.php`)

#### [MODIFY] [list.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/user/pasar/list.blade.php)

1. **Filter Sidebar/Horizontal Bar**
   - Desktop: Sidebar filter sticky di kiri (hari pasaran, kecamatan)
   - Mobile: Horizontal scrollable filter pills
   
2. **View Toggle** *(Gilang)*
   - Tambah toggle button: **Grid View** vs **Table/List View**
   - Table view menampilkan data padat: nama, hari pasaran, jam, alamat, fasilitas count — cocok untuk riset

3. **Sort Options**
   - Sort by: Nama A-Z, Hari Operasional, Jumlah Fasilitas

---

### Komponen 3: Detail Pasar (`user/pasar/show.blade.php`)

#### [MODIFY] [show.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/user/pasar/show.blade.php)

1. **Design Consistency** — Sesuaikan dengan design system (saat ini masih menggunakan warna `blue-deep` dan gaya lama)
   - Ganti header dari `bg-blue-deep` → hero gradient yang konsisten
   - Card styling sesuaikan ke `pasar-card` design system
   
2. **Fasilitas Section Enhancement** *(Teh Nengsih)*
   - Tampilkan fasilitas menggunakan visual icon grid yang lebih besar dan berwarna
   - Status "Tersedia" / "Rusak" / "Tidak Ada" dengan warna lebih kontras
   
3. **Peta Improved** *(Pak Budi)*
   - Tombol "Petunjuk Arah" dibuat lebih menonjol dan sticky di mobile
   - Tambah info "Buka hari ini?" secara prominent

4. **Share & Copy Link** *(Rina)*
   - Share buttons yang fungsional (WhatsApp, copy link)
   - Schema markup untuk SEO

---

### Komponen 4: Artikel Pages (`user/artikel/index.blade.php` & `show.blade.php`)

#### [MODIFY] [index.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/user/artikel/index.blade.php)

1. **Bug Fix:** Artikel card menggunakan `$featured->gambar_sampul` alih-alih `$art->gambar_sampul` — setiap card menampilkan gambar artikel yang salah
2. Perbaiki image height consistency
3. Tambah search bar untuk artikel *(Rina, Gilang)*

#### [MODIFY] [show.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/user/artikel/show.blade.php)

1. **Design Consistency** — Sesuaikan dengan design system
2. **Reading Experience** *(Rina & Gilang)*
   - Typography yang lebih baik untuk konten artikel panjang
   - Estimasi waktu baca
   - Table of contents untuk artikel panjang di desktop
3. Share buttons yang fungsional

---

### Komponen 5: Layout & Design System (`layouts/user.blade.php` & `app.css`)

#### [MODIFY] [user.blade.php](file:///c:/pasar_desa%20-%20Copy/resources/views/layouts/user.blade.php)

1. **Bottom Nav Enhancement** *(Mobile)*
   - Tambah item ke-4: "Peta" dengan icon map — langsung buka halaman peta fullscreen
   - Active state animation yang lebih halus

2. **Desktop Navigation**
   - Tambah sticky breadcrumb/context bar di bawah navbar utama saat user ada di inner pages

3. **Meta Tags & SEO**
   - Open Graph meta tags untuk setiap halaman
   - Description meta yang dinamis

#### [MODIFY] [app.css](file:///c:/pasar_desa%20-%20Copy/resources/css/app.css)

1. **New CSS Components:**
   - `.status-badge-open` — badge hijau "Buka Hari Ini"
   - `.status-badge-closed` — badge abu-abu "Tutup"
   - `.filter-chip` / `.filter-chip--active` — filter pill buttons
   - `.quick-stat-card` — stat card di dashboard strip
   - `.view-toggle` — grid/list toggle buttons
   - `.table-view` — table/list view styling
   - `.data-dense-grid` — 4-column grid khusus desktop
   
2. **Enhanced Responsive Breakpoints:**
   - `@media (min-width: 1280px)` → 4-column grid
   - `@media (min-width: 1440px)` → side-by-side map+list layout

3. **New Animations:**
   - Counter animation (JS-driven) untuk stats
   - Smooth chip/filter transition
   - Entrance animations yang lebih varied (stagger per card)

---

## Prioritas Implementasi

| Prioritas | Fitur | Persona Target | Effort |
|-----------|-------|----------------|--------|
| 🔴 P0 | Indikator "Buka Hari Ini" di card & badge | Teh Nengsih, Pak Budi | Medium |
| 🔴 P0 | Filter hari pasaran (chip pills) | Pak Budi, Teh Nengsih | Medium |
| 🔴 P0 | Bug fix gambar artikel salah | Rina | Low |
| 🟡 P1 | Desktop 4-column grid & data-dense layout | Gilang | Medium |
| 🟡 P1 | Peta diperbesar + tombol Rute | Pak Budi | Medium |
| 🟡 P1 | Design consistency (show.blade.php halaman) | Semua | High |
| 🟢 P2 | Quick Stats Dashboard strip (desktop) | Gilang | Medium |
| 🟢 P2 | View toggle (Grid/List) di daftar pasar | Gilang | Medium |
| 🟢 P2 | Artikel search + reading time | Rina, Gilang | Low |
| 🟢 P2 | Hero visual polish (noise, animations) | Rina | Low |
| ⚪ P3 | Share buttons fungsional | Rina | Low |
| ⚪ P3 | SEO meta tags | Semua | Low |
| ⚪ P3 | Bottom nav 4th item (Peta) | Mobile users | Low |

---

## Open Questions

> [!NOTE]
> **1. ~~Format hari pasaran~~ — TERJAWAB:** Hari pasaran = hari operasional biasa (Senin–Minggu). Logika "Buka Hari Ini" cukup match `Carbon::now()->translatedFormat('l')` dengan kolom `hari_pasaran` di database.

> [!IMPORTANT]
> **2. Scope prioritas**: Apakah Anda ingin saya implementasikan **semua** perubahan (P0–P3) atau mulai dari P0 dulu kemudian iterasi?

> [!NOTE]
> **3. Apakah ada endpoint API baru yang perlu dibuat untuk filter hari pasaran?** Atau filter cukup dilakukan via query parameter pada route yang sudah ada (`?hari=Legi`)?

---

## Verification Plan

### Automated Tests
- Build assets: `npm run build` — memastikan CSS/JS tidak ada error
- Dev server: `npm run dev` untuk hot-reload testing

### Manual/Browser Verification
- **Mobile viewport (375px)**: Test scrolling, touch target size ≥44px, bottom nav, map toggle
- **Tablet viewport (768px)**: Test 2-column grid, search bar
- **Desktop viewport (1280px)**: Test 4-column grid, data-dense layout
- **Desktop viewport (1440px+)**: Test side-by-side map+list
- **Cross-persona walkthrough**: Simulasi task flow setiap persona di browser
