# 📖 Dokumentasi Kode — BookVault

Dokumen ini menjelaskan **setiap file dalam aplikasi BookVault** secara mendetail: fungsinya, cara kerjanya, query yang digunakan, dan bagaimana antar-file saling terhubung.

---

## 📋 Daftar Isi

1. [Gambaran Umum Arsitektur](#1-gambaran-umum-arsitektur)
2. [Entry Point — index.php](#2-entry-point--indexphp)
3. [Folder config/ — Konfigurasi & Utilitas](#3-folder-config--konfigurasi--utilitas)
4. [Folder model/auth/ — Autentikasi](#4-folder-modelauth--autentikasi)
5. [Folder model/master/ — Master Data](#5-folder-modelmaster--master-data)
6. [Folder model/transaksi/ — Transaksi](#6-folder-modeltransaksi--transaksi)
7. [Folder model/rfid/ — Integrasi RFID](#7-folder-modelrfid--integrasi-rfid)
8. [Folder views/ — Tampilan Halaman](#8-folder-views--tampilan-halaman)
9. [Pola Komunikasi AJAX](#9-pola-komunikasi-ajax)
10. [Diagram Alur Data](#10-diagram-alur-data)

---

## 1. Gambaran Umum Arsitektur

BookVault menggunakan arsitektur **PHP Native MVC-like** tanpa framework. Pola yang digunakan:

```
Browser
  │
  ▼
index.php  ◄── Router utama
  │
  ├── views/     ◄── Halaman HTML + JavaScript (frontend)
  │     └── Mengirim AJAX request ke model/
  │
  ├── model/     ◄── Logic bisnis + query database (backend API)
  │     └── Mengembalikan JSON response
  │
  └── config/    ◄── Koneksi DB, session, fungsi helper
```

**Pola request-response:**

```
User klik tombol di halaman
  → JavaScript (AJAX / fetch)
  → POST/GET ke endpoint model/
  → model/ query ke MySQL
  → return JSON { status, data/message }
  → JavaScript update tampilan
```

---

## 2. Entry Point — `index.php`

**Lokasi:** `/index.php`  
**Fungsi:** Pintu masuk utama semua request. Bertanggung jawab meneruskan request ke file yang tepat.

```php
$routes = include('config/routes.php');   // Muat daftar semua route
$request_uri = $_SERVER['REQUEST_URI'];   // Ambil URL yang diminta
$base_path = dirname($_SERVER['SCRIPT_NAME']); // Deteksi subfolder otomatis
$request_uri = str_replace($base_path, '', $request_uri); // Hapus prefix subfolder
$request_uri = strtok($request_uri, '?'); // Buang query string
```

**Cara kerja routing:**

```
Request: GET /lib-app/master-buku
   ↓
base_path = /lib-app
request_uri setelah strip = /master-buku
   ↓
Cari di routes.php: '/master-buku' => 'views/master/buku/index.php'
   ↓
include 'views/master/buku/index.php'
```

**Dukungan parameter dinamis:**

```php
// Route dengan {id}: '/get-grup-user-by-uuid/{id}'
// Dikonversi ke regex: #^/get-grup-user-by-uuid/([^/]+)$#
// Parameter tersimpan di $_GET['params'][0]
$pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $route);
```

**Jika URL tidak cocok:** include `404.php`

---

## 3. Folder `config/` — Konfigurasi & Utilitas

### 3.1 `config/database.php`

**Fungsi:** Membuka koneksi ke database MySQL/MariaDB.

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_perpus";
$conn = mysqli_connect($host, $user, $pass, $db);
```

**Digunakan oleh:** Hampir semua file di `model/` dengan cara `require_once`.  
**Variabel yang dihasilkan:** `$conn` — object koneksi MySQLi yang digunakan untuk semua query.

---

### 3.2 `config/config.php`

**Fungsi:** Konfigurasi global aplikasi. File ini **wajib diinclude di semua halaman view** karena melakukan pengecekan session login.

**Yang dilakukan file ini:**

1. Include `database.php` untuk koneksi DB
2. Start session PHP
3. Hitung `$baseUrl` secara dinamis (mendukung subfolder apapun)
4. Cek apakah user sudah login — jika belum, redirect ke `/login`

```php
// Hitung base URL otomatis
$baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http")
         . "://" . $_SERVER['HTTP_HOST']
         . dirname($_SERVER['SCRIPT_NAME']) . "/";

// Paksa login jika belum ada session
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $baseUrl . 'login');
    exit();
}
```

**Mengapa `$baseUrl` penting?**  
Agar URL aset (CSS, JS, gambar) dan link navigasi selalu benar, baik diakses di `localhost/lib-app` maupun `localhost/perpustakaan` atau subdomain lain.

---

### 3.3 `config/routes.php`

**Fungsi:** Mendefinisikan semua route (peta URL → file) aplikasi.  
**Format:** Array asosiatif `'URL' => 'path/ke/file.php'`

```php
return [
    '/'                  => 'views/index.php',         // Dashboard
    '/login'             => 'views/auth/login.php',    // Halaman login
    '/master-buku'       => 'views/master/buku/index.php',
    '/get-buku'          => 'model/master/buku/get_buku.php',  // API endpoint
    '/add-buku'          => 'model/master/buku/add_buku.php',  // API endpoint
    // ...dst
];
```

**Dua jenis route:**
- **View route** → file di `views/` → menampilkan halaman HTML
- **API route** → file di `model/` → mengembalikan JSON (dipanggil via AJAX)

---

### 3.4 `config/functions.php`

**Fungsi:** Kumpulan fungsi helper yang dipakai di seluruh aplikasi.

| Fungsi | Parameter | Return | Penjelasan |
|--------|-----------|--------|------------|
| `check_access($role_id, $menu_id, $sub_menu_id)` | ID role, menu, sub-menu | `bool` | Cek apakah role punya akses ke menu |
| `executeQuery($conn, $query)` | Koneksi, query string | `mysqli_result` | Jalankan query, auto-die jika error |
| `sanitizeUrl($baseUrl, $relativeUrl)` | Base URL, relative URL | `string` | Gabung & escape URL dengan aman |
| `formatUrlLabel($url)` | URL string | `string` | Ubah `/master-buku` → `Master buku` untuk breadcrumb |
| `generateUUIDv4()` | - | `string` | Generate UUID v4 secara kriptografis aman |

**Detail `generateUUIDv4()`:**

```php
function generateUUIDv4() {
    $data = random_bytes(16);           // 16 byte acak
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set versi 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set variant bits
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    // Output: "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx"
}
```

---

### 3.5 `config/check_access.php`

**Fungsi:** Middleware pengecekan hak akses halaman. Diinclude di setiap halaman view yang butuh proteksi akses.

**Cara kerja:**

```
1. Ambil URL halaman saat ini (current_page)
2. Ambil group_user_id dari $_SESSION
3. Query ke user_access: apakah grup ini punya akses ke URL ini?
   - Cek di tabel menu
   - UNION cek di tabel sub_menu
   - UNION selalu allow untuk '/' (dashboard)
4. Jika tidak ada hasil → redirect ke /forbidden-accesss (403)
```

**Query pengecekan:**

```sql
SELECT DISTINCT m.url FROM user_access ua
JOIN menu m ON ua.menu_id = m.id
WHERE ua.group_user_id = '$role_id' AND m.url = '$current_page'

UNION ALL

SELECT DISTINCT sm.url FROM user_access ua
JOIN sub_menu sm ON ua.sub_menu_id = sm.id
WHERE ua.group_user_id = '$role_id' AND sm.url = '$current_page'

UNION ALL

SELECT '/' AS url WHERE EXISTS (
    SELECT 1 FROM user_access ua
    WHERE ua.group_user_id = '1' AND '/' = '$current_page'
)
```

---

### 3.6 `config/session_check.php`

**Fungsi:** Endpoint kecil yang dicek oleh JavaScript secara berkala untuk memastikan session masih aktif.

```php
if (!isset($_SESSION['user_id'])) {
    echo "expired";   // Session sudah habis
} else {
    echo "active";    // Session masih ada
}
```

**Kapan digunakan:** JavaScript frontend bisa polling endpoint ini setiap beberapa menit. Jika response "expired", paksa redirect ke halaman login.

---

## 4. Folder `model/auth/` — Autentikasi

### 4.1 `model/auth/verify_login.php`

**Route:** `POST /verify-login`  
**Fungsi:** Memverifikasi username & password, lalu menyimpan data ke session jika valid.

**Alur lengkap:**

```
1. Terima $_POST['username'] dan $_POST['password']
2. Query ke VIEW vwmstuser (bukan tabel langsung):
   SELECT * FROM vwmstuser WHERE username='...' AND password='...' AND is_active=1
3. Jika ada hasil (num_rows > 0):
   - Simpan ke $_SESSION:
     * user_id       → untuk identifikasi user
     * username      → untuk audit trail (createdBy, updatedBy)
     * full_name     → untuk ditampilkan di UI
     * group_user_id → untuk pengecekan akses menu
     * id_number     → nomor identitas karyawan/pengguna
     * leveluser     → nama grup (Super Admin, Admin, dll.)
   - Return JSON: { "status": "success", "full_name": "..." }
4. Jika tidak ada hasil:
   - Return JSON: { "status": "error", "message": "Invalid username or password!" }
```

> **Catatan:** Password saat ini disimpan & dicocokkan sebagai plain text. Untuk keamanan production, gunakan `password_hash()` saat simpan dan `password_verify()` saat cek.

---

### 4.2 `model/auth/logout.php`

**Route:** `GET /logout`  
**Fungsi:** Menghapus semua data session dan mengarahkan user ke halaman login.

```php
session_start();
session_destroy();    // Hapus semua data session
// Redirect ke halaman login
header("Location: " . $baseUrl . 'login');
```

---

## 5. Folder `model/master/` — Master Data

### 5.1 Master User (`model/master/user/`)

File-file ini mengelola tabel `users` dan view `vwmstuser`.

---

#### `get_users.php`
**Route:** `GET /get-users`  
**Fungsi:** Mengambil semua data user untuk ditampilkan di DataTable.

**Yang dikembalikan:** Array JSON format DataTables (kolom: No, Nama, ID Number, Username, Password (tersembunyi), Level User, Created By, Updated By, Status, Aksi)

```php
// Password tidak pernah ditampilkan — diganti bintang
$password = str_repeat('*', 8); // → "********"

// Status tampil sebagai badge HTML berwarna
$is_active = $row['is_active'] == 1
    ? '<span class="badges bg-lightgreen">Active</span>'
    : '<span class="badges bg-lightred">Non-active</span>';
```

**Query:** `SELECT * FROM vwmstuser` (view yang sudah join users + group_user)

---

#### `add_user.php`
**Route:** `POST /add-user`  
**Fungsi:** Menambahkan user baru ke tabel `users`.

**Data yang diterima (POST):**
- `name` — nama lengkap
- `id_number` — nomor ID karyawan
- `username` — username login
- `password` — password (plain text)
- `group_user_id` — ID grup/role
- `is_active` — status aktif (1/0)

**Proses:**
1. Generate UUID v4 baru menggunakan `generateUUIDv4()`
2. Insert ke tabel `users`
3. `createdBy` diisi dari `$_SESSION['username']`

---

#### `update_user.php`
**Route:** `POST /update-user`  
**Fungsi:** Mengupdate data user yang ada. Hanya bisa dipanggil via POST.

**Perbedaan dengan `add_user.php`:**
- Menerima `id` sebagai identifier
- Menggunakan `UPDATE` bukan `INSERT`
- Mengisi `updatedBy` dari session
- Menggunakan `mysqli_real_escape_string()` untuk sanitasi input

---

#### `delete_user.php`
**Route:** `POST /delete-user`  
**Fungsi:** Menghapus user berdasarkan `id`.

**Validasi:** Cek apakah `$_POST['id']` ada dan tidak kosong sebelum eksekusi DELETE.

---

#### `get_user_by_id.php`
**Route:** `POST /get-user-by-id`  
**Fungsi:** Mengambil data satu user untuk mengisi form edit (modal).

**Return:** `{ "status": "success", "data": { ...data user... } }`

---

#### `check_user.php`
**Route:** `POST /check-user`  
**Fungsi:** Mengecek apakah username sudah terdaftar (untuk validasi form sebelum submit).

**Query:** `SELECT * FROM vwmstuser WHERE username='$username'`  
**Return:** `success` jika ditemukan, `error` jika tidak ada.

---

### 5.2 Master Grup User (`model/master/grup-user/`)

Mengelola tabel `group_user` dan `user_access` (hak akses menu per grup).

---

#### `add_grup_user.php`
**Route:** `POST /add-grup-user`  
**Fungsi:** Membuat grup/role baru.

**Data POST:** `name`, `is_active`  
**Proses:** Generate UUID → INSERT ke `group_user`

---

#### `get_grup_user.php`
**Route:** `GET /get-grup-user`  
**Fungsi:** Ambil semua grup untuk DataTable (kecuali Super Admin, ID=1 dikecualikan).

```sql
SELECT * FROM group_user WHERE id <> 1
```

**Kolom aksi:** Setiap baris punya tombol View (lihat akses), Edit, Delete.  
Tombol View mengarah ke `/get-grup-user-by-uuid/{uuid}` — halaman manajemen akses per grup.

---

#### `get_grup_user_by_id.php` & `get_grup_user_by_uuid.php`
**Fungsi:** Ambil data satu grup — by `id` untuk form edit, by `uuid` untuk halaman detail akses.

---

#### `grant_access.php`
**Route:** `POST /grant-access`  
**Fungsi:** Memberikan akses menu/sub-menu kepada sebuah grup.

**Alur:**
```
1. Terima: group_user_id, menu_id, sub_menu_id
2. CEK apakah akses sudah ada di user_access
3. Jika BELUM ada → INSERT ke user_access
4. Jika SUDAH ada → tidak lakukan apapun (idempotent)
5. Return: { "status": "success" }
```

---

#### `revoke_access.php`
**Route:** `POST /revoke-access`  
**Fungsi:** Mencabut akses menu/sub-menu dari sebuah grup.

```sql
DELETE FROM user_access
WHERE group_user_id = $group_user_id
AND menu_id = $menu_id
AND sub_menu_id = $sub_menu_id
```

---

#### `check_access.php`
**Route:** `GET /check-access?group_user_id=X`  
**Fungsi:** Mengambil semua akses yang dimiliki sebuah grup (untuk render checkbox di halaman manajemen akses).

**Return:** Array of `{ menu_id, sub_menu_id }` — digunakan JavaScript untuk menandai checkbox yang sudah dicentang.

---

### 5.3 Master Menu (`model/master/menu/`)

Mengelola tabel `menu` dan `sub_menu` — struktur navigasi sidebar dinamis.

---

#### `get_menu.php` & `get_menus.php`
- `get_menu.php` → ambil tabel `menu` untuk DataTable
- `get_menus.php` → ambil semua menu dalam format ringan (untuk dropdown di form tambah sub-menu)

#### `add_menu.php`
**Route:** `POST /add-menu`  
**Fungsi:** Tambah menu utama baru.

**Data POST:** `name`, `icon` (kode feather icon), `url`, `ordinal_number` (urutan tampil), `is_active`

#### `add_sub_menu.php`
**Route:** `POST /add-sub-menu`  
**Fungsi:** Tambah sub-menu baru yang terhubung ke menu induk.

**Data POST:** `menu_id`, `name`, `icon`, `url`, `ordinal_number`, `is_active`

**Relasi:** Sub-menu memiliki `menu_id` sebagai foreign key ke tabel `menu`.

---

### 5.4 Master Kategori (`model/master/kategori/`)

Mengelola tabel `master_kategori` — kategori pengelompokan buku.

---

#### `get_kategori.php`
**Route:** `GET /get-kategori`  
**Fungsi:** Ambil semua kategori untuk DataTable (termasuk yang tidak aktif).

#### `add_kategori.php`
**Route:** `POST /add-kategori`  
**Data POST:** `nama_kategori`, `is_active`

#### `get_kategori_by_id.php`
**Route:** `POST /get-kategori-by-id`  
**Fungsi:** Ambil satu kategori untuk form edit.

---

### 5.5 Master Buku (`model/master/buku/`)

Mengelola tabel `master_buku` — koleksi buku perpustakaan beserta stok dan UID RFID.

---

#### `get_buku.php`
**Route:** `GET /get-buku`  
**Fungsi:** Ambil semua buku untuk DataTable.

**Query:** `SELECT * FROM vwmstbuku` (view yang join `master_buku` + `master_kategori`, filter `is_active=1`)

**Kolom yang ditampilkan:** No, Judul, Penulis, Penerbit, Tahun Terbit, Kategori, Stok, Created By, Updated By, Status, Aksi

#### `get_bukus.php`
**Route:** `GET /get-bukus`  
**Fungsi:** Ambil daftar buku dalam format ringan untuk **dropdown peminjaman** (hanya id_buku dan judul_buku, filter stok > 0).

#### `add_buku.php`
**Route:** `POST /add-buku`  
**Fungsi:** Menambahkan buku baru ke koleksi. Memiliki validasi UID unik.

**Alur:**
```
1. Terima POST: uid, judul_buku, penulis, penerbit,
                tahun_terbit, id_kategori, stok, is_active
2. CEK apakah uid sudah dipakai buku lain:
   SELECT id_buku FROM master_buku WHERE uid = '$uid' LIMIT 1
3. Jika UID sudah ada → return error "UID sudah digunakan"
4. Jika UID belum ada → INSERT ke master_buku
5. Return: { "status": "success/error", "message": "..." }
```

**Mengapa cek UID duplikat?** Setiap tag RFID fisik punya UID unik. Satu tag tidak boleh mewakili dua buku berbeda.

#### `update_buku.php`
**Route:** `POST /update-buku`  
**Fungsi:** Update data buku (judul, penulis, penerbit, dll). **UID tidak diupdate** di sini untuk mencegah salah pasang tag RFID.

#### `delete_buku.php`
**Route:** `POST /delete-buku`  
**Fungsi:** Hapus buku. Validasi keberadaan `id_buku` sebelum DELETE.

#### `get_buku_by_id.php`
**Route:** `POST /get-buku-by-id`  
**Fungsi:** Ambil data satu buku untuk form edit modal.

#### `get_kategori_buku.php`
**Route:** `GET /get-kategori-buku`  
**Fungsi:** Ambil daftar kategori yang aktif untuk **dropdown** di form tambah/edit buku.

---

## 6. Folder `model/transaksi/` — Transaksi

### 6.1 Member Perpustakaan (`model/transaksi/member/`)

Mengelola tabel `member_perpus` — data anggota perpustakaan.

---

#### `get_member.php`
**Route:** `GET /get-member`  
**Fungsi:** Ambil semua member untuk DataTable (semua status, termasuk non-aktif).

**Kolom:** No, UID, Nama, Email, No HP, Alamat, Created By, Updated By, Status, Aksi

#### `get_members.php`
**Route:** `GET /get-members`  
**Fungsi:** Ambil daftar member aktif dalam format ringan untuk **dropdown peminjaman**.

```sql
SELECT * FROM member_perpus WHERE is_active = 1 ORDER BY id_member
```

**Return:** `{ "status": "success", "data": [...] }` — array lengkap semua field member.

#### `add_member.php`
**Route:** `POST /add-member`  
**Fungsi:** Mendaftarkan anggota baru perpustakaan.

**Alur:**
```
1. Terima POST: nama_member, email, no_hp, alamat, uid, is_active
2. CEK apakah uid sudah dipakai member lain:
   SELECT id_member FROM member_perpus WHERE uid = '$uid'
3. Jika UID duplikat → return error "UID sudah terdaftar!"
4. Jika UID unik → INSERT ke member_perpus
```

**Mengapa cek UID unik?** Satu kartu RFID (misal kartu KTM/ID card) hanya boleh dimiliki satu anggota.

#### `update_member.php`
**Route:** `POST /update-member`  
**Fungsi:** Update data anggota (nama, email, no HP, alamat, status).

#### `delete_member.php`
**Route:** `POST /delete-member`  
**Fungsi:** Hapus data anggota.

#### `get_member_by_id.php`
**Route:** `POST /get-member-by-id`  
**Fungsi:** Ambil data satu member berdasarkan `id_member` untuk form edit.

#### `get_member_by_uid.php`
**Route:** `POST /get-member-by-uid` (juga dipanggil dari rfid flow)  
**Fungsi:** Cari member berdasarkan UID RFID.

```sql
SELECT * FROM member_perpus WHERE uid = '$uid'
```

**Digunakan saat:** Admin input UID RFID manual di form, atau sebagai fallback saat integrasi RFID.

---

### 6.2 Peminjaman Buku (`model/transaksi/peminjaman/`)

Mengelola tabel `transaksi_peminjaman` (header) dan `detail_peminjaman` (detail per buku), dengan kalkulasi denda otomatis.

---

#### `get_loans.php`
**Route:** `GET /get-loans`  
**Fungsi:** Ambil semua transaksi peminjaman untuk DataTable.

**Query:** `SELECT * FROM vwmstpeminjaman ORDER BY id_peminjaman DESC`

**View `vwmstpeminjaman` menggabungkan:**
- Header transaksi (id, member, tanggal, status)
- Nama member dari `member_perpus`
- Detail buku via `GROUP_CONCAT` — semua buku dalam satu transaksi digabung dengan separator `;;`
- Total denda (`SUM(denda)`)

**Parsing `detail_buku` di PHP:**

```php
// Format dari GROUP_CONCAT:
// "id_detail|id_buku|judul|status|tgl_kembali|denda;;id_detail|..."
$bukus = explode(';;', $row['detail_buku']); // Pisah per buku
foreach ($bukus as $b) {
    $parts = explode('|', $b); // Pisah tiap field
    $judul  = $parts[2]; // Index 2 = judul
    $status = $parts[3]; // Index 3 = status
}
```

#### `add_loan.php`
**Route:** `POST /add-loan`  
**Fungsi:** Membuat transaksi peminjaman baru (support multi-buku dalam satu transaksi).

**Data POST:**
- `id_member` — ID anggota peminjam
- `id_buku[]` — Array ID buku (bisa lebih dari 1)
- `tanggal_pinjam` — Tanggal pinjam
- `tanggal_pengembalian_seharusnya` — Estimasi tanggal kembali

**Alur lengkap (transaction-like):**

```
1. VALIDASI: id_member & id_buku[] tidak boleh kosong
2. CEK STOK untuk setiap buku:
   SELECT stok FROM master_buku WHERE id_buku = X
   → Jika tidak ada buku → error
   → Jika stok = 0 → error "Stok buku habis"
3. INSERT HEADER ke transaksi_peminjaman:
   status = 'dipinjam', createdBy = session username
   → Simpan id_peminjaman yang baru dibuat (mysqli_insert_id)
4. Untuk setiap buku (loop):
   a. INSERT DETAIL ke detail_peminjaman (id_peminjaman, id_buku)
   b. KURANGI STOK: UPDATE master_buku SET stok = stok - 1
5. Return: { "status": "success" }
```

**Duplikat buku dicegah:** `array_unique()` sebelum loop memastikan buku yang sama tidak muncul dua kali dalam satu transaksi.

#### `update_loan.php`
**Route:** `POST /update-loan`  
**Fungsi:** Proses pengembalian buku. Support pengembalian parsial (sebagian buku dikembalikan, sebagian masih dipinjam).

**Data POST:**
- `id_peminjaman` — ID transaksi
- `id_detail[]` — Array ID detail (buku mana yang dikembalikan, dicentang di form)

**Alur lengkap:**

```
1. Validasi: id_detail[] tidak boleh kosong
2. Ambil tanggal_pengembalian_seharusnya dari header transaksi
3. Hitung keterlambatan:
   selisih_hari = floor((hari_ini - tgl_seharusnya) / 86400)
   denda_per_buku = selisih_hari × Rp 2.000  (jika telat, 0 jika tepat/lebih awal)
4. Untuk setiap id_detail yang dicentang:
   a. CEK: apakah buku ini belum dikembalikan? (skip jika sudah)
   b. UPDATE detail_peminjaman:
      status = 'dikembalikan', tanggal_kembali = HARI_INI, denda = denda_per_buku
   c. TAMBAH STOK kembali: UPDATE master_buku SET stok = stok + 1
5. CEK apakah SEMUA buku sudah dikembalikan:
   SELECT COUNT(*) FROM detail_peminjaman
   WHERE id_peminjaman = X AND status = 'dipinjam'
6. UPDATE header transaksi:
   - Jika sisa = 0 → status = 'dikembalikan'
   - Jika sisa > 0 → status tetap 'dipinjam'
7. Return: { "status": "success", "sisa": jumlah_buku_belum_dikembalikan }
```

**Kalkulasi denda:**
```php
$tgl_seharusnya = strtotime($header['tanggal_pengembalian_seharusnya']);
$tgl_kembali    = strtotime(date('Y-m-d')); // hari ini
$selisih_hari   = max(0, floor(($tgl_kembali - $tgl_seharusnya) / 86400));
$denda_per_buku = $selisih_hari * 2000; // Rp 2.000 per hari per buku
```

`max(0, ...)` memastikan denda tidak negatif jika dikembalikan lebih awal.

#### `get_loan.php`
**Route:** `GET /get-loan`  
**Fungsi:** Ambil data ringkas peminjaman (digunakan untuk keperluan lain/filter).

#### `get_loan_by_id.php`
**Route:** `POST /get-loan-by-id`  
**Fungsi:** Ambil detail lengkap satu transaksi untuk modal pengembalian.

**Parsing khusus:** String `detail_buku` dari view diubah menjadi array terstruktur:

```php
$detail_buku[] = [
    'id_detail'       => $parts[0],
    'id_buku'         => $parts[1],
    'judul_buku'      => $parts[2],
    'status'          => $parts[3], // 'dipinjam' atau 'dikembalikan'
    'tanggal_kembali' => $parts[4],
    'denda'           => $parts[5],
];
```

**Return:** JSON lengkap termasuk array `detail_buku` yang siap dirender sebagai checkbox di modal pengembalian.

#### `delete_loan.php`
**Route:** `POST /delete-loan`  
**Fungsi:** Hapus transaksi peminjaman (CASCADE DELETE ke detail_peminjaman otomatis via foreign key).

---

## 7. Folder `model/rfid/` — Integrasi RFID

Sistem RFID menggunakan pola **producer-consumer via database buffer**:

```
Perangkat RFID / Reqable (Producer)
        │
        │ POST /rfid-scan {"uid": "..."}
        ▼
   rfid_scans (tabel buffer)
   status: 'new'
        │
        │ Polling GET /rfid-get-member atau /rfid-get-buku
        ▼
   Aplikasi Web (Consumer)
   status diubah → 'used'
```

---

### `scan.php`
**Route:** `POST /rfid-scan`  
**Fungsi:** Menerima UID dari perangkat RFID / aplikasi testing, menyimpan ke buffer.

**Input (JSON body):**
```json
{ "uid": "1122" }
```

**Logika deteksi tipe:**

```php
$type = 'member'; // Default: member

// Cek awalan UID
if (strpos($uid, 'e2') === 0) {
    $type = 'buku'; // UID diawali "e2" = tag buku
}

INSERT INTO rfid_scans(uid, type, status) VALUES ('$uid', '$type', 'new')
```

**Contoh:**
- `uid = "1122"` → `type = 'member'` (tidak diawali e2)
- `uid = "e214"` → `type = 'buku'` (diawali e2)

**Return:**
```json
{ "status": true, "type": "member/buku", "uid": "1122" }
```

---

### `get_scan.php`
**Route:** `GET /rfid-get`  
**Fungsi:** Ambil scan member terbaru yang belum dipakai (status `new`), lalu tandai sebagai `used`.

**Query:**
```sql
SELECT * FROM rfid_scans
WHERE status='new' AND type='member'
ORDER BY id ASC LIMIT 1
```

**Setelah diambil:** `UPDATE rfid_scans SET status='used' WHERE id=X`

**Return:**
- Jika ada scan baru: data scan sebagai JSON
- Jika tidak ada: `null`

---

### `get_member_scan.php`
**Route:** `GET /rfid-get-member`  
**Fungsi:** Ambil scan member terbaru, lalu langsung cari data member berdasarkan UID tersebut.

**Alur:**
```
1. Ambil dari rfid_scans WHERE status='new' AND type='member' ORDER BY id DESC LIMIT 1
2. Jika ada → ambil uid dari scan
3. Query member_perpus WHERE uid = '$uid'
4. Jika member ditemukan:
   - Update rfid_scans status = 'used'
   - Return: { "status": "success", "type": "member", "data": {...data member...} }
5. Jika member tidak ditemukan:
   - Return: { "status": "not_found", "message": "Member tidak ditemukan", "uid": "..." }
6. Jika tidak ada scan baru:
   - Return: { "status": "empty" }
```

**Perbedaan `get_scan.php` vs `get_member_scan.php`:**
- `get_scan.php` → hanya kembalikan data scan mentah (uid saja)
- `get_member_scan.php` → langsung resolusi ke data member lengkap

---

### `get_buku_scan.php`
**Route:** `GET /rfid-get-buku`  
**Fungsi:** Sama seperti `get_member_scan.php` tapi untuk buku.

**Query scan:** `WHERE status='new' AND type='buku'`  
**Query resolusi:** `SELECT * FROM master_buku WHERE uid = '$uid' LIMIT 1`

**Return states:**
- `"status": "success"` + data buku jika UID cocok di master_buku
- `"status": "not_found"` jika UID tidak ada di master_buku
- `"status": "empty"` jika tidak ada scan baru

---

### `get_buku.php`
**Route:** `GET /rfid-get-master-buku`  
**Fungsi:** Ambil scan buku terbaru yang belum dipakai (versi sederhana tanpa resolusi ke master_buku).

---

## 8. Folder `views/` — Tampilan Halaman

### 8.1 Template Components (`views/templates/`)

Template components di-include di setiap halaman view untuk konsistensi tampilan.

---

#### `templates/header.php`
**Fungsi:** Bagian `<head>` HTML — load semua CSS (Bootstrap, DataTables, custom).  
**Diinclude:** Paling pertama di setiap view.

#### `templates/navbar.php`
**Fungsi:** Navbar atas — menampilkan nama user yang login, tombol logout.  
**Data dari session:** `$_SESSION['full_name']`

#### `templates/sidebar.php`
**Fungsi:** Sidebar navigasi dinamis berdasarkan hak akses grup user.

**Cara kerja (sangat penting):**

```php
$grup_user_id = $_SESSION['group_user_id'];

// 1. Ambil menu utama yang boleh diakses grup ini
$menu_query = "SELECT DISTINCT m.* FROM menu m
               JOIN user_access ua ON m.id = ua.menu_id
               WHERE ua.group_user_id = $grup_user_id
               AND is_active = 1 ORDER BY ordinal_number ASC";

// 2. Untuk setiap menu → ambil sub-menu yang boleh diakses
$sub_menu_query = "SELECT DISTINCT sm.* FROM sub_menu sm
                   JOIN user_access ua ON sm.id = ua.sub_menu_id
                   WHERE ua.group_user_id = $grup_user_id
                   AND sm.menu_id = {$menu['id']}
                   AND is_active = 1 ORDER BY ordinal_number ASC";
```

**Hasilnya:** Sidebar hanya menampilkan menu dan sub-menu yang grup user boleh akses. User dengan grup `User` hanya melihat menu Peminjaman, Admin melihat semua menu master + transaksi.

**Highlight halaman aktif:** Membandingkan `$current_page` dengan `$menu['url']`/`$sub_menu['url']`:

```php
class="<?= $current_page == $menu['url'] ? 'active' : '' ?>"
```

#### `templates/footbar.php` & `templates/footbarend.php`
**Fungsi:** Load semua JavaScript (jQuery, Bootstrap, DataTables, plugin-plugin).  
Dipisah menjadi dua bagian agar JS yang butuh diload sebelum konten (`footbar`) dan setelah konten (`footbarend`).

---

### 8.2 `views/auth/login.php`

**Route:** `GET /login`  
**Fungsi:** Halaman login. Auto-redirect ke dashboard jika sudah login.

```php
// Jika sudah login → langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: " . $baseUrl);
    exit();
}
```

**Form submit via AJAX** ke `POST /verify-login`. JavaScript menangani response:
- `status: "success"` → redirect ke dashboard
- `status: "error"` → tampilkan pesan error

---

### 8.3 `views/index.php` — Dashboard

**Route:** `GET /`  
**Fungsi:** Halaman dashboard utama.  
**Include:** `header.php`, `navbar.php`, `sidebar.php`, `footbar.php`, `footbarend.php`  
**Konten:** Kartu statistik (currently placeholder), chart area.

---

### 8.4 `views/master/` — Halaman Master Data

Semua halaman master mengikuti pola yang sama:

```
include header + navbar + sidebar
  ↓
Tabel DataTable (kosong saat load)
  ↓
Modal form (Add/Edit) — Bootstrap Modal
  ↓
include footbar + script JavaScript
  ↓
JavaScript:
  - DataTable AJAX → GET /get-xxx (isi tabel)
  - Tombol Add → buka modal, kosongkan form
  - Tombol Edit → AJAX GET /get-xxx-by-id → isi form → buka modal
  - Submit form → AJAX POST /add-xxx atau /update-xxx → reload tabel
  - Tombol Delete → konfirmasi SweetAlert → AJAX POST /delete-xxx → reload tabel
```

**Halaman yang ada:**
- `views/master/user/index.php` → Master User
- `views/master/grup-user/index.php` → Master Grup + halaman manajemen akses
- `views/master/menu/index.php` → Master Menu & Sub-Menu
- `views/master/kategori/index.php` → Master Kategori
- `views/master/buku/index.php` → Master Buku

---

### 8.5 `views/transaksi/member/index.php` — Halaman Member

**Route:** `GET /member-perpus`  
**Fungsi:** Kelola data anggota perpustakaan.

**Fitur khusus (RFID):** Form tambah member punya field UID yang bisa diisi:
- Manual (ketik UID)
- Otomatis via polling RFID scan

---

### 8.6 `views/transaksi/peminjaman/index.php` — Halaman Peminjaman

**Route:** `GET /peminjaman-buku`  
**Fungsi:** Halaman transaksi peminjaman dan pengembalian.

**Dua modal yang ada:**

**Modal #1 — Create (tambah peminjaman):**
- Dropdown member (dari `/get-members`)
- Multi-select buku (dari `/get-bukus`, hanya yang stok > 0)
- Input tanggal pinjam & estimasi kembali
- Submit → POST `/add-loan`

**Modal #2 — Kembali (proses pengembalian):**
- Muncul saat tombol edit di baris yang `status = 'dipinjam'`
- Menampilkan daftar buku dalam transaksi sebagai checkbox
- User bisa centang buku mana yang dikembalikan (parsial boleh)
- Submit → POST `/update-loan` dengan array `id_detail[]`

**Polling RFID di halaman ini:**
```javascript
// Setiap X detik, cek apakah ada scan RFID baru
setInterval(function() {
    fetch('/lib-app/rfid-get-member')
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                // Auto-fill dropdown member
                $('#id_member').val(data.data.id_member).trigger('change');
            }
        });
    // Hal sama untuk buku via /rfid-get-buku
}, 1000);
```

---

### 8.7 Halaman Error

#### `403.php`
**Route:** `GET /forbidden-accesss` (dua s — typo di routing, sudah konsisten)  
**Fungsi:** Halaman "Akses Ditolak" yang tampil saat user mencoba akses halaman yang tidak berhak.

#### `404.php`
**Fungsi:** Halaman "Tidak Ditemukan" yang tampil saat URL tidak cocok dengan route manapun.

---

## 9. Pola Komunikasi AJAX

Semua interaksi antara frontend (views) dan backend (model) menggunakan AJAX. Format request dan response selalu konsisten:

### Format Response JSON

**Sukses:**
```json
{ "status": "success", "message": "Pesan sukses", "data": {...} }
```

**Gagal:**
```json
{ "status": "error", "message": "Pesan error" }
```

**DataTable (get list):**
```json
{ "data": [ [col1, col2, ...], [col1, col2, ...] ] }
```

### Contoh Alur Lengkap: Tambah Buku

```
1. User klik "Add" → modal terbuka, form kosong

2. User isi form → klik Submit
   JavaScript:
   fetch('/lib-app/add-buku', {
     method: 'POST',
     body: new FormData(form)
   })

3. add_buku.php:
   - Cek UID duplikat
   - INSERT ke master_buku
   - Return: { "status": "success", "message": "Buku berhasil ditambahkan" }

4. JavaScript terima response:
   - Tampilkan SweetAlert "Berhasil"
   - Tutup modal
   - Reload DataTable: $('#userTable').DataTable().ajax.reload()
```

---

## 10. Diagram Alur Data

### Alur Login

```
[Form Login] 
    → POST /verify-login
    → vwmstuser (view: users JOIN group_user)
    → Session tersimpan:
        $_SESSION['user_id']
        $_SESSION['username']
        $_SESSION['full_name']
        $_SESSION['group_user_id']  ← kunci akses menu
        $_SESSION['leveluser']
    → Redirect ke dashboard
```

### Alur Sidebar Dinamis

```
Setiap halaman load
    → sidebar.php
    → Query menu JOIN user_access WHERE group_user_id = $_SESSION[...]
    → Query sub_menu JOIN user_access WHERE group_user_id = $_SESSION[...]
    → Render hanya menu/sub-menu yang diizinkan
```

### Alur Peminjaman Buku + RFID

```
[Perangkat RFID scan kartu member]
    → POST /rfid-scan {"uid":"1122"}
    → rfid_scans INSERT (status='new', type='member')

[Halaman Peminjaman — JavaScript polling setiap 1 detik]
    → GET /rfid-get-member
    → rfid_scans SELECT WHERE status='new' AND type='member'
    → member_perpus SELECT WHERE uid='1122'
    → rfid_scans UPDATE status='used'
    → Return: { status:"success", data:{id_member:10, nama_member:"Jasmine Putri",...} }
    → Auto-fill dropdown member di form

[Perangkat RFID scan tag buku]
    → POST /rfid-scan {"uid":"e214"}
    → rfid_scans INSERT (status='new', type='buku')

[JavaScript polling]
    → GET /rfid-get-buku
    → master_buku SELECT WHERE uid='e214'
    → Auto-add "The Elegant Universe" ke multi-select buku

[User klik Submit]
    → POST /add-loan {id_member, id_buku[], tanggal_pinjam, tgl_kembali_seharusnya}
    → Cek stok semua buku
    → INSERT transaksi_peminjaman (header)
    → INSERT detail_peminjaman × jumlah buku
    → UPDATE master_buku stok - 1 × jumlah buku
    → Return: { status:"success" }
```

### Alur Pengembalian + Denda

```
[User klik Edit pada transaksi aktif]
    → POST /get-loan-by-id {id_peminjaman}
    → vwmstpeminjaman SELECT
    → Parse detail_buku string → array
    → Return detail lengkap + list buku dengan checkbox

[User centang buku yang dikembalikan → Submit]
    → POST /update-loan {id_peminjaman, id_detail:[1,3]}
    
    → Ambil tanggal_pengembalian_seharusnya
    → Hitung selisih hari dari hari ini
    → denda = selisih_hari × Rp 2.000 (per buku)
    
    → Untuk setiap id_detail yang dicentang:
       UPDATE detail_peminjaman (status, tanggal_kembali, denda)
       UPDATE master_buku stok + 1
    
    → Cek sisa buku belum kembali
    → UPDATE header transaksi (status, updateBy)
    
    → Return: { status:"success", sisa: 0 }
```

---

## 📌 Ringkasan Konvensi Kode

| Hal | Konvensi |
|-----|----------|
| Naming file | `snake_case.php` (contoh: `add_buku.php`) |
| Naming variabel | `$snake_case` |
| Response API | Selalu JSON dengan key `status` dan `message`/`data` |
| Audit trail | Setiap data punya `createdBy`, `createdAt`, `updatedBy`/`updateBy`, `updatedAt`/`updateAt` |
| UUID | Digunakan di `users` dan `group_user` untuk referensi publik yang aman |
| Soft vs Hard delete | Saat ini menggunakan **hard delete** (langsung DELETE dari DB) |
| Sanitasi input | Sebagian menggunakan `mysqli_real_escape_string()`, sebagian belum — perlu distandarisasi |
| View database | `vwmstuser`, `vwmstbuku`, `vwmstpeminjaman`, `vwmstsubmenu` — digunakan untuk query baca yang kompleks |

---

*Dokumentasi kode ini dibuat berdasarkan analisis source code aplikasi BookVault versi Juli 2026.*
