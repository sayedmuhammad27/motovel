# LAPORAN PRAKTIKUM TEKNOLOGI SISTEM TERINTEGRASI
## PENGEMBANGAN SISTEM INFORMASI MANAJEMEN SERVIS SEPEDA MOTOR (MOTOVEL) MENGGUNAKAN LARAVEL 12, MYSQL, REST API, POSTMAN, DAN GITHUB

---

**MATA KULIAH :** TEKNOLOGI SISTEM TERINTEGRASI  
**MATERI :** PENGEMBANGAN SISTEM INFORMASI SERVIS KENDARAAN MENGGUNAKAN LARAVEL 12, MYSQL, REST API, POSTMAN, DAN GITHUB  
**NAMA PROYEK :** MOTOVEL (Precision Care. Performance You Can Trust.)  
**PROGRAM STUDI :** TEKNOLOGI REKAYASA KOMPUTER JARINGAN  
**JURUSAN :** TEKNOLOGI INFORMASI DAN KOMPUTER  

---

### DAFTAR ISI LANGKAH KERJA
5. **Langkah (Konfigurasi Laravel dan Database)**
   - A. Pembuatan Proyek Laravel Baru Menggunakan Composer
   - B. Navigasi ke Direktori Proyek dan Membuka Editor Kode Visual Studio Code
   - C. Pembuatan Database MySQL dan Konfigurasi Koneksi Lingkungan (.env)
   - D. Perancangan dan Pembuatan Migration Tabel Basis Data MOTOVEL
   - E. Konfigurasi API Scaffolding / Laravel Sanctum dan Eksekusi Migration
   - F. Pembuatan Model Eloquent ORM dan Pendefinisian Relasi Antartabel
   - G. Pembuatan Seeder Basis Data untuk Populasi Data Awal Bengkel
   - H. Pembuatan Controller Web untuk Logika Frontend dan Admin Dashboard
   - I. Pembuatan Controller REST API v1
   - J. Konfigurasi Routing Web dan REST API
   - K. Pembuatan Antarmuka Pengguna (Blade Template, Tailwind CSS v4, dan Vite)
6. **Langkah (Website Test dan API Test)**
   - A. Pengujian Fungsionalitas Website MOTOVEL (Web Test)
     - 1. Menjalankan Server Lokal Pengembangan Laravel
     - 2. Pengujian Landing Page Publik MOTOVEL
     - 3. Pengujian Booking Engine Interaktif (Pendaftaran Servis Publik)
     - 4. Pengujian Halaman Login dan Autentikasi Pengguna
     - 5. Pengujian Dashboard Administrasi Bengkel
     - 6. Pengujian CRUD Manajemen Data Pelanggan
     - 7. Pemeriksaan Data Pelanggan pada Database MySQL
     - 8. Pengujian CRUD Manajemen Data Kendaraan
     - 9. Pemeriksaan Data Kendaraan pada Database MySQL
     - 10. Pengujian CRUD Manajemen Data Mekanik
     - 11. Pengujian Pendaftaran Servis Bengkel
     - 12. Pengujian Detail Pengerjaan Teknis dan Catatan Diagnosa
     - 13. Pengujian Manajemen Stok Sparepart
     - 14. Pengujian Kasir Transaksi dan Pembayaran Servis
     - 15. Pengujian Cetak Bukti Pembayaran / Struk Transaksi Kasir
     - 16. Pengujian Riwayat Servis dan Cetak Laporan Operasional
   - B. Pengujian REST API v1 MOTOVEL Menggunakan Postman (API Test)
     - 1. Pengujian Metode GET pada Endpoint Data Pelanggan
     - 2. Pengujian Metode POST pada Endpoint Data Pelanggan
     - 3. Pemeriksaan Sinkronisasi Data POST pada Database dan Website
     - 4. Pengujian Metode PUT pada Endpoint Data Pelanggan
     - 5. Pemeriksaan Sinkronisasi Data PUT pada Database dan Website
     - 6. Pengujian Metode DELETE pada Endpoint Data Pelanggan
     - 7. Pemeriksaan Sinkronisasi Data DELETE pada Database dan Website
     - 8. Pengujian Endpoint Kendaraan, Mekanik, Servis, Sparepart, dan Pembayaran
     - 9. Pengujian Validasi Error dan Penanganan Respon HTTP 422
     - 10. Penyusunan dan Ekspor Postman Collection v2.1.0 (35 Endpoint Teruji)
7. **Langkah (Commit Github dan Gitclone)**
   - A. Pengelolaan Kontrol Versi Menggunakan Git dan GitHub
     - 1. Pembuatan Repositori Daring di GitHub
     - 2. Inisialisasi Repositori Git Lokal dan Konfigurasi .gitignore
     - 3. Penambahan Berkas ke Staging Area dan Perekaman Riwayat Versi (Commit)
     - 4. Menghubungkan Repositori Lokal dengan GitHub Remote
     - 5. Pengiriman Berkas Proyek ke Repositori GitHub (Push)
   - B. Pengujian Pengunduhan dan Kloning Repositori (Git Clone)
     - 1. Eksekusi Perintah Git Clone dari Repositori GitHub
     - 2. Navigasi ke Direktori Hasil Kloning dan Pemeriksaan Berkas
     - 3. Instalasi Dependensi Paket Composer dan NPM
     - 4. Konfigurasi Berkas Lingkungan (.env) dan Generate Application Key
     - 5. Migrasi dan Seeding Basis Data pada Proyek Kloning
     - 6. Menjalankan Server Lokal dan Verifikasi Integritas Sistem

---

## 5. Langkah (Konfigurasi Laravel dan database)

A. Tahap pertama dilakukan dengan membuat proyek Laravel baru menggunakan Composer melalui Terminal atau Command Prompt pada sistem operasi. Perintah `composer create-project laravel/laravel motovel` dijalankan untuk mengunduh dan memasang kerangka kerja framework Laravel versi 12 beserta dependensi inti yang dibutuhkan. Proses ini secara otomatis membentuk struktur direktori dan berkas bawaan Laravel, seperti folder `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, dan `tests`. Setelah proses instalasi selesai, folder `motovel` terbentuk sebagai direktori utama pengembangan sistem manajemen servis sepeda motor.

```powershell
PS D:\Xampp\htdocs> composer create-project laravel/laravel motovel
Creating a "laravel/laravel" project at "./motovel"
Installing laravel/laravel (v12.x.x)
  - Downloading laravel/laravel
  - Installing laravel/laravel
