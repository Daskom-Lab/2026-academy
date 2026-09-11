# 007 - Kamus Troubleshooting & Solusi Error Umum

Saat membangun aplikasi backend berbasis PHP native dan MySQL, ada beberapa kendala klasik yang hampir pasti dihadapi pemula. Jangan panik! Berikut panduan diagnosis dan solusinya:

---

### 1. `Warning: Cannot modify header information - headers already sent by (output started at ...)`

#### 🔍 Penyebab:
Fungsi `header('Location: ...')` atau `session_start()` dipanggil **setelah** ada teks/HTML yang sudah terkirim ke browser. Ingat: HTTP Header harus dikirim paling pertama sebelum body respon.

#### 🛠️ Solusi:
1. Periksa bagian paling atas file (Line 1). Pastikan tag `<?php` dimulai tanpa ada spasi atau baris kosong sebelumnya.
2. Jangan pernah ada perintah `echo`, `print`, atau teks HTML sebelum baris `session_start()` atau `header('Location: ...')`.
3. Selalu letakkan blok pemrosesan form `POST` dan redirect di **bagian paling atas file** sebelum tag `<!DOCTYPE html>`.

---

### 2. `Fatal error: Uncaught PDOException: SQLSTATE[HY000] [2002] Connection refused` / `No connection could be made...`

#### 🔍 Penyebab:
Aplikasi PHP tidak bisa terhubung ke server database MySQL.

#### 🛠️ Solusi:
1. Buka **XAMPP Control Panel** (atau Laragon) dan pastikan service **MySQL** berstatus **Running** (berwarna hijau).
2. Di file `config/database.php`, ubah `$host = 'localhost';` menjadi `$host = '127.0.0.1';`. Pada sistem operasi Windows, nama `localhost` terkadang mencoba koneksi via IPv6 yang menyebabkan gagal terhubung.
3. Periksa port MySQL. Jika port MySQL kamu bukan default `3306` (misal `3307`), tambahkan port pada DSN: `"mysql:host=127.0.0.1;port=3307;dbname=...;charset=utf8mb4"`.

---

### 3. Halaman Blank Putih Bersih Tanpa Pesan Error Apa Pun

#### 🔍 Penyebab:
Konfigurasi default PHP di laptopmu menyembunyikan pesan error (*display_errors is Off*).

#### 🛠️ Solusi:
Tambahkan dua baris ini di baris paling awal berkas `config/database.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```
Dengan begitu, jika ada syntax error atau query SQL yang salah, PHP akan langsung mencetak letak baris dan jenis errornya di layar.

---

### 4. Tombol "Hapus" Tetap Berjalan Meskipun Pengguna Mengklik "Cancel"

#### 🔍 Penyebab:
Lupa menyertakan kata kunci `return` pada atribut `onsubmit` form HTML.

#### 🛠️ Solusi:
❌ **SALAH:**
```html
<form method="POST" action="delete.php" onsubmit="confirm('Yakin?')">
```
*(Browser mengabaikan hasil klik Cancel dan tetap men-submit form!)*

✅ **BENAR:**
```html
<form method="POST" action="delete.php" onsubmit="return confirm('Yakin?')">
```
*(Kata kunci `return` akan membatalkan submit form jika user mengklik Cancel).*

---

### 5. Input Form Hilang Semua Saat Muncul Pesan Validasi Error

#### 🔍 Penyebab:
Atribut `value=""` pada tag `<input>` dibiarkan kosong atau statis, sehingga ketika halaman di-refresh untuk menampilkan pesan error, nilai yang diketik user hilang.

#### 🛠️ Solusi:
Isi atribut `value` dengan nilai variabel PHP yang sudah dibungkus `e()`:
```html
<input type="text" name="judul" value="<?= e($judul) ?>">
```

---

### 6. Gagal Import `schema.sql` di phpMyAdmin ("No database selected")

#### 🔍 Penyebab:
Skrip SQL langsung menjalankan perintah `CREATE TABLE` tanpa menentukan database mana yang sedang aktif.

#### 🛠️ Solusi:
Sertakan dua baris ini di bagian paling atas berkas `schema.sql`:
```sql
CREATE DATABASE IF NOT EXISTS nama_database_kamu;
USE nama_database_kamu;
```
Atau di phpMyAdmin: buat database baru terlebih dahulu melalui menu sebelah kiri, klik database tersebut, baru kemudian buka tab **Import**.
