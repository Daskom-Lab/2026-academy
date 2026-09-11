# 002 - Konfigurasi Koneksi PDO (PHP Data Objects)

## 1. Mengapa Menggunakan PDO?

Di PHP, ada beberapa cara menghubungkan aplikasi ke MySQL: `mysql_*` (usang dan sudah dihapus di PHP 7+), `mysqli_*` (khusus MySQL), dan **PDO (PHP Data Objects)**.

Kelebihan utama **PDO**:
- Mendukung fitur keamanan modern: **Prepared Statements asli**.
- Standar industri untuk aplikasi berorientasi masa depan (bisa berganti engine database dengan mudah).
- Memiliki sistem penanganan error berbasis Exception (`PDOException`).

---

## 2. Template Resmi `config/database.php`

Sesuai dengan standar penilaian di **Tugas 3**, berikut adalah template berkas koneksi database yang wajib diterapkan:

```php
<?php
// config/database.php

// 1. Tampilkan semua error selama proses belajar/development di komputer lokal
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Kredensial Database
// Tips Windows: gunakan '127.0.0.1' alih-alih 'localhost' untuk menghindari latensi lookup IPv6
$host    = '127.0.0.1';
$db      = 'nama_database_kamu'; // Ganti sesuai nama database di phpMyAdmin
$user    = 'root';               // Default user XAMPP/Laragon
$pass    = '';                   // Default password XAMPP biasanya kosong, Laragon biasanya kosong/root
$charset = 'utf8mb4';

// 3. Susun Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// 4. Opsi Konfigurasi Wajib (Sesuai Spesifikasi Tugas 3)
$options = [
    // Wajib: Lempar exception jika ada query yang error/gagal
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    
    // Wajib: Jadikan associative array sebagai format default pengambilan data ($row['nama_kolom'])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Sangat disarankan: Matikan emulasi prepared statement agar query diproses secara native oleh MySQL
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// 5. Inisialisasi Koneksi dengan Blok Try-Catch
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Tampilkan pesan error ramah tanpa mengekspos kredensial sensitif
    die("Koneksi database gagal: " . $e->getMessage());
}
```

---

## 3. Poin-Poin Penting yang Dinilai di Tugas:

1. **`PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`**  
   Jika opsi ini tidak dipasang, PHP tidak akan memberi tahu ketika query SQL-mu salah ketik (halaman akan blank atau data tidak tersimpan tanpa ada pesan error).
2. **`PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC`**  
   Membuat data yang diambil dari database otomatis berbentuk *Associative Array* (misal: `$row['judul']`, bukan angka index `$row[0]`), sehingga kode lebih mudah dibaca dan dipelihara.
3. **Cara Menggunakan Variabel `$pdo` di File Lain:**  
   Cukup panggil file koneksi di baris awal file lain (seperti `index.php`, `create.php`, dll):
   ```php
   require __DIR__ . '/config/database.php';
   // Setelah baris ini, variabel $pdo sudah siap digunakan untuk query!
   ```
