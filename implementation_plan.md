# Rancangan Upgrade UI/UX: Pasar Desa (Target 15-40 Tahun)

Berdasarkan framework `@frontend-design`, rancangan antarmuka ini tidak akan menggunakan desain *template* biasa. Target audiens usia 15-40 tahun sangat terbiasa dengan aplikasi *ride-hailing* (Gojek/Grab) dan e-commerce modern yang cepat, berbasis *card*, dan memiliki hierarki visual tinggi.

## 1. Design Direction Summary
* **Aesthetic Name:** **"Elevated Neo-Utilitarian"** dipadukan dengan sentuhan **Glassmorphism**.
* **DFII Score:** 13/15 (Excellent). 
* **Key Inspiration:** Aplikasi penjelajahan hiper-lokal modern.

## 2. Design System Snapshot
### Typography
* **Display Font:** `Outfit` (Super Bold 800/900) dengan *tracking-tight* untuk *hero section* dan judul.
* **Body Font:** `Outfit` (Regular/Medium) untuk keterbacaan yang tinggi pada deskripsi.

### Color Story
* **Dominan:** Jet Black (`#0f172a`) dan Pristine White (`#fafafa`).
* **Aksen Utama (Hyper Gold):** Kuning emas yang sedikit lebih neon / terang (`#FACC15` atau `#EAB308`).
* **Secondary Accent:** Electric Blue (`#2563EB`) khusus untuk interaksi.

### Spatial Composition & Layout
* **Mobile-First Floating Bar:** Menggunakan **Floating Navigation Bottom Bar** khas aplikasi iOS/Android untuk akses pencarian dan menu saat scrolling di layar mobile.
* **Card Scannability:** Bayangan lembut (*soft drop shadow*) dan gambar berukuran penuh di bagian atas card dengan *fade-out gradient* ke badan card.

### Motion Philosophy
* **Tactile & Snappy:** Cepat dan responsif.
* Animasi *scale-down* (`transform: scale(0.98)`) saat *card* ditekan.

## 3. Strategi Implementasi (Perubahan File)

### Komponen Utama

#### [MODIFY] `resources/views/layouts/user.blade.php`
- Menghapus CDN Tailwind dan beralih ke kompilasi Vite (`@vite(['resources/css/app.css', 'resources/js/app.js'])`).
- Mengubah struktur navbar menjadi *Sticky Glass Header* di Desktop, dan *Floating Action Bar* di bawah layar untuk Mobile.

#### [MODIFY] `resources/views/user/pasar/index.blade.php`
- **Hero Section:** Merombak *hero* menjadi tipografi raksasa "Temukan Pasarmu" dengan form pencarian membulat raksasa (mirip *Spotlight Search*).
- *Catatan: Fitur Quick Filter Bubbles ditunda implementasinya berdasarkan masukan.*
- **Grid Pasar:** Mengganti grid konvensional menjadi desain yang lebih dinamis. Peta sebagai *floating toggle* "Lihat Peta" di sudut layar untuk Mobile, atau integrasi rapi di Desktop.

#### [MODIFY] `public/css/user.css` / `resources/css/app.css`
- Menerapkan pilar *CSS Variables* untuk gaya dan animasi spesifik seperti `.tactile-click`, `.shimmer-pulse`, dan `.glass-bottom-bar`. Instalasi Tailwind via NPM.

## 4. Status
**Disetujui.** Migrasi ke Vite dijalankan, Bottom Bar diimplementasikan, fitur Quick Filter Bubbles diabaikan untuk fase ini.
