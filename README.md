# SISNEKAS - Sistem Informasi Akademik Sekolah

## Tentang Aplikasi
SISNEKAS adalah sistem informasi akademik sekolah yang dibangun menggunakan Laravel 12 dan Filament 3. Aplikasi ini dirancang untuk memudahkan pengelolaan data akademik sekolah secara efisien dan modern.

## Teknologi yang Digunakan
- PHP ^8.2
- Laravel Framework ^12.0
- Filament Admin Panel ^3.2
- Laravel Sanctum ^4.0
- Database: MySQL/PostgreSQL (via Doctrine DBAL ^4.2)
- IndoRegion Package ^3.0 (untuk data wilayah Indonesia)

## Fitur Utama
- Dashboard Admin dengan Filament
- Manajemen Data Master
- Sistem Autentikasi & Autorisasi
- Pengelolaan Data Wilayah Indonesia
- RESTful API (via Laravel Sanctum)

## Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Git

## Instalasi

1. Clone repository
```bash
git clone https://github.com/dennsoe/sisnekas.git
cd sisnekas
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di file `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sisnekas
DB_USERNAME=root
DB_PASSWORD=
```

5. Jalankan migrasi dan seeder
```bash
php artisan migrate --seed
```

6. Install assets
```bash
npm run build
```

7. Jalankan aplikasi
```bash
php artisan serve
```

## Struktur Folder Utama
```
sisnekas/
├── app/                 # Logic aplikasi
├── config/             # Konfigurasi aplikasi
├── database/           # Migrasi dan seeders
├── public/             # Assets publik
├── resources/          # Views dan assets
├── routes/             # Definisi routes
└── tests/              # Unit/Feature tests
```

## Package yang Digunakan
### Production Dependencies
- laravel/framework: ^12.0
- filament/filament: ^3.2
- azishapidin/indoregion: ^3.0
- doctrine/dbal: ^4.2
- laravel/sanctum: ^4.0
- laravel/tinker: ^2.10.1

### Development Dependencies
- fakerphp/faker: ^1.23
- laravel/pail: ^1.2.2
- laravel/pint: ^1.13
- laravel/sail: ^1.41
- mockery/mockery: ^1.6
- nunomaduro/collision: ^8.6
- phpunit/phpunit: ^11.5.3

## Pengembangan

### Coding Style
Proyek ini menggunakan Laravel Pint untuk standarisasi kode. Jalankan:
```bash
./vendor/bin/pint
```

### Testing
Jalankan test dengan:
```bash
php artisan test
```

### Development Server
```bash
php artisan serve
npm run dev
```

## Kontribusi
1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Keamanan
Jika Anda menemukan masalah keamanan, silakan kirim email ke [email Anda].

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Kontak
Nama Anda - [@social_media](https://twitter.com/yourusername)
Link Proyek: [https://github.com/dennsoe/sisnekas](https://github.com/dennsoe/sisnekas)