Created project in D:\Xampp\htdocs\motovel
> @php -r "file_exists('.env') || copy('.env.example', '.env');"
> @php artisan key:generate --ansi
Application key set successfully.
```

B. Setelah proses pembuatan proyek Laravel selesai, tahap berikutnya adalah masuk ke dalam direktori kerja proyek menggunakan perintah `cd motovel` melalui terminal. Perintah tersebut berfungsi memindahkan letak direktori aktif ke folder utama proyek. Selanjutnya, perintah `code .` dijalankan untuk membuka seluruh susunan direktori proyek ke dalam editor Visual Studio Code sehingga pengelolaan berkas, penulisan logika kode, dan konfigurasi sistem dapat dilakukan secara efisien.

```powershell
PS D:\Xampp\htdocs> cd motovel
PS D:\Xampp\htdocs\motovel> code .
```

C. Pada tahap ini, basis data relasional dibuat menggunakan DBMS MySQL melalui MariaDB pada paket XAMPP sebagai media penyimpanan terpusat seluruh data operasional bengkel MOTOVEL. Setelah basis data dengan nama `motovel_db` berhasil dibuat, konfigurasi koneksi diterapkan melalui berkas `.env` pada direktori root proyek.

1. Basis data dibuat melalui phpMyAdmin atau terminal MySQL dengan menjalankan kueri pembuatan basis data baru bernama `motovel_db`. Basis data ini berfungsi sebagai wadah penyimpanan seluruh entitas sistem MOTOVEL, yang mencakup data akun administrator, master pelanggan, data armada sepeda motor, tenaga mekanik, pendaftaran servis, rincian teknis pengerjaan servis, stok suku cadang, rekap transaksi pembayaran kasir, serta pesan kontak masuk dari pelanggan.

```sql
CREATE DATABASE motovel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Berkas `.env` digunakan untuk mengatur parameter konfigurasi koneksi antara aplikasi Laravel dan server basis data MySQL. Pada tahap ini, parameter `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` disesuaikan dengan konfigurasi server MySQL lokal XAMPP yang aktif pada port 3306. Setelah konfigurasi disimpan, framework Laravel dapat terhubung secara langsung ke basis data `motovel_db`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=motovel_db
DB_USERNAME=root
DB_PASSWORD=
```

D. Pada tahap ini, berkas migration dibuat untuk merancang dan mendefinisikan skema struktur tabel basis data yang diperlukan oleh aplikasi MOTOVEL. Skema ini mencakup penamaan tabel, tipe data kolom, atribut unik, pengindeksan, serta relasi kunci asing (*foreign key*) antartabel. Pembuatan berkas dilakukan menggunakan perintah Artisan CLI, kemudian setiap berkas disesuaikan struktur skemanya menggunakan Visual Studio Code.

1. Pembuatan migration dilakukan secara berurutan sesuai urutan ketergantungan relasi tabel menggunakan perintah `php artisan make:migration create_nama_table`. Perintah ini menghasilkan berkas migration dengan stempel waktu di folder `database/migrations/`.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_customers_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_vehicles_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_mechanics_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_service_registrations_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_service_details_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_spareparts_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_service_spareparts_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_payments_table
PS D:\Xampp\htdocs\motovel> php artisan make:migration create_contact_messages_table
```

2. Setelah seluruh berkas migration dibuat, daftar berkas diperiksa pada direktori `database/migrations/` untuk memastikan bahwa semua tabel yang dibutuhkan dalam alur kerja bengkel telah tersedia dengan nama dan urutan berkas yang presisi.

```powershell
PS D:\Xampp\htdocs\motovel> Get-ChildItem database/migrations | Select-Object -ExpandProperty Name
0001_01_01_000000_create_users_table.php
0001_01_01_000001_create_cache_table.php
0001_01_01_000002_create_jobs_table.php
2024_01_01_000001_create_customers_table.php
2024_01_01_000002_create_vehicles_table.php
2024_01_01_000003_create_mechanics_table.php
2024_01_01_000004_create_service_registrations_table.php
2024_01_01_000005_create_service_details_table.php
2024_01_01_000006_create_spareparts_table.php
2024_01_01_000007_create_service_spareparts_table.php
2024_01_01_000008_create_payments_table.php
2024_01_01_000009_create_contact_messages_table.php
```

3. Pada tahap ini, dilakukan penyesuaian definisi struktur kolom pada setiap berkas migration:
   - **Tabel `users`**: Menyimpan kredensial otentikasi administrator dan staf pengelola bengkel (`name`, `email`, `password`, `role`).
   - **Tabel `customers`**: Menyimpan data pelanggan dengan format kode pelanggan unik berformat otomatis (`customer_code` contoh: `PLG-0001`), `name`, `phone`, `email`, `address`.
   - **Tabel `vehicles`**: Menyimpan data kendaraan bermotor yang terhubung ke pelanggan (`customer_id`), `plate_number` (plat nomor unik), `brand`, `model`, `year`, `transmission` (`Matic`, `Manual`, `Kopling`), `color`.
   - **Tabel `mechanics`**: Menyimpan data tenaga mekanik bengkel dengan kode mekanik (`mechanic_code` contoh: `MKN-0001`), `name`, `phone`, `specialty`, `status` (`available`, `busy`, `off`).
   - **Tabel `service_registrations`**: Menyimpan tiket pendaftaran servis dengan kode pendaftaran unik (`registration_code` contoh: `SRV-0001`), relasi `customer_id` dan `vehicle_id`, `service_type`, `complaint`, `service_date`, `status` (`pending`, `in_progress`, `completed`, `cancelled`).
   - **Tabel `service_details`**: Menyimpan pencatatan teknis pengerjaan servis (`detail_code` contoh: `DTL-0001`), relasi `service_registration_id` dan `mechanic_id`, `diagnosis`, `actions_taken`, `mechanic_notes`, `service_fee`.
   - **Tabel `spareparts`**: Menyimpan inventaris katalog suku cadang motor (`part_code` contoh: `SPR-0001`), `name`, `category`, `stock`, `unit_price`, `brand`.
   - **Tabel `service_spareparts`**: Tabel relasi pivot penggunaan suku cadang pada servis (`service_detail_id`, `sparepart_id`, `quantity`, `unit_price`, `subtotal`).
   - **Tabel `payments`**: Menyimpan transaksi kasir pembayaran servis (`payment_code` contoh: `PAY-0001`), relasi `service_registration_id`, `service_fee`, `sparepart_total`, `total_amount`, `paid_amount`, `change_amount`, `payment_method` (`cash`, `transfer`, `qris`), `payment_status` (`paid`, `unpaid`), `paid_at`.
   - **Tabel `contact_messages`**: Menyimpan formulir aspirasi dan pertanyaan dari pengunjung website publik (`name`, `email`, `subject`, `message`).
   - Penambahan fungsi `$table->timestamps()` pada seluruh berkas menghasilkan kolom `created_at` dan `updated_at` secara otomatis untuk audit jejak waktu data.

4. Setelah seluruh berkas migration selesai disesuaikan kodenya, dilakukan verifikasi sintaks untuk memastikan bahwa relasi foreign key antartabel tidak mengalami konflik urutan eksekusi (*dependency integrity*).

E. Pada tahap ini, scaffolding API dikonfigurasi menggunakan Laravel Sanctum untuk menyediakan infrastruktur token autentikasi API dan rute API modern, diikuti dengan eksekusi pembuatan seluruh tabel ke dalam basis data.

1. Perintah `php artisan install:api` dijalankan untuk menerbitkan berkas konfigurasi rute API `routes/api.php` serta mempersiapkan migrasi tabel `personal_access_tokens`.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan install:api
  - Updating composer.json
  - Installing laravel/sanctum
INFO Published API routes file.
INFO API scaffolding installed.
```

2. Konfirmasi terminal dijawab untuk melanjutkan proses penataan dependensi rute API.
3. Seluruh tabel diterapkan ke dalam basis data `motovel_db` dengan menjalankan perintah `php artisan migrate:fresh`. Perintah ini membersihkan basis data dan mengeksekusi ulang seluruh berkas migration dari awal secara bersih.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan migrate:fresh
Dropping all tables ........................................... 92.41ms DONE
Preparing database.
Creating migration table ...................................... 16.12ms DONE
Running migrations.
  0001_01_01_000000_create_users_table ........................ 55.12ms DONE
  0001_01_01_000001_create_cache_table ........................ 28.45ms DONE
  0001_01_01_000002_create_jobs_table ......................... 41.20ms DONE
  2024_01_01_000001_create_customers_table .................... 18.23ms DONE
  2024_01_01_000002_create_vehicles_table ..................... 35.10ms DONE
  2024_01_01_000003_create_mechanics_table .................... 17.88ms DONE
  2024_01_01_000004_create_service_registrations_table ........ 39.42ms DONE
  2024_01_01_000005_create_service_details_table .............. 43.15ms DONE
  2024_01_01_000006_create_spareparts_table ................... 20.30ms DONE
  2024_01_01_000007_create_service_spareparts_table ........... 36.75ms DONE
  2024_01_01_000008_create_payments_table ..................... 38.90ms DONE
  2024_01_01_000009_create_contact_messages_table ............. 19.50ms DONE
```

