# Restrukturisasi Controller PHP MVC

## Perubahan yang Dilakukan

Proyek ini telah melakukan restrukturisasi controller dengan memindahkan fungsionalitas dari AdminController dan UserController ke controller yang lebih spesifik berdasarkan fitur:

1. **DashboardController** - Menangani dashboard untuk admin dan user biasa dengan satu controller, menggunakan flag isAdmin untuk membedakan tampilan.

2. **ProfileController** - Menangani profil pengguna untuk semua jenis user, termasuk update profil via AJAX.

3. **PengaturanController** - Menangani pengaturan website yang sebelumnya ada di AdminController, termasuk pengaturan umum dan upload logo/favicon.

## Pemetaan URL Lama ke URL Baru

| URL Lama | URL Baru |
|----------|----------|
| /admin/dashboard | /dashboard |
| /user/dashboard | /dashboard |
| /admin/profil | /profile |
| /user/profil | /profile |
| /admin/pengaturan | /pengaturan |

## Perubahan yang Telah Dilakukan

1. ✅ Membuat tiga controller baru yang lebih spesifik berdasarkan fitur
2. ✅ Memperbarui semua referensi URL di view dan controller lain
3. ✅ Memperbarui metode AJAX di file view untuk mengarah ke endpoint baru
4. ✅ Menghapus controller lama (AdminController.php dan UserController.php) setelah memastikan semua fungsionalitas sudah dipindahkan

## Mengapa Restrukturisasi Ini Dilakukan

1. **Single Responsibility Principle** - Setiap controller sekarang memiliki tanggung jawab yang lebih spesifik dan terfokus pada fitur tertentu.
2. **Clean URLs** - URL menjadi lebih pendek dan lebih mudah dipahami (/dashboard vs /admin/dashboard atau /user/dashboard).
3. **Pemeliharaan yang Lebih Mudah** - Kode menjadi lebih mudah dipelihara karena lebih terorganisir berdasarkan fitur.
4. **Mengurangi Duplikasi** - Menghilangkan duplikasi kode antara AdminController dan UserController.

## Catatan untuk Pengembangan Lebih Lanjut

- Flag `isAdmin` digunakan di controller untuk membedakan tampilan dan akses berdasarkan peran pengguna.
- Perhatikan bahwa beberapa endpoint khusus admin (seperti pengaturan website) masih memiliki pengecekan peran di constructor.
- Pastikan untuk selalu memperbarui pemetaan URL ini jika ada penambahan fitur baru. 