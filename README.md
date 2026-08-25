# Svelte CMS

[![tests](https://github.com/mustofa-d4f/svelte-cms/actions/workflows/tests.yml/badge.svg)](https://github.com/mustofa-d4f/svelte-cms/actions/workflows/tests.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

CMS (Content Management System) untuk situs sekolah, dibangun dengan Laravel 13, Svelte 5, dan Inertia.js v3.

## Fitur

### Manajemen Konten
- Artikel (Post) dengan editor WYSIWYG (TipTap)
- Kategori dan Tag untuk pengelompokan
- Media Library untuk mengelola gambar
- Status publikasi: Draft, Published, Archived

### Admin Panel
- Dashboard dengan statistik
- CRUD Artikel, Kategori, Tag
- Manajemen Media

### Autentikasi
- Login & Register (Laravel Fortify)
- Passkeys & Two-Factor Authentication
- Role-based access (Admin, Editor) dengan Spatie Permission

### Frontend Publik
- Homepage dengan daftar artikel terbaru
- Arsip dengan filter kategori/tag
- Detail artikel
- Halaman statis

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 13, PHP 8.3 |
| Frontend | Svelte 5, Inertia.js v3 |
| UI Kit | shadcn-svelte, bits-ui |
| Styling | Tailwind CSS 4 |
| Database | MySQL |
| Editor | TipTap |
| Auth | Laravel Fortify |
| Permissions | Spatie Laravel Permission |

## Instalasi

### Prasyarat
- PHP 8.3+
- Composer
- Node.js 18+
- MySQL

### Setup

```bash
# Clone repo
git clone https://github.com/mustofa-d4f/svelte-cms.git
cd svelte-cms

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database migration
php artisan migrate

# Build frontend
npm run build

# Jalankan dev server
composer dev
```

## Struktur Projek

```
app/
├── Actions/          # Business logic
├── Http/
│   ├── Controllers/
│   │   ├── Admin/    # Admin controllers
│   │   └── Settings/
│   ├── Middleware/
│   └── Requests/     # Form requests
├── Models/           # Eloquent models
└── Providers/

resources/js/
├── pages/
│   ├── admin/        # Admin pages
│   ├── auth/         # Auth pages
│   ├── public/       # Public pages
│   └── settings/     # Settings pages
├── components/       # Svelte components
├── layouts/          # Layout components
└── lib/              # Utilities
```

## Contributing

Kontribusi sangat dipertimbangkan! Berikut cara berkontribusi:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buka Pull Request

## License

MIT License - lihat [LICENSE](LICENSE) untuk detail.