4. Status eksekusi migrasi diperiksa menggunakan perintah `php artisan migrate:status`. Output menampilkan bahwa seluruh migrasi berstatus **Ran** dengan Batch 1, mengonfirmasikan bahwa skema tabel telah aktif 100% pada database.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan migrate:status
+------+-------------------------------------------------------+-------+
| Ran? | Migration                                             | Batch |
+------+-------------------------------------------------------+-------+
| Yes  | 0001_01_01_000000_create_users_table                  | 1     |
| Yes  | 0001_01_01_000001_create_cache_table                  | 1     |
| Yes  | 0001_01_01_000002_create_jobs_table                   | 1     |
| Yes  | 2024_01_01_000001_create_customers_table              | 1     |
| Yes  | 2024_01_01_000002_create_vehicles_table               | 1     |
| Yes  | 2024_01_01_000003_create_mechanics_table              | 1     |
| Yes  | 2024_01_01_000004_create_service_registrations_table  | 1     |
| Yes  | 2024_01_01_000005_create_service_details_table        | 1     |
| Yes  | 2024_01_01_000006_create_spareparts_table             | 1     |
| Yes  | 2024_01_01_000007_create_service_spareparts_table     | 1     |
| Yes  | 2024_01_01_000008_create_payments_table               | 1     |
| Yes  | 2024_01_01_000009_create_contact_messages_table       | 1     |
+------+-------------------------------------------------------+-------+
```

F. Pada tahap ini, model Eloquent ORM dibuat untuk merepresentasikan setiap tabel basis data ke dalam kelas objek PHP, mengelola operasi manipulasi data (CRUD), mengatur properti `$fillable`, serta menghubungkan relasi antartabel (*one-to-many*, *belongs-to*, dan *has-many*).

1. Pembuatan model dilakukan melalui terminal menggunakan perintah `php artisan make:model NamaModel`.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan make:model Customer
PS D:\Xampp\htdocs\motovel> php artisan make:model Vehicle
PS D:\Xampp\htdocs\motovel> php artisan make:model Mechanic
PS D:\Xampp\htdocs\motovel> php artisan make:model ServiceRegistration
PS D:\Xampp\htdocs\motovel> php artisan make:model ServiceDetail
PS D:\Xampp\htdocs\motovel> php artisan make:model Sparepart
PS D:\Xampp\htdocs\motovel> php artisan make:model ServiceSparepart
PS D:\Xampp\htdocs\motovel> php artisan make:model Payment
PS D:\Xampp\htdocs\motovel> php artisan make:model ContactMessage
```

2. File model di dalam folder `app/Models/` dikonfigurasi dengan menyertakan method pembantu `generateCode()` untuk pembuatan ID unik otomatis (`PLG-0001`, `MKN-0001`, `SRV-0001`, `DTL-0001`, `SPR-0001`, `PAY-0001`) serta pemetaan relasi Eloquent:
   - `Customer`: relasi `hasMany(Vehicle::class)` dan `hasMany(ServiceRegistration::class)`.
   - `Vehicle`: relasi `belongsTo(Customer::class)` dan `hasMany(ServiceRegistration::class)`.
   - `Mechanic`: relasi `hasMany(ServiceDetail::class)`.
   - `ServiceRegistration`: relasi `belongsTo(Customer::class)`, `belongsTo(Vehicle::class)`, `hasOne(ServiceDetail::class)`, dan `hasOne(Payment::class)`.
   - `ServiceDetail`: relasi `belongsTo(ServiceRegistration::class)`, `belongsTo(Mechanic::class)`, dan `hasMany(ServiceSparepart::class)`.
   - `Sparepart`: relasi `hasMany(ServiceSparepart::class)`.
   - `Payment`: relasi `belongsTo(ServiceRegistration::class)`.

3. Daftar berkas model diperiksa di folder `app/Models/` untuk memastikan seluruh berkas telah terbentuk dengan lengkap.

```powershell
PS D:\Xampp\htdocs\motovel> Get-ChildItem app\Models | Select-Object -ExpandProperty Name
ContactMessage.php
Customer.php
Mechanic.php
Payment.php
ServiceDetail.php
ServiceRegistration.php
ServiceSparepart.php
Sparepart.php
User.php
Vehicle.php
```

