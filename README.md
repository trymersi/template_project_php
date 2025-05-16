# Template Project PHP MVC

Sistem PHP sederhana menggunakan arsitektur MVC dengan fitur:
- PHP 8
- MySQL
- Bootstrap 5
- Sistem login (admin dan user)
- Proteksi CSRF
- Modul CRUD produk
- DataTables dengan server-side processing
- Dashboard dengan statistik

## Struktur Folder
```
├── app/
│   ├── config/         - Konfigurasi aplikasi
│   ├── controllers/    - Controller aplikasi
│   ├── core/           - Core framework
│   ├── helpers/        - Helper functions
│   ├── models/         - Model aplikasi
│   └── views/          - View aplikasi
├── assets/             - File statis (CSS, JS, images)
├── vendor/             - Library eksternal
├── .htaccess           - Konfigurasi URL rewriting
├── index.php           - Entry point aplikasi
└── README.md           - Dokumentasi
```

## Instalasi
1. Clone repository ini
2. Import database dari file `database.sql`
3. Konfigurasi database di `app/config/config.php`
4. Akses aplikasi via browser

## Akun Default
- Admin: admin@admin.com / password
- User: user@user.com / password 