# 📚 BookVault — Sistem Manajemen Perpustakaan

Aplikasi manajemen perpustakaan berbasis web (PHP Native) dengan fitur peminjaman buku, manajemen member, kontrol akses berbasis grup, dan dukungan perangkat RFID.

---

## 📋 Daftar Isi

- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi XAMPP](#1-instalasi-xampp)
- [Setup Database](#2-setup-database)
- [Konfigurasi Aplikasi](#3-konfigurasi-aplikasi)
- [Menjalankan Aplikasi](#4-menjalankan-aplikasi)
- [Akun Default](#5-akun-default)
- [Struktur Folder](#6-struktur-folder)
- [Cara Kerja Aplikasi](#7-cara-kerja-aplikasi)
- [Fitur Aplikasi](#8-fitur-aplikasi)
- [Testing RFID dengan Reqable](#9-testing-rfid-dengan-reqable)
- [Troubleshooting](#10-troubleshooting)

---

## Persyaratan Sistem

| Komponen    | Versi Minimum              |
|-------------|----------------------------|
| XAMPP       | 8.0+ (dengan MariaDB 10.4+)|
| PHP         | 8.0+                       |
| MySQL       | 5.7+ / MariaDB 10.4+       |
| Browser     | Chrome / Firefox (terbaru) |

---

## 1. Instalasi XAMPP

### Langkah 1 — Download XAMPP

Kunjungi [https://www.apachefriends.org](https://www.apachefriends.org) dan download XAMPP sesuai sistem operasi:

- **Windows**: `xampp-windows-x64-8.x.x-installer.exe`
- **Linux**: `xampp-linux-x64-8.x.x-installer.run`
- **macOS**: `xampp-osx-8.x.x-installer.dmg`

### Langkah 2 — Install XAMPP

**Windows:**
1. Jalankan file installer sebagai Administrator
2. Pilih komponen: **Apache**, **MySQL**, **PHP**, **phpMyAdmin**
3. Ikuti proses instalasi hingga selesai
4. Default direktori instalasi: `C:\xampp\`

**Linux:**
```bash
chmod +x xampp-linux-x64-8.x.x-installer.run
sudo ./xampp-linux-x64-8.x.x-installer.run
```

**macOS:**
1. Mount file `.dmg` dan drag XAMPP ke folder Applications
2. Buka `/Applications/XAMPP/`

### Langkah 3 — Jalankan XAMPP

1. Buka **XAMPP Control Panel**
2. Klik tombol **Start** di baris **Apache**
3. Klik tombol **Start** di baris **MySQL**
4. Pastikan status keduanya berwarna **hijau**

> ⚠️ Jika port 80 atau 3306 sudah digunakan aplikasi lain, ubah port Apache atau MySQL di konfigurasi XAMPP.

---

## 2. Setup Database

### Langkah 1 — Buka phpMyAdmin

Buka browser dan akses:
```
http://localhost/phpmyadmin
```

### Langkah 2 — Buat Database

1. Klik **New** di panel kiri
2. Masukkan nama database: `db_perpus`
3. Pilih collation: `utf8mb4_general_ci`
4. Klik **Create**

### Langkah 3 — Import File SQL

1. Pilih database `db_perpus` di panel kiri
2. Klik tab **Import**
3. Klik **Choose File** → pilih file `db_perpus.sql`
4. Klik **Go** dan tunggu hingga proses selesai

File SQL ini akan membuat struktur tabel dan data awal secara otomatis.

### Struktur Database (Ringkasan)

| Tabel / View              | Keterangan                                           |
|---------------------------|------------------------------------------------------|
| `users`                   | Akun pengguna sistem                                 |
| `group_user`              | Grup/role pengguna (Super Admin, Admin, User)        |
| `user_access`             | Hak akses menu per grup                              |
| `menu`                    | Menu navigasi utama                                  |
| `sub_menu`                | Sub-menu navigasi                                    |
| `master_kategori`         | Kategori buku (Fiksi, Sains, Teknologi, dll.)        |
| `master_buku`             | Koleksi buku perpustakaan + kolom `uid` untuk RFID   |
| `member_perpus`           | Data anggota perpustakaan + kolom `uid` untuk RFID   |
| `transaksi_peminjaman`    | Header transaksi peminjaman                          |
| `detail_peminjaman`       | Detail buku per transaksi + denda keterlambatan      |
| `rfid_scans`              | Buffer hasil scan RFID (status: `new` / `used`)      |
| `vwmstuser`               | View gabungan users + group_user (untuk login)       |
| `vwmstbuku`               | View gabungan master_buku + kategori                 |
| `vwmstpeminjaman`         | View peminjaman lengkap dengan detail buku & denda   |
| `vwmstsubmenu`            | View sub_menu dengan nama menu induk                 |

---

## 3. Konfigurasi Aplikasi

### Langkah 1 — Salin Folder Aplikasi

Salin folder `lib-app` ke direktori htdocs XAMPP:

- **Windows**: `C:\xampp\htdocs\lib-app\`
- **Linux**: `/opt/lampp/htdocs/lib-app/`
- **macOS**: `/Applications/XAMPP/htdocs/lib-app/`

### Langkah 2 — Konfigurasi Database

Edit file `config/database.php`:

```php
<?php
$host = "localhost";   // Host database (default: localhost)
$user = "root";        // Username MySQL (default XAMPP: root)
$pass = "";            // Password MySQL (default XAMPP: kosong)
$db   = "db_perpus";  // Nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
```

### Langkah 3 — Konfigurasi .htaccess

File `.htaccess` di root aplikasi digunakan untuk URL routing. Pastikan **mod_rewrite** Apache aktif.

**Windows — aktifkan mod_rewrite:**
1. Buka `C:\xampp\apache\conf\httpd.conf`
2. Cari baris `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Hapus tanda `#` di depannya
4. Pastikan `AllowOverride All` tersetting untuk direktori htdocs:
   ```apache
   <Directory "C:/xampp/htdocs">
       AllowOverride All
   </Directory>
   ```
5. Restart Apache di XAMPP Control Panel

Isi `.htaccess` aplikasi (pastikan file ini sudah ada):
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

---

## 4. Menjalankan Aplikasi

1. Pastikan **Apache** dan **MySQL** sudah berjalan di XAMPP
2. Buka browser dan akses:

```
http://localhost/lib-app
```

3. Anda akan otomatis diarahkan ke halaman login:

```
http://localhost/lib-app/login
```

4. Login menggunakan akun yang tersedia (lihat [Akun Default](#5-akun-default))

---

## 5. Akun Default

Berikut akun yang sudah tersedia setelah import database:

| Username    | Password  | Grup         | Keterangan                              |
|-------------|-----------|--------------|-----------------------------------------|
| `kirfansyah`| `2222`    | Super Admin  | Akses penuh ke seluruh fitur            |
| `admin`     | `admin`   | Admin        | Akses ke master data & transaksi        |
| `USER`      | `USER1234`| User         | Akses terbatas (Peminjaman & Pengembalian) |

> ⚠️ **Catatan Keamanan:** Password disimpan dalam bentuk plain text di versi ini. Segera ubah password setelah login pertama, terutama di lingkungan produksi.

### Data Contoh yang Sudah Ada

Setelah import SQL, tersedia data contoh:
- **15 kategori buku** (Fiksi, Non-Fiksi, Komik, Sains, Teknologi, dll.)
- **17 judul buku** dengan UID RFID: `e211` s.d. `e227`
- **20 data member** dengan UID RFID: `111`, `222`, ..., `1122`, `11552`, dll.
- **Riwayat transaksi peminjaman** beserta detail dan denda

---

## 6. Struktur Folder

```
lib-app/
├── assets/                  # File statis (CSS, JS, gambar)
│   ├── css/                 # File stylesheet
│   ├── js/                  # File JavaScript
│   ├── img/                 # Gambar & ikon
│   └── plugins/             # Library pihak ketiga (Bootstrap, DataTables, dll.)
│
├── config/                  # Konfigurasi aplikasi
│   ├── database.php         # Koneksi database MySQL
│   ├── config.php           # Konfigurasi umum & pengecekan session
│   ├── routes.php           # Daftar routing URL → file handler
│   ├── functions.php        # Fungsi helper
│   ├── check_access.php     # Pengecekan hak akses menu
│   └── session_check.php    # Pengecekan sesi login
│
├── model/                   # Logic & query database
│   ├── auth/
│   │   ├── verify_login.php # Proses autentikasi login
│   │   └── logout.php       # Proses logout & destroy session
│   ├── master/
│   │   ├── user/            # CRUD tabel users
│   │   ├── grup-user/       # CRUD group_user + grant/revoke akses
│   │   ├── menu/            # CRUD tabel menu & sub_menu
│   │   ├── kategori/        # CRUD master_kategori
│   │   └── buku/            # CRUD master_buku
│   ├── transaksi/
│   │   ├── member/          # CRUD member_perpus
│   │   └── peminjaman/      # CRUD transaksi_peminjaman & detail_peminjaman
│   └── rfid/
│       ├── scan.php         # Endpoint penerima scan RFID (POST)
│       ├── get_scan.php     # Polling hasil scan (GET)
│       ├── get_member_scan.php # Ambil data member berdasarkan UID
│       └── get_buku_scan.php   # Ambil data buku berdasarkan UID
│
├── views/                   # Tampilan halaman
│   ├── auth/login.php       # Halaman login
│   ├── index.php            # Dashboard
│   ├── master/              # Halaman-halaman master data
│   ├── transaksi/           # Halaman transaksi
│   └── templates/           # Komponen template (header, sidebar, footer)
│
├── index.php                # Entry point & router utama
├── .htaccess                # Konfigurasi URL rewriting Apache
├── 403.php                  # Halaman forbidden
└── 404.php                  # Halaman not found
```

---

## 7. Cara Kerja Aplikasi

### Sistem Routing

Aplikasi menggunakan **custom router** tanpa framework. Setiap request HTTP masuk ke `index.php`, lalu dicocokkan dengan daftar route di `config/routes.php`.

```
Browser Request
    → index.php
    → cocokkan URI dengan routes.php
    → include file views/ atau model/
```

Contoh: akses `/master-buku` akan me-load `views/master/buku/index.php`.

### Sistem Autentikasi

```
User isi form login
    → POST /verify-login
    → Query ke view vwmstuser (gabungan users + group_user)
    → Jika cocok: simpan ke $_SESSION (user_id, username, group_user_id, dll.)
    → Redirect ke dashboard (/)
    → Jika gagal: tampilkan pesan error
```

Setiap halaman yang membutuhkan login memanggil `config/config.php` yang mengecek `$_SESSION['user_id']`. Jika tidak ada sesi → redirect ke `/login`.

### Sistem Kontrol Akses (RBAC)

```
User login → group_user_id tersimpan di session
    → Setiap akses halaman → cek tabel user_access
    → Jika group punya akses → tampilkan halaman
    → Jika tidak → redirect ke /forbidden-accesss (403)
```

Manajemen akses dilakukan di menu **Master Grup User** — administrator dapat grant/revoke akses per sub-menu untuk setiap grup.

### Alur Transaksi Peminjaman

```
1. Pilih Member (scan RFID kartu member atau pilih manual)
2. Scan / pilih Buku yang akan dipinjam (bisa lebih dari 1)
3. Tentukan tanggal pinjam & estimasi tanggal kembali
4. Simpan → insert ke transaksi_peminjaman + detail_peminjaman
           → status: 'dipinjam', stok buku berkurang

5. Saat pengembalian → update detail_peminjaman:
   - status: 'dikembalikan'
   - tanggal_kembali diisi
   - denda dihitung otomatis jika terlambat
   - stok buku bertambah kembali
```

### Sistem Denda

Denda keterlambatan dihitung berdasarkan selisih hari antara `tanggal_pengembalian_seharusnya` dan `tanggal_kembali` aktual. Total denda per transaksi dijumlahkan dari semua detail buku via view `vwmstpeminjaman`.

---

## 8. Fitur Aplikasi

### Master Data

| Menu             | Sub-menu / Halaman         | URL                  | Keterangan                               |
|------------------|----------------------------|----------------------|------------------------------------------|
| **Master**       | Master User                | `/master-user`       | Kelola akun pengguna sistem              |
|                  | Master Group User          | `/master-grup-user`  | Kelola role + grant/revoke akses menu    |
|                  | Master Menu                | `/master-menu`       | Kelola menu & sub-menu navigasi          |
|                  | Master Kategori Buku       | `/master-kategori`   | Kelola kategori buku                     |
|                  | Master Buku                | `/master-buku`       | Kelola koleksi buku + UID RFID           |
| **Transaksi**    | Member                     | `/member-perpus`     | Registrasi & kelola anggota + UID RFID   |
|                  | Peminjaman & Pengembalian  | `/peminjaman-buku`   | Catat peminjaman, pengembalian & denda   |

### Grup & Hak Akses Default

| Grup        | Akses                                                                 |
|-------------|-----------------------------------------------------------------------|
| Super Admin | Master User, Master Group User, Master Menu, Master Kategori, Master Buku |
| Admin       | Master User, Master Group User, Master Menu, Master Kategori, Master Buku, Member, Peminjaman |
| User        | Peminjaman & Pengembalian saja                                        |

---

## 9. Testing RFID dengan Reqable

Untuk mensimulasikan scan RFID tanpa perangkat fisik, gunakan aplikasi **Reqable** di Android (atau tool HTTP client lainnya seperti Postman/Insomnia).

### Endpoint RFID

| Method | Endpoint                                    | Keterangan                         |
|--------|---------------------------------------------|------------------------------------|
| POST   | `http://<IP_SERVER>/lib-app/rfid-scan`      | Kirim hasil scan UID ke server     |
| GET    | `http://<IP_SERVER>/lib-app/rfid-get`       | Ambil scan terbaru (polling)       |
| GET    | `http://<IP_SERVER>/lib-app/rfid-get-member`| Cari data member berdasarkan UID   |
| GET    | `http://<IP_SERVER>/lib-app/rfid-get-buku`  | Cari data buku berdasarkan UID     |

> Ganti `<IP_SERVER>` dengan IP komputer yang menjalankan XAMPP (contoh: `192.168.1.10`). Pastikan Android dan PC berada di **jaringan WiFi yang sama**.

---

### Cara Mengetahui IP Server

**Windows:**
```
Buka Command Prompt → ketik: ipconfig
Lihat bagian "IPv4 Address" (contoh: 192.168.1.10)
```

**Linux/macOS:**
```bash
ip addr show
# atau
hostname -I
```

---

### Testing Scan Member

Kirim POST request untuk mensimulasikan scan kartu member:

```
Method : POST
URL    : http://192.168.1.10/lib-app/rfid-scan
Headers: Content-Type: application/json
Body   :
{
    "uid": "1122"
}
```

**Contoh respons sukses:**
```json
{
    "status": true,
    "type": "member",
    "uid": "1122"
}
```

UID `1122` merujuk ke member: **Jasmine Putri** (data sudah tersedia setelah import SQL).

---

### Testing Scan Buku

Kirim POST request untuk mensimulasikan scan tag RFID buku:

```
Method : POST
URL    : http://192.168.1.10/lib-app/rfid-scan
Headers: Content-Type: application/json
Body   :
{
    "uid": "e214"
}
```

**Contoh respons sukses:**
```json
{
    "status": true,
    "type": "buku",
    "uid": "e214"
}
```

UID `e214` merujuk ke buku: **The Elegant Universe** - Brian Greene.

---

### Logika Deteksi Tipe RFID

Server mendeteksi tipe UID secara otomatis berdasarkan **awalan karakter**:

| Kondisi                          | Tipe   | Contoh UID                   |
|----------------------------------|--------|------------------------------|
| UID **dimulai dengan `e2`**      | `buku` | `e211`, `e214`, `e222`, dll. |
| UID **tidak dimulai dengan `e2`**| `member` | `1122`, `111`, `333`, dll. |

Hasil scan disimpan ke tabel `rfid_scans` dengan status `new`. Aplikasi web kemudian polling endpoint `/rfid-get` secara berkala untuk mengambil scan terbaru dan auto-fill form peminjaman.

---

### Referensi UID Data Sample

**Member (UID tidak diawali `e2`):**

| UID    | Nama Member       |
|--------|-------------------|
| `111`  | Andi Santoso      |
| `333`  | Citra Dewi        |
| `444`  | Dewi Lestari      |
| `555`  | Eko Kurniawan     |
| `666`  | Fanny Lestari     |
| `777`  | Gilang Ramesh     |
| `888`  | Hannah Putri      |
| `999`  | Indra Wijaya      |
| `1122` | Jasmine Putri     |

**Buku (UID diawali `e2`):**

| UID    | Judul Buku                                         |
|--------|----------------------------------------------------|
| `e211` | Harry Potter dan Batu Bertuah                      |
| `e212` | The Selfish Gene                                   |
| `e213` | Naruto: The Great Ninja War                        |
| `e214` | The Elegant Universe                               |
| `e215` | Introduction to Algorithms                         |
| `e216` | The History of Time                                |
| `e217` | Belajar Matematika Dasar                           |
| `e218` | Thinking, Fast and Slow                            |
| `e219` | The Diary of a Young Girl                          |
| `e220` | Sherlock Holmes: The Hound of the Baskervilles     |
| `e221` | Pride and Prejudice                                |
| `e222` | The Quran                                          |
| `e223` | The Art of Happiness                               |
| `e224` | P.S. I Love You                                    |
| `e225` | The Lion, the Witch and the Wardrobe               |

---

### Alur Testing Peminjaman via RFID di Reqable

1. **Scan member** → POST `/rfid-scan` dengan `uid: "1122"`
2. **Scan buku pertama** → POST `/rfid-scan` dengan `uid: "e211"`
3. **Scan buku kedua (opsional)** → POST `/rfid-scan` dengan `uid: "e214"`
4. **Buka halaman Peminjaman** di browser → `http://localhost/lib-app/peminjaman-buku`
5. Aplikasi akan otomatis **mendeteksi scan** dan mengisi form member & buku

---

## 10. Troubleshooting

### ❌ Halaman tidak ditemukan (404)

**Penyebab:** mod_rewrite tidak aktif atau `.htaccess` tidak terbaca.

**Solusi:**
1. Aktifkan `mod_rewrite` di `httpd.conf` (lihat [Langkah 3 Konfigurasi](#langkah-3--konfigurasi-htaccess))
2. Pastikan `AllowOverride All` diset untuk direktori htdocs
3. Restart Apache

---

### ❌ Koneksi database gagal

**Penyebab:** Konfigurasi database salah atau MySQL belum berjalan.

**Solusi:**
1. Pastikan MySQL sudah **Start** di XAMPP Control Panel
2. Cek kembali `config/database.php` — nama database harus `db_perpus`
3. Verifikasi di phpMyAdmin bahwa database sudah ada dan semua tabel ter-import

---

### ❌ Login selalu gagal

**Penyebab:** View `vwmstuser` belum dibuat atau username/password salah.

**Solusi:**
1. Pastikan view `vwmstuser` ada (cek di phpMyAdmin → Views)
2. Coba query manual di phpMyAdmin:
   ```sql
   SELECT * FROM vwmstuser WHERE username = 'admin';
   ```
3. Username dan password bersifat **case-sensitive**: `admin`/`admin`, bukan `Admin`/`Admin`

---

### ❌ Error 403 Forbidden setelah login

**Penyebab:** Grup user belum memiliki akses ke menu yang dituju.

**Solusi:**
1. Login menggunakan akun `kirfansyah` (Super Admin) yang punya akses penuh
2. Masuk ke **Master → Master Group User**
3. Klik grup yang bermasalah → atur akses sub-menu yang diperlukan

---

### ❌ RFID tidak terdeteksi di aplikasi

**Penyebab:** Request dari Reqable tidak sampai ke server, atau salah endpoint.

**Solusi:**
1. Pastikan Android dan PC di **jaringan WiFi yang sama**
2. Cek IP server: buka CMD → `ipconfig` → catat IPv4 Address
3. Pastikan URL benar: `http://<IP_PC>/lib-app/rfid-scan` (bukan `localhost`)
4. Header **Content-Type: application/json** wajib disertakan
5. Verifikasi data masuk ke database:
   ```sql
   SELECT * FROM rfid_scans ORDER BY id DESC LIMIT 5;
   ```

---

### ❌ RFID scan masuk ke database tapi tidak auto-fill di form

**Penyebab:** Status scan sudah `used` atau UID tidak cocok dengan data master.

**Solusi:**
1. Cek status di `rfid_scans` — harus `new` agar diambil oleh aplikasi
2. Pastikan UID yang dikirim **persis sama** dengan kolom `uid` di `master_buku` atau `member_perpus`
3. Untuk buku: pastikan UID dimulai dengan `e2` (contoh: `e211`, bukan `E211`)

---

## 📝 Catatan Pengembang

- Aplikasi menggunakan **PHP Native** tanpa framework MVC
- Database engine: **MariaDB 10.4** (kompatibel dengan MySQL 5.7+), charset `utf8mb4`
- Query database menggunakan **MySQLi** — belum menggunakan prepared statement (perhatikan keamanan untuk production)
- Password user disimpan dalam **plain text** — implementasikan `password_hash()` sebelum digunakan di production
- File `.htaccess` krusial untuk routing — jangan dihapus saat deployment

---

*Dokumentasi ini dibuat untuk memudahkan proses setup dan penggunaan aplikasi BookVault di lingkungan lokal (XAMPP).*