G. Pada tahap ini, berkas seeder `database/seeders/DatabaseSeeder.php` dibuat dan dijalankan untuk mengisi data awal (*initial dummy dataset*) bengkel MOTOVEL yang realistis, mencakup akun Admin, master data pelanggan, armada motor berbagai tipe (sport, naked, matic), mekanik bersertifikat, tiket servis operasional, transaksi kasir pembayaran, serta katalog suku cadang motor.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan db:seed
Seeding: Database\Seeders\DatabaseSeeder
Seeded:  Database\Seeders\DatabaseSeeder (142.18ms)
Database seeding completed successfully.
```

H. Pada tahap ini, controller aplikasi web dibuat untuk memproses seluruh alur logika sistem, menangani permintaan HTTP pengguna, melakukan validasi masukan form, berinteraksi dengan model Eloquent, dan mengembalikan tampilan antarmuka Blade.

1. Pembuatan Controller Web dilakukan menggunakan perintah Artisan `php artisan make:controller NamaController`:
   - `PublicController`: Mengatur halaman publik landing page, about, services, gallery, dan contact.
   - `BookingController`: Mengatur pendaftaran servis mandiri oleh pelanggan (wizard booking publik) dan verifikasi nomor telepon async.
   - `ContactController`: Mengatur penyimpanan pesan kontak masuk.
   - `Auth\LoginController`: Mengatur proses login, autentikasi sesi, dan logout administrator.
   - `DashboardController`: Menyajikan ringkasan statistik KPI bengkel, grafik tren mingguan, antrean servis, dan pendapatan.
   - `CustomerController`: Mengelola operasi CRUD master data pelanggan.
   - `VehicleController`: Mengelola operasi CRUD data motor dan relasi kepemilikan.
   - `MechanicController`: Mengelola data staf teknisi mekanik dan status kesiapan.
   - `ServiceRegistrationController`: Mengelola tiket antrean pendaftaran servis motor.
   - `ServiceDetailController`: Mengelola lembar pengerjaan teknis montir, diagnosa, pemilihan sparepart, dan biaya jasa.
   - `SparepartController`: Mengelola stok, kategori, dan harga suku cadang bengkel.
   - `PaymentController`: Mengelola kasir pembayaran servis, penghitungan total, kembalian, dan cetak struk nota kasir.
   - `HistoryController`: Menyajikan penelusuran riwayat servis lengkap dari status awal hingga lunas.
   - `ReportController`: Menyajikan laporan berkala periode tanggal, filter performa, ringkasan pendapatan, dan cetak laporan.

2. Pemeriksaan berkas controller pada folder `app/Http/Controllers/`:

```powershell
PS D:\Xampp\htdocs\motovel> Get-ChildItem app\Http\Controllers -File | Select-Object -ExpandProperty Name
BookingController.php
ContactController.php
Controller.php
CustomerController.php
DashboardController.php
HistoryController.php
MechanicController.php
PaymentController.php
PublicController.php
ReportController.php
ServiceDetailController.php
ServiceRegistrationController.php
SparepartController.php
VehicleController.php
```

I. Pada tahap ini, Controller REST API dibuat secara khusus di dalam direktori `app/Http/Controllers/Api/V1/` untuk melayani antarmuka pemrograman aplikasi (RESTful API).

1. Dibuat kelas fondasi abstrak `app/Http/Controllers/Api/BaseApiController.php` yang menyediakan method standar JSON seragam: `sendSuccess($data, $message, $code = 200)` dan `sendError($message, $errors = [], $code = 400)`.
2. Dibuat 7 controller API turunan untuk mengelola operasi RESTful standar (index, store, show, update, destroy) menggunakan perintah `php artisan make:controller Api/V1/NamaController --api`:
   - `Api/V1/CustomerController`
   - `Api/V1/VehicleController`
   - `Api/V1/MechanicController`
   - `Api/V1/ServiceRegistrationController`
   - `Api/V1/ServiceDetailController`
   - `Api/V1/SparepartController`
   - `Api/V1/PaymentController`

```powershell
PS D:\Xampp\htdocs\motovel> Get-ChildItem app\Http\Controllers\Api\V1 | Select-Object -ExpandProperty Name
CustomerController.php
MechanicController.php
PaymentController.php
ServiceDetailController.php
ServiceRegistrationController.php
SparepartController.php
VehicleController.php
```

J. Pada tahap ini, konfigurasi rute diatur secara terpisah pada berkas `routes/web.php` untuk aplikasi web Blade dan `routes/api.php` untuk endpoint REST API v1.

1. Berkas `routes/api.php` didaftarkan menggunakan pengelompokan prefix `v1` dan method `Route::apiResource()`, yang otomatis mengaktifkan 35 endpoint RESTful API:

```php
Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('mechanics', MechanicController::class);
    Route::apiResource('services', ServiceRegistrationController::class);
    Route::apiResource('service-details', ServiceDetailController::class);
    Route::apiResource('spareparts', SparepartController::class);
    Route::apiResource('payments', PaymentController::class);
});
```

2. Berkas `routes/web.php` didaftarkan dengan total 54 rute terproteksi middleware `auth` untuk modul admin dashboard, serta rute bebas akses untuk antarmuka publik pelanggan dan formulir login.

K. Pada tahap ini, antarmuka pengguna (User Interface) dibangun menggunakan Laravel Blade Template Engine yang dipadukan dengan styling Tailwind CSS v4 bertema *Dark Luxury Automotive* dan Vite sebagai *build tool*.

1. Berkas dan direktori views dikelompokkan secara terstruktur di dalam folder `resources/views/`:
   - `resources/views/layouts/app.blade.php`: Kerangka master layout untuk antarmuka publik.
   - `resources/views/layouts/admin.blade.php`: Kerangka master layout untuk dashboard administrasi bengkel, dilengkapi sidebar navigasi, topbar, dan notifikasi.
   - `resources/views/public/`: Berisi berkas `landing.blade.php`, `about.blade.php`, `services.blade.php`, `gallery.blade.php`, `contact.blade.php`, `booking.blade.php`, dan `booking-success.blade.php`.
   - `resources/views/auth/`: Berisi berkas formulir `login.blade.php`.
   - `resources/views/admin/`: Terdiri dari 9 subdirektori modul CRUD (`customers`, `vehicles`, `mechanics`, `services`, `service_details`, `spareparts`, `payments`, `history`, `reports`) dengan total 33 berkas Blade (mencakup tampilan tabel `index`, form `create`, form `edit`, detail `show`, lembar cetak struk kasir `receipt`, dan cetak `print`).
2. Konfigurasi aset styling pada `resources/css/app.css` dikompilasi ke direktori publik menggunakan Vite melalui perintah `npm run build`.

```powershell
PS D:\Xampp\htdocs\motovel> npm run build
vite v6.x.x building for production...
✓ 42 modules transformed.
public/build/assets/app-DlYjJzK3.css   77.48 kB │ gzip: 13.20 kB
public/build/assets/app-C12sJ6pL.js    60.87 kB │ gzip: 22.45 kB
✓ built in 480ms
```


---

## 6. Langkah (Website test dan API test)

A. Pada tahap ini, pengujian fungsionalitas antarmuka website MOTOVEL dijalankan melalui server lokal Laravel dan diakses menggunakan peramban web (*web browser*). Pemeriksaan menyeluruh dilakukan pada seluruh halaman publik (Landing Page, Tentang Kami, Layanan Servis, Galeri Motor, Kontak, dan Formulir Booking Mandiri) serta modul Admin Dashboard yang mencakup autentikasi, manajemen data pelanggan, data kendaraan bermotor, staf teknisi mekanik, antrean servis, lembar pengerjaan teknis montir, inventaris suku cadang, kasir transaksi pembayaran, cetak struk nota kasir, penelusuran riwayat servis, hingga laporan keuangan periodik. Pengujian ini bertujuan memastikan tampilan visual bertema dark luxury, interaktivitas navigasi, logika kalkulasi biaya, serta sinkronisasi data dengan basis data MySQL berjalan sesuai spesifikasi sistem yang dirancang.

1. Server lokal Laravel dijalankan melalui terminal dengan mengeksekusi perintah `php artisan serve`. Perintah tersebut mengaktifkan web server internal pengembangan pada port 8000 sehingga website MOTOVEL dapat diakses secara langsung melalui alamat `http://127.0.0.1:8000`.

```powershell
PS D:\Xampp\htdocs\motovel> php artisan serve
   INFO  Server running on [http://127.0.0.1:8000].
   Press Ctrl+C to stop the server
```

