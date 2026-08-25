Product Requirements Document (PRD): CMS Situs Sekolah
Versi: 1.0
Tanggal: 2026-08-25
Status: Draft
Platform: Web (www.sitesaya.com)

1. Latar Belakang & Tujuan
Sekolah memiliki kebutuhan untuk mengelola konten digital secara profesional dan informatif, mencakup kegiatan sekolah, berita pendidikan, dan artikel sains. CMS ini akan menjadi gerbang informasi publik (www.sitesaya.com) yang terpisah dari aplikasi internal seperti HRMS (hrms.sitesaya.com) dan Absensi (absen.sitesaya.com), sehingga memungkinkan pengembangan dan deployment yang independen. Tujuannya adalah menyediakan platform yang mudah dikelola oleh tim non-teknis (guru/staf) namun tetap memberikan fleksibilitas dan kontrol penuh bagi tim pengembang.

2. Tujuan Utama (Objectives)
Kemudahan Pengelolaan Konten: Editor dapat membuat, mengedit, dan mempublikasikan artikel tanpa pengetahuan teknis.

Kecepatan & Performa: Menggunakan tumpukan teknologi modern (Svelte + Inertia) untuk menghasilkan antarmuka yang reaktif dan cepat.

Professional & Modern: Memanfaatkan komponen antarmuka dari shadcn-svelte untuk mencapai desain yang bersih, konsisten, dan modern.

Skalabilitas & Kustomisasi: Arsitektur yang memungkinkan penambahan fitur di masa depan dengan mudah.

Independensi: Berjalan sebagai aplikasi terpisah di domain utama (www) untuk memastikan deployment tidak mengganggu aplikasi yang sudah berjalan (HRMS/Absensi).

3. Tumpukan Teknologi (Tech Stack)
Tumpukan teknologi ini dipilih berdasarkan kesiapan resmi dan dokumentasi dari Laravel .

Backend: PHP 8.3/8.4+ dan Framework Laravel 13.x. Laravel 13 membutuhkan PHP 8.3 sebagai minimum .

Frontend:

Framework/Compiler: Svelte 5 (menggunakan rune untuk reaktivitas) dan TypeScript .

Integrasi: Inertia.js v2 untuk menghubungkan rute backend Laravel dengan komponen frontend tanpa membangun SPA yang kompleks .

UI Kit & Styling: shadcn-svelte dan Tailwind CSS 4 .

Database: MySQL.

Autentikasi: Laravel Fortify .

4. Fitur Utama (Core Features)
4.1. Manajemen Konten
Post (Artikel):

CRUD (Create, Read, Update, Delete): Membuat, melihat, mengedit, dan menghapus artikel.

Konten Kaya: Menggunakan editor WYSIWYG (seperti TipTap) untuk menulis dan memformat konten.

Metadata: Judul, slug (URL), konten, gambar unggulan, ringkasan (excerpt).

Status: Draft, Publikasi, Arsip.

Penjadwalan: Kemampuan untuk menjadwalkan publikasi di masa depan.

Kategori & Tag:

Membuat dan mengelola hierarki kategori (misalnya, "Berita", "Pendidikan", "Sains").

Memberi tag pada artikel untuk navigasi yang lebih baik.

Media Library:

Unggah, kelola, dan sisipkan gambar/berkas ke dalam artikel.

4.2. Manajemen Pengguna
Sistem Autentikasi: Login dan registrasi standar yang disediakan oleh Laravel Fortify .

Peran (Roles): Dukungan untuk peran dasar, misalnya:

Administrator: Akses penuh ke semua fitur.

Editor (Staf/Guru): Dapat membuat dan mengelola artikelnya sendiri.

4.3. Frontend (Situs Publik)
Halaman Depan (Homepage): Menampilkan daftar artikel terbaru dengan gambar unggulan, judul, dan ringkasan.

Arsip & Filter: Halaman daftar semua artikel dengan kemampuan filter berdasarkan kategori/tag dan pagination.

Halaman Detail Artikel: Menampilkan konten artikel lengkap, informasi penulis, dan tanggal publikasi.

Halaman Statis: Kemampuan untuk membuat halaman statis (misalnya, "Tentang Kami", "Kontak") .

Kepala Sekolah / Profil Sekolah: Fitur untuk menampilkan profil sekolah, visi-misi, dan sambutan kepala sekolah.

4.4. Administrasi (Admin Panel)
Dashboard: Ringkasan statistik seperti jumlah artikel, kategori, dan aktivitas terbaru.

Antarmuka yang Bersih: Dibangun menggunakan komponen shadcn-svelte, dengan layout admin yang terpisah (sidebar atau header) dan pilihan varian layout yang elegan .

5. Arsitektur & Integrasi
5.1. Struktur Proyek Multi-Aplikasi
Mengingat aplikasi HRMS sudah berjalan di hrms.sitesaya.com, CMS akan dibangun sebagai aplikasi terpisah dalam proyek yang sama atau repositori terpisah untuk domain utama (www.sitesaya.com). Pendekatan monorepo dapat digunakan untuk berbagi paket umum, tetapi setiap aplikasi dapat di-deploy secara independen.

5.2. Isolasi Database & Sesuai Kebutuhan
CMS akan menggunakan database MySQL yang terpisah dari database HRMS/Absensi. Hal ini memastikan bahwa perubahan pada struktur database CMS tidak mempengaruhi aplikasi lain yang sudah berjalan di produksi .

5.3. Struktur Kode
Aplikasi akan mengikuti standar Starter Kit Laravel, dengan frontend terkonsentrasi di resources/js/.

resources/js/Pages/ menyimpan halaman-halaman Inertia.

resources/js/components/ui/ menyimpan komponen-komponen dari shadcn-svelte .

6. Pengembangan & Deployment
6.1. Fondasi Proyek
Proyek akan dimulai dengan Laravel Svelte Starter Kit resmi yang menyediakan konfigurasi dasar dan autentikasi siap pakai untuk Laravel 13 .

bash
laravel new nama-proyek-cms --using=oseughu/svelte-starter-kit
atau menggunakan perintah setup langsung .

6.2. Lingkungan Pengembangan
Lokal: Laravel Sail atau lingkungan pengembangan langsung.

Staging: Server terpisah (misal, staging.sitesaya.com) untuk pengujian.

Produksi: Server yang sama dengan aplikasi lain, tetapi dikonfigurasi sebagai Virtual Host terpisah untuk www.sitesaya.com.

6.3. Strategi Deployment
Deployment Independen: CMS dapat di-deploy (menggunakan Git, SSH, atau CI/CD) tanpa mempengaruhi layanan di subdomain lain.

Manajemen Dependensi:

composer install --no-dev untuk menginstal dependensi backend.

npm ci && npm run build untuk membangun aset frontend (Svelte, Tailwind) untuk produksi.

6.4. Server
Web Server: Nginx.

PHP: PHP 8.4.

Database: MySQL.

Penggunaan Docker direkomendasikan untuk konsistensi lingkungan, tetapi tidak diwajibkan.

7. Fitur & Rencana Pengembangan Masa Depan (Future Scope)
SEO (Search Engine Optimization): Setelah fitur inti stabil, tambahkan kemampuan untuk mengelola Meta Title, Meta Description, dan Sitemap otomatis.

AI (Artificial Intelligence): Memanfaatkan Laravel AI SDK untuk fitur seperti pembuatan konten otomatis atau pencarian semantik .

Integrasi SSO: Opsi untuk mengintegrasikan dengan sistem SSO sekolah, memanfaatkan WorkOS atau provider lain .

Dukungan Multi-Bahasa: Jika sekolah memiliki kebutuhan untuk konten bilingual.

Sistem Komentar/Saran: Untuk interaksi dengan pembaca.

8. Timeline Perkiraan
Setup & Foundation (Minggu 1):

Setup proyek menggunakan Laravel Svelte Starter Kit.

Konfigurasi database dan koneksi ke server.

Setup struktur folder dan Git.

Manajemen Konten (Minggu 2-3):

Membuat model, migration, dan controller untuk Post, Category, Tag.

Membangun halaman admin untuk CRUD artikel.

Implementasi media upload.

Frontend Publik (Minggu 4):

Membangun halaman depan, arsip, dan detail artikel.

Implementasi desain menggunakan shadcn-svelte dan Tailwind.

Autentikasi & Admin (Minggu 5):

Integrasi sistem login untuk editor/admin.

Pengembangan dashboard admin.

Pengujian & Deployment (Minggu 6):

Pengujian internal dan perbaikan bug.

Deployment ke server produksi di www.sitesaya.com.

Kesimpulan
PRD ini memberikan cetak biru yang jelas untuk pengembangan CMS profesional menggunakan tumpukan teknologi canggih dan teruji (Laravel 13, Svelte 5, Inertia, shadcn-svelte). Dengan memanfaatkan Starter Kit resmi, tim pengembangan dapat fokus pada logika bisnis dan fitur unik, yang pada akhirnya menghasilkan CMS yang cepat, modern, mudah dikelola, dan terintegrasi mulus dengan infrastruktur yang ada.


