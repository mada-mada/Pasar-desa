# Eksekusi Upgrade UI/UX Frontend

- [ ] Konfigurasi TailwindCSS dengan Vite
  - [ ] Jalankan `npm install -D tailwindcss postcss autoprefixer`
  - [ ] Buat file `tailwind.config.js` / `postcss.config.js`
  - [ ] Set up `resources/css/app.css` dan masukkan `@tailwind` directives.
- [ ] Ubah View Utama (Layout & Index Frontend)
  - [ ] Update `resources/views/layouts/user.blade.php` untuk memanggil `@vite('resources/css/app.css')`.
  - [ ] Implementasikan Floating Bottom Bar untuk mobile dan hapus script cdn.
  - [ ] Rombak halaman `resources/views/user/pasar/index.blade.php` sesuai rencana arsitektur (Tanpa quick bubbles).
- [ ] Penyesuaian Custom CSS (`resources/css/app.css`)
  - [ ] Tambahkan utility class bawaan seperti `.tactile-click`, efek card khusus, font Outfit.
- [ ] Build & Verifikasi
  - [ ] Jalankan `npm run build` dan amati UI di local.