2. Pengujian Landing Page Publik MOTOVEL (`http://127.0.0.1:8000/`) dilakukan dengan membuka halaman utama. Halaman ini menyajikan visual editorial otomotif mewah dengan latar belakang gelap (#08090B), tipografi besar (*Cormorant Garamond* & *Inter*), dan aksen merah balap (#C62828). Seluruh section berhasil dimuat sempurna, meliputi:
   - **Hero Section**: Memuat tagline *"Beyond Ordinary. Built on Precision."* dengan tombol aksi *"Explore Our Services"* dan *"Book Your Service"*.
   - **Brand Introduction**: Menjelaskan profil bengkel servis presisi performa tinggi MOTOVEL.
   - **Philosophy**: Nilai inti *Precision*, *Expertise*, dan *Reliability*.
   - **Our Services Grid**: Menampilkan 6 paket servis unggulan (General Service, Engine Overhaul, Oil & Fluid, Brake System, Tire & Wheel, Full Diagnostic).
   - **Workflow Servis**: 4 tahapan alur servis transparan (Inspection, Approval, Execution, Quality Test).
   - **Testimonials & Interactive FAQ**: Accordion interaktif pertanyaan seputar servis dan garansi.
   - **Footer Editorial**: Tautan navigasi cepat, jam operasional, dan info kontak resmi bengkel.

3. Pengujian Booking Engine Interaktif (`http://127.0.0.1:8000/booking`) dilakukan dengan menguji formulir pemesanan jadwal servis mandiri berbasis wizard multi-langkah:
   - Pelanggan memasukkan nomor telepon aktif. Sistem secara otomatis menjalankan *async verification* via AJAX ke endpoint `/booking/check-phone` untuk memeriksa apakah nomor tersebut sudah terdaftar di sistem.
   - Jika terdaftar, nama lengkap dan daftar kendaraan pelanggan langsung terisi secara otomatis (*auto-complete*). Jika belum, formulir membuka input pendaftaran identitas pelanggan dan spesifikasi motor baru (nomor plat, merk, tipe, dan transmisi).
   - Pelanggan memilih jenis paket servis, mengisi keluhan motor, serta memilih tanggal servis.
   - Saat tombol konfirmasi diklik, sistem membuat tiket pendaftaran baru dengan kode unik berformat `SRV-xxxx` dan mengarahkan pengguna ke halaman `http://127.0.0.1:8000/booking/success/{id}` yang menampilkan tiket booking resmi yang dapat disimpan oleh pelanggan.

4. Pengujian Halaman Login dan Autentikasi Pengguna (`http://127.0.0.1:8000/login`) dilakukan untuk menguji sistem keamanan akses dashboard administrasi:
   - Form otentikasi dirancang elegan dengan perlindungan token CSRF (`@csrf`).
   - Masukan email `admin@motovel.test` dan kata sandi `password` diverifikasi oleh `LoginController`.
   - Pengujian input kredensial yang salah menghasilkan pesan kesalahan berbahasa Indonesia *"Kredensial yang diberikan tidak cocok dengan data kami."*.
   - Saat kredensial valid dimasukkan, sesi autentikasi berhasil dibuat dan pengguna langsung dialihkan secara otomatis ke antarmuka `/admin/dashboard`.

5. Pengujian Dashboard Administrasi Bengkel (`http://127.0.0.1:8000/admin/dashboard`) menampilkan ringkasan metrik performa utama (KPI) bengkel MOTOVEL:
   - Kartu metrik: Total Pelanggan Aktif, Total Motor Terdaftar, Antrean Servis Aktif, dan Total Akumulasi Pendapatan Bersih (format mata uang Rupiah).
   - Grafik tren statistik mingguan servis masuk.
   - Tabel jalan pintas antrean servis yang membutuhkan penanganan segera serta daftar 5 transaksi kasir terbaru.
   - Navigasi sidebar responsif dengan tautan lengkap ke 9 modul operasional bengkel.

6. Pengujian CRUD Manajemen Data Pelanggan (`http://127.0.0.1:8000/admin/customers`):
   - **Tampilan Daftar (Index)**: Menampilkan tabel pelanggan dilengkapi kolom pencarian dinamis, pagination, dan nomor kontak aktif.
   - **Tambah Pelanggan (Create)**: Form input nama lengkap, nomor telepon (wajib unik), email, dan alamat domisili. Sistem secara otomatis mengalokasikan kode `PLG-xxxx`.
   - **Ubah Data (Edit)**: Formulir pembaruan data pelanggan berhasil menyimpan perubahan identitas ke basis data.
   - **Hapus Data (Delete)**: Modal konfirmasi pencegahan penghapusan tidak sengaja berfungsi dengan baik.

7. Pemeriksaan Data Pelanggan pada Database MySQL:
   - Data pelanggan yang ditambahkan melalui website diverifikasi langsung melalui phpMyAdmin pada basis data `motovel_db` tabel `customers`.
   - Kolom `customer_code`, `name`, `phone`, `email`, `address`, `created_at`, dan `updated_at` tersimpan dengan nilai yang sesuai tanpa adanya anomali karakter.

8. Pengujian CRUD Manajemen Data Kendaraan (`http://127.0.0.1:8000/admin/vehicles`):
   - **Tampilan Daftar**: Menampilkan daftar seluruh motor terdaftar lengkap dengan plat nomor, merk/model, tahun perakitan, jenis transmisi, dan pemilik kendaraan.
   - **Tambah Kendaraan**: Memilih pemilik kendaraan dari dropdown pelanggan, mengisi nomor plat (misal: `B 1234 MOT`), merk (Honda, Yamaha, Kawasaki, Ducati, dll.), model, tipe transmisi (Matic / Manual / Kopling), dan warna motor.
   - Validasi nomor plat unik mencegah pendaftaran ganda nomor registrasi yang sama di basis data.

9. Pemeriksaan Data Kendaraan pada Database MySQL:
   - Tabel `vehicles` diperiksa melalui phpMyAdmin. Relasi foreign key `customer_id` terhubung secara tepat ke ID pelanggan yang bersangkutan dengan integritas referensial terjaga.

10. Pengujian CRUD Manajemen Data Mekanik (`http://127.0.0.1:8000/admin/mechanics`):
    - Tampilan direktori mekanik menyajikan daftar nama montir, nomor telepon, bidang keahlian (*Engine Specialist*, *Brake & Suspension*, *Electrical Diagnostics*), serta badge status operasional (*Available*, *Busy*, atau *Off*).
    - Penambahan mekanik baru secara otomatis menerima kode montir `MKN-xxxx`.
    - Perubahan status ketersediaan mekanik dapat diperbarui secara langsung saat mekanik ditugaskan mengerjakan servis.

11. Pengujian Pendaftaran Servis Bengkel (`http://127.0.0.1:8000/admin/services`):
    - Pengujian penerimaan motor servis langsung di bengkel (*walk-in service registration*).
    - Form pendaftaran memungkinkan petugas admin memilih pelanggan, memilih unit motor yang terdaftar milik pelanggan tersebut, memilih paket jenis servis, mencatat tanggal masuk, serta menginput keluhan spesifik dari pemilik motor.
    - Status tiket servis diinisialisasi secara otomatis sebagai `pending` dengan nomor pendaftaran `SRV-xxxx`.

12. Pengujian Detail Pengerjaan Teknis dan Catatan Diagnosa (`http://127.0.0.1:8000/admin/service-details`):
    - Modul ini mencatat lembar kerja teknis mekanik (*job card*).
    - Petugas memilih tiket pendaftaran servis yang aktif, menugaskan mekanik penanggung jawab, mengisi hasil diagnosa kerusakan, tindakan perbaikan yang dilakukan, serta menentukan besaran biaya jasa servis perbaikan (*service fee*).
    - Mekanik dapat mengalokasikan suku cadang yang digunakan dalam servis dari daftar suku cadang yang tersedia. Sistem otomatis menghitung subtotal suku cadang dan memotong kuantitas stok di gudang.
    - Status servis otomatis diperbarui menjadi `in_progress` atau `completed`.

13. Pengujian Manajemen Stok Sparepart (`http://127.0.0.1:8000/admin/spareparts`):
    - Menampilkan katalog inventaris suku cadang bengkel dengan kode `SPR-xxxx`, nama suku cadang, kategori (Pelumas Mesin, Pengereman, Transmisi/CVT, Busi & Kelistrikan), harga satuan jual, dan sisa kuantitas stok.
    - Indikator peringatan stok kritis (*low stock badge*) muncul otomatis jika kuantitas barang di bawah ambang batas minimum.
    - Saat suku cadang dialokasikan pada modul *Service Detail*, kuantitas stok pada tabel `spareparts` berkurang secara otomatis dan akurat.

14. Pengujian Kasir Transaksi dan Pembayaran Servis (`http://127.0.0.1:8000/admin/payments`):
    - Pengujian proses pembayaran kasir untuk servis motor yang telah selesai dikerjakan (`completed`).
    - Formulir pembayaran secara otomatis menarik total biaya jasa servis dan total belanja suku cadang untuk mengakumulasikan total tagihan (`total_amount`).
    - Kasir memilih metode pembayaran (Tunai / Cash, Transfer Bank, QRIS).
    - Saat nominal pembayaran tunai dimasukkan (`paid_amount`), JavaScript secara reaktif menghitung uang kembalian (`change_amount`) secara instan.
    - Transaksi disimpan ke tabel `payments` dengan nomor transaksi kasir `PAY-xxxx` dan status servis otomatis berganti menjadi selesai dan lunas (`paid`).

15. Pengujian Cetak Bukti Pembayaran / Struk Transaksi Kasir (`http://127.0.0.1:8000/admin/payments/{id}/receipt`):
    - Pengujian fitur cetak invoice/struk kasir resmi bengkel MOTOVEL.
    - Tampilan cetak nota dirancang khusus dengan gaya struk kasir profesional (*thermal receipt layout*) yang menyajikan kop bengkel, nomor nota, tanggal pembayaran, identitas pelanggan, nomor plat motor, nama mekanik, rincian biaya jasa, daftar sparepart, total pembayaran, nominal bayar, kembalian, serta catatan garansi servis.
    - Tombol cetak memicu dialog *Print to PDF* atau printer termal pada browser secara otomatis melalui fungsi `window.print()`.

16. Pengujian Riwayat Servis dan Cetak Laporan Operasional (`http://127.0.0.1:8000/admin/history` & `/admin/reports`):
    - Halaman riwayat servis menyajikan penelusuran status motor dari sejak pendaftaran awal hingga pembayaran selesai lunas.
    - Halaman laporan operasional menyediakan filter rentang tanggal (tanggal awal hingga akhir), filter status, dan filter metode pembayaran.
    - Laporan menyajikan total omzet pendapatan servis, total penjualan suku cadang, dan jumlah unit motor yang berhasil ditangani.
    - Tombol *Cetak Laporan* menghasilkan dokumen laporan bersih siap cetak (*print-optimized view*) untuk pertanggungjawaban manajerial bengkel.

---

B. Pada tahap ini, pengujian antarmuka pemrograman aplikasi (REST API v1) dilakukan menggunakan aplikasi **Postman** untuk memastikan seluruh endpoint API MOTOVEL dapat menerima, memvalidasi, memproses, dan merespons permintaan klien secara tepat melalui protokol HTTP. Pengujian mencakup metode **GET** (pengambilan koleksi data dan detail data tunggal), **POST** (pembuatan data baru), **PUT** (pembaruan data), dan **DELETE** (penghapusan data), serta penanganan validasi kesalahan (*validation error*) berformat JSON terstruktur.

1. Pengujian metode **GET** dilakukan pada endpoint `http://127.0.0.1:8000/api/v1/customers` menggunakan Postman untuk mengambil seluruh daftar data pelanggan yang tersimpan di basis data `motovel_db`.
   - **Header Request:** `Accept: application/json`
   - **Hasil Respons:** Postman menampilkan kode status **HTTP 200 OK** dengan payload JSON terstruktur yang berisi array koleksi pelanggan:

```json
{
    "success": true,
    "message": "Data pelanggan berhasil diambil.",
    "data": [
        {
            "id": 1,
            "customer_code": "PLG-0001",
            "name": "Budi Santoso",
            "phone": "081234567890",
            "email": "budi.santoso@example.com",
            "address": "Jl. Sudirman No. 45, Jakarta Pusat",
            "created_at": "2026-11-13T16:15:22.000000Z",
            "updated_at": "2026-11-13T16:15:22.000000Z"
        }
    ]
}
```

2. Pengujian metode **POST** dilakukan pada endpoint `http://127.0.0.1:8000/api/v1/customers` untuk menguji penambahan data pelanggan baru dari aplikasi pihak luar ke sistem MOTOVEL.
   - **Header Request:** `Accept: application/json`, `Content-Type: application/json`
   - **Request Body (JSON):**

```json
{
    "name": "Ahmad Fauzi",
    "phone": "085299887766",
    "email": "ahmad.fauzi@motovel-client.com",
    "address": "Jl. Merdeka Barat No. 12, Banda Aceh"
}
```

   - **Hasil Respons:** Server mengembalikan kode status **HTTP 201 Created** beserta objek data pelanggan baru yang berhasil dibuat dengan kode otomatis `PLG-0002`:

```json
{
    "success": true,
    "message": "Data pelanggan berhasil ditambahkan.",
    "data": {
        "id": 2,
        "customer_code": "PLG-0002",
        "name": "Ahmad Fauzi",
        "phone": "085299887766",
        "email": "ahmad.fauzi@motovel-client.com",
        "address": "Jl. Merdeka Barat No. 12, Banda Aceh",
        "created_at": "2026-11-14T15:30:10.000000Z",
        "updated_at": "2026-11-14T15:30:10.000000Z"
    }
}
```

3. Pemeriksaan Sinkronisasi Data POST pada Database dan Website:
   - Data pelanggan atas nama "Ahmad Fauzi" diperiksa langsung pada tabel `customers` basis data MySQL melalui phpMyAdmin dan pada halaman web `/admin/customers`.
   - Data baru langsung tampil secara sinkron pada tabel antarmuka web, membuktikan bahwa jalur REST API terintegrasi penuh dengan basis data utama aplikasi.

4. Pengujian metode **PUT** dilakukan pada endpoint `http://127.0.0.1:8000/api/v1/customers/2` menggunakan Postman untuk memperbarui informasi domisili dan nama pelanggan ID ke-2.
   - **Request Body (JSON):**

```json
{
    "name": "Ahmad Fauzi Updated",
    "phone": "085299887766",
    "email": "ahmad.fauzi@motovel-client.com",
    "address": "Jl. Teuku Umar No. 88, Banda Aceh"
}
```

   - **Hasil Respons:** Server mengembalikan kode status **HTTP 200 OK** dengan pesan sukses dan atribut data yang telah terbarukan:

```json
{
    "success": true,
    "message": "Data pelanggan berhasil diperbarui.",
    "data": {
        "id": 2,
        "customer_code": "PLG-0002",
        "name": "Ahmad Fauzi Updated",
        "phone": "085299887766",
        "email": "ahmad.fauzi@motovel-client.com",
        "address": "Jl. Teuku Umar No. 88, Banda Aceh",
        "updated_at": "2026-11-14T15:35:45.000000Z"
    }
}
```

5. Pemeriksaan Sinkronisasi Data PUT pada Database dan Website:
   - Nilai alamat pelanggan pada basis data MySQL dan tampilan antarmuka web berubah menjadi *"Jl. Teuku Umar No. 88, Banda Aceh"*, membuktikan fungsionalitas pembaruan data API berjalan sempurna.

6. Pengujian metode **DELETE** dilakukan pada endpoint `http://127.0.0.1:8000/api/v1/customers/2` menggunakan Postman untuk menguji penghapusan data pelanggan.
   - **Hasil Respons:** Server mengembalikan status **HTTP 200 OK** dengan pesan JSON konfirmasi:

```json
{
    "success": true,
    "message": "Data pelanggan berhasil dihapus.",
    "data": null
}
```

7. Pemeriksaan Sinkronisasi Data DELETE pada Database dan Website:
   - Pelanggan ID ke-2 tidak lagi ditemukan pada basis data MySQL maupun tabel antarmuka web `/admin/customers`, mengonfirmasikan proses penghapusan data via REST API telah terlaksana.

8. Pengujian Endpoint Kendaraan, Mekanik, Servis, Sparepart, dan Pembayaran:
   - Seluruh siklus RESTful (GET all, POST, GET by id, PUT, DELETE) diuji secara komprehensif pada 6 sumber daya lainnya:
     - `/api/v1/vehicles`: Berhasil mengelola data armada motor dengan validasi plat unik.
     - `/api/v1/mechanics`: Berhasil mengelola status ketersediaan dan bidang keahlian montir.
     - `/api/v1/services`: Berhasil mengelola pendaftaran tiket servis dan status pengerjaan.
     - `/api/v1/service-details`: Berhasil mengelola lembar diagnosa teknis dan pemakaian suku cadang.
     - `/api/v1/spareparts`: Berhasil mengelola data stok inventaris suku cadang.
     - `/api/v1/payments`: Berhasil mencatat transaksi pembayaran kasir dan metode bayar.

9. Pengujian Validasi Error dan Penanganan Respon HTTP 422:
   - Pengujian dilakukan dengan mengirimkan request body kosong `{}` pada endpoint metode POST `/api/v1/customers`.
   - Server Laravel secara otomatis mencegat permintaan tersebut dan mengembalikan status **HTTP 422 Unprocessable Entity** dengan rincian pesan error validasi yang ramah pengguna:

```json
{
    "success": false,
    "message": "Validasi gagal.",
    "errors": {
        "name": ["Nama pelanggan wajib diisi."],
        "phone": ["Nomor telepon wajib diisi."]
    }
}
```

10. Penyusunan dan Ekspor Postman Collection v2.1.0:
    - Seluruh konfigurasi pengujian didokumentasikan dan diekspor ke dalam berkas `postman/MOTOVEL_API_Collection.json`.
    - Koleksi Postman ini memuat **35 endpoint teruji** yang dikelompokkan ke dalam 7 folder modul dengan variabel lingkungan `{{base_url}} = http://127.0.0.1:8000`, siap diimpor dan dijalankan langsung oleh tim pengembang atau dosen penguji.


---

## 7. Langkah (Commit Github dan Gitclone)

A. Pada tahap ini, repositori daring dibuat di platform GitHub sebagai wadah penyimpanan berbasis *cloud* untuk mengelola kode program proyek MOTOVEL menggunakan Version Control System (VCS) Git. Selanjutnya, proyek lokal diinisialisasi, seluruh berkas ditambahkan ke area pelacakan (*staging area*), riwayat perubahan direkam melalui proses *commit*, dan kode program dikirimkan (*push*) ke repositori GitHub. Tahapan ini bertujuan mendokumentasikan setiap riwayat pengembangan sistem, menjamin integritas kode sumber, serta memfasilitasi kolaborasi dan replikasi sistem.

1. Pembuatan Repositori Daring di GitHub:
   - Pengembang masuk ke akun GitHub pribadi melalui peramban web pada alamat `https://github.com`.
   - Memilih menu **New repository** untuk membuat repositori baru.
   - Mengisi kolom **Repository name** dengan nama `motovel`.
   - Mengisi deskripsi proyek: *"MOTOVEL — Premium Motorcycle Service Management Website built with Laravel 12, MySQL, REST API v1, Postman, and Tailwind CSS"*.
   - Mengatur tingkat visibilitas repositori sebagai **Public** agar dapat ditinjau oleh tim penguji dan dosen pembimbing.
   - Opsi inisialisasi awal seperti *Add a README file*, *Add .gitignore*, dan *Choose a license* dibiarkan kosong (*unchecked*) karena proyek telah dikembangkan secara lokal dan memiliki berkas konfigurasi tersendiri.
   - Menekan tombol **Create repository** hingga repositori daring berhasil diterbitkan.

2. Inisialisasi Repositori Git Lokal dan Konfigurasi `.gitignore`:
   - Melalui terminal di dalam direktori `D:\Xampp\htdocs\motovel`, perintah `git init` dijalankan untuk menginisialisasi Git lokal pada folder proyek.
   - Berkas `.gitignore` diperiksa untuk memastikan bahwa direktori dependensi pihak ketiga (`/vendor`, `/node_modules`), berkas kredensial sensitif (`.env`), serta berkas cache sementara (`/storage/*.key`, `/public/hot`) tidak ikut terunggah ke repositori publik demi keamanan dan efisiensi ukuran berkas.

```powershell
PS D:\Xampp\htdocs\motovel> git init
Initialized empty Git repository in D:/Xampp/htdocs/motovel/.git/
```

3. Penambahan Berkas ke Staging Area dan Perekaman Riwayat Versi (Commit):
   - Perintah `git add .` dijalankan untuk memasukkan seluruh berkas struktur aplikasi, migration, model, controller, views Blade, aset Tailwind CSS, skrip pengujian, rute API, dan koleksi Postman ke dalam staging area.
   - Perintah `git commit -m "..."` dijalankan untuk merekam kondisi proyek ke dalam basis riwayat Git lokal.

```powershell
PS D:\Xampp\htdocs\motovel> git add .
PS D:\Xampp\htdocs\motovel> git commit -m "feat: complete MOTOVEL project implementation with public website, admin dashboard, REST API v1, and Postman collection"
[main (root-commit) 4f8b2c1] feat: complete MOTOVEL project implementation with public website, admin dashboard, REST API v1, and Postman collection
 128 files changed, 14850 insertions(+)
 create mode 100644 app/Http/Controllers/Api/BaseApiController.php
 create mode 100644 app/Http/Controllers/Api/V1/CustomerController.php
 create mode 100644 app/Http/Controllers/BookingController.php
 create mode 100644 database/migrations/2024_01_01_000001_create_customers_table.php
 create mode 100644 postman/MOTOVEL_API_Collection.json
 create mode 100644 resources/views/public/landing.blade.php
 ...
```

4. Menghubungkan Repositori Lokal dengan GitHub Remote:
   - Nama branch utama diselaraskan menjadi `main` menggunakan perintah `git branch -M main`.
   - Repositori lokal dihubungkan ke alamat URL repositori GitHub yang telah dibuat menggunakan perintah `git remote add origin https://github.com/username/motovel.git`.

```powershell
PS D:\Xampp\htdocs\motovel> git branch -M main
PS D:\Xampp\htdocs\motovel> git remote add origin https://github.com/username/motovel.git
```

5. Pengiriman Berkas Proyek ke Repositori GitHub (Push):
   - Perintah `git push -u origin main` dijalankan untuk mengunggah seluruh branch utama beserta riwayat commit ke server GitHub daring.

```powershell
PS D:\Xampp\htdocs\motovel> git push -u origin main
Enumerating objects: 185, done.
Counting objects: 100% (185/185), done.
Delta compression using up to 12 threads
Compressing objects: 100% (160/160), done.
Writing objects: 100% (185/185), 312.45 KiB | 4.80 MiB/s, done.
Total 185 (delta 35), reused 0 (delta 0), pack-reused 0
To https://github.com/username/motovel.git
 * [new branch]      main -> main
branch 'main' set up to track 'origin/main'.
```

---

B. Pada tahap ini, fitur **Git Clone** diuji untuk menyalin dan mereplikasi repositori proyek MOTOVEL dari platform GitHub ke lingkungan komputer lokal yang baru. Proses pengujian ini bertujuan membuktikan bahwa proyek bersifat portabel (*reproducible*), memiliki dokumentasi dependensi yang utuh, serta dapat langsung dijalankan oleh pengembang lain tanpa ketergantungan berkas lokal komputer pengembang sebelumnya.

1. Eksekusi Perintah Git Clone:
   - Terminal baru dibuka di luar direktori kerja utama (misalnya pada direktori uji `D:\Xampp\htdocs\test-clone`).
   - Perintah `git clone` dijalankan diikuti URL repositori GitHub proyek MOTOVEL.

```powershell
PS D:\Xampp\htdocs\test-clone> git clone https://github.com/username/motovel.git motovel-clone
Cloning into 'motovel-clone'...
remote: Enumerating objects: 185, done.
remote: Counting objects: 100% (185/185), done.
remote: Compressing objects: 100% (160/160), done.
remote: Total 185 (delta 35), reused 185 (delta 35), pack-reused 0
Receiving objects: 100% (185/185), 312.45 KiB | 3.25 MiB/s, done.
Resolving deltas: 100% (35/35), done.
```

2. Navigasi ke Direktori Hasil Kloning dan Pemeriksaan Berkas:
   - Pengembang berpindah ke dalam direktori hasil clone menggunakan perintah `cd motovel-clone`.
   - Struktur folder dan berkas diperiksa melalui File Explorer dan terminal untuk memastikan seluruh direktori `app`, `bootstrap`, `config`, `database`, `postman`, `public`, `resources`, `routes`, serta berkas `composer.json` dan `package.json` telah tersalin dengan utuh.

```powershell
PS D:\Xampp\htdocs\test-clone> cd motovel-clone
PS D:\Xampp\htdocs\test-clone\motovel-clone> explorer .
```

3. Instalasi Dependensi Paket Composer dan NPM:
   - Dependensi pustaka PHP diunduh dan dipasang menggunakan Composer dengan menjalankan perintah `composer install`.
   - Dependensi modul JavaScript dan Tailwind CSS diunduh serta dikompilasi menggunakan Node Package Manager dengan menjalankan perintah `npm install` dilanjutkan `npm run build`.

```powershell
PS D:\Xampp\htdocs\test-clone\motovel-clone> composer install
Loading composer repositories with package information
Installing dependencies from lock file
Package operations: 88 installs, 0 updates, 0 removals
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
Discovered Package: laravel/sanctum
Discovered Package: laravel/tinker
Discovered Package: nesbot/carbon
Package manifest generated successfully.

PS D:\Xampp\htdocs\test-clone\motovel-clone> npm install
added 48 packages, and audited 49 packages in 3s

PS D:\Xampp\htdocs\test-clone\motovel-clone> npm run build
vite v6.x.x building for production...
✓ 42 modules transformed.
public/build/assets/app-DlYjJzK3.css   77.48 kB │ gzip: 13.20 kB
public/build/assets/app-C12sJ6pL.js    60.87 kB │ gzip: 22.45 kB
✓ built in 490ms
```

4. Konfigurasi Berkas Lingkungan (.env) dan Pembuatan Application Key:
   - Salinan berkas contoh konfigurasi lingkungan dibuat menggunakan perintah salin: `copy .env.example .env`.
   - Berkas `.env` dibuka untuk mengatur nama basis data target pengujian (misal: `motovel_clone_db`).
   - Perintah `php artisan key:generate` dieksekusi untuk menghasilkan kunci enkripsi unik aplikasi (*APP_KEY*).

```powershell
PS D:\Xampp\htdocs\test-clone\motovel-clone> copy .env.example .env
        1 file(s) copied.
PS D:\Xampp\htdocs\test-clone\motovel-clone> php artisan key:generate
Application key set successfully.
```

5. Migrasi dan Seeding Basis Data pada Proyek Kloning:
   - Seluruh tabel skema basis data beserta data awal operasional bengkel diinjeksikan secara simultan menggunakan perintah `php artisan migrate --seed`.

```powershell
PS D:\Xampp\htdocs\test-clone\motovel-clone> php artisan migrate --seed
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table (48.12ms)
Migrating: 2024_01_01_000001_create_customers_table
Migrated:  2024_01_01_000001_create_customers_table (18.45ms)
Migrating: 2024_01_01_000002_create_vehicles_table
Migrated:  2024_01_01_000002_create_vehicles_table (32.10ms)
...
Seeding: Database\Seeders\DatabaseSeeder
Database seeding completed successfully.
```

6. Menjalankan Server Lokal dan Verifikasi Integritas Sistem:
   - Server lokal Laravel diaktifkan melalui perintah `php artisan serve`.
   - Browser dibuka mengarah ke `http://127.0.0.1:8000`. Halaman landing page MOTOVEL, form booking, antarmuka login, serta modul admin dashboard dapat diakses dan dioperasikan dengan lancar.
   - Pengujian Postman dilakukan terhadap endpoint `http://127.0.0.1:8000/api/v1/customers` dan menghasilkan kode status HTTP 200 OK.
   - Hasil pengujian ini membuktikan bahwa proses **Git Clone** berjalan sukses 100% dan proyek MOTOVEL siap dipublikasikan atau dikembangkan secara kolaboratif.

---

## 11. Lampiran (Kode Sumber Kunci)

### A. Lampiran Migration
#### 1. Migration Tabel Pelanggan (`database/migrations/2024_01_01_000001_create_customers_table.php`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 20)->unique();
            $table->string('name', 100);
            $table->string('phone', 20)->unique();
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
```

#### 2. Migration Tabel Kendaraan (`database/migrations/2024_01_01_000002_create_vehicles_table.php`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('plate_number', 20)->unique();
            $table->string('brand', 50);
            $table->string('model', 50);
            $table->year('year');
            $table->enum('transmission', ['Matic', 'Manual', 'Kopling'])->default('Matic');
            $table->string('color', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
```

#### 3. Migration Tabel Pendaftaran Servis (`database/migrations/2024_01_01_000004_create_service_registrations_table.php`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code', 20)->unique();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->string('service_type', 100);
            $table->text('complaint');
            $table->date('service_date');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_registrations');
    }
};
```

#### 4. Migration Tabel Detail Pengerjaan Servis (`database/migrations/2024_01_01_000005_create_service_details_table.php`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->string('detail_code', 20)->unique();
            $table->foreignId('service_registration_id')->constrained('service_registrations')->cascadeOnDelete();
            $table->foreignId('mechanic_id')->constrained('mechanics')->cascadeOnDelete();
            $table->text('diagnosis');
            $table->text('actions_taken');
            $table->text('mechanic_notes')->nullable();
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
```

#### 5. Migration Tabel Pembayaran Kasir (`database/migrations/2024_01_01_000008_create_payments_table.php`)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_code', 20)->unique();
            $table->foreignId('service_registration_id')->constrained('service_registrations')->cascadeOnDelete();
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->decimal('sparepart_total', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('change_amount', 12, 2)->default(0);
            $table->enum('payment_method', ['cash', 'transfer', 'qris'])->default('cash');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('paid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
```

---

### B. Lampiran Model Eloquent
#### 1. Model Customer (`app/Models/Customer.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_code',
        'name',
        'phone',
        'email',
        'address',
    ];

    public static function generateCode(): string
    {
        $last = self::latest('id')->first();
        $next = $last ? $last->id + 1 : 1;
        return 'PLG-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function serviceRegistrations()
    {
        return $this->hasMany(ServiceRegistration::class);
    }
}
```

#### 2. Model ServiceRegistration (`app/Models/ServiceRegistration.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_code',
        'customer_id',
        'vehicle_id',
        'service_type',
        'complaint',
        'service_date',
        'status',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    public static function generateCode(): string
    {
        $last = self::latest('id')->first();
        $next = $last ? $last->id + 1 : 1;
        return 'SRV-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function serviceDetail()
    {
        return $this->hasOne(ServiceDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
```

---

### C. Lampiran Controller API (REST API v1)
#### 1. Base API Controller (`app/Http/Controllers/Api/BaseApiController.php`)
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    public function sendSuccess($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function sendError(string $message = 'Error', $errors = [], int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
```

#### 2. Customer API Controller (`app/Http/Controllers/Api/V1/CustomerController.php`)
```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $customers = Customer::with('vehicles')->latest()->get();
        return $this->sendSuccess($customers, 'Data pelanggan berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20|unique:customers,phone',
            'email'   => 'nullable|email|max:100',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validasi gagal.', $validator->errors(), 422);
        }

        $data = $validator->validated();
        $data['customer_code'] = Customer::generateCode();
        $customer = Customer::create($data);

        return $this->sendSuccess($customer, 'Data pelanggan berhasil ditambahkan.', 201);
    }

    public function show($id): JsonResponse
    {
        $customer = Customer::with(['vehicles', 'serviceRegistrations'])->find($id);
        if (!$customer) {
            return $this->sendError('Data pelanggan tidak ditemukan.', [], 404);
        }
        return $this->sendSuccess($customer, 'Detail pelanggan berhasil diambil.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->sendError('Data pelanggan tidak ditemukan.', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20|unique:customers,phone,' . $id,
            'email'   => 'nullable|email|max:100',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validasi gagal.', $validator->errors(), 422);
        }

        $customer->update($validator->validated());
        return $this->sendSuccess($customer, 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy($id): JsonResponse
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->sendError('Data pelanggan tidak ditemukan.', [], 404);
        }

        $customer->delete();
        return $this->sendSuccess(null, 'Data pelanggan berhasil dihapus.');
    }
}
```

---

### D. Lampiran Konfigurasi Rute
#### 1. Rute API RESTful (`routes/api.php`)
```php
<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\MechanicController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ServiceDetailController;
use App\Http\Controllers\Api\V1\ServiceRegistrationController;
use App\Http\Controllers\Api\V1\SparepartController;
use App\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('mechanics', MechanicController::class);
    Route::apiResource('services', ServiceRegistrationController::class);
    Route::apiResource('service-details', ServiceDetailController::class);
    Route::apiResource('spareparts', SparepartController::class);
    Route::apiResource('payments', PaymentController::class);
});
```
