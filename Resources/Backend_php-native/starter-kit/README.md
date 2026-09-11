# Laporan Tugas 3: Web CRUD PHP & MySQL

> **Nama Lengkap:** [Tulis nama Anda di sini]  
> **NIM / Username:** [Tulis NIM / ID Anda di sini]  
> **Tema Aplikasi:** [Contoh: Sistem Manajemen Menu Kafe / Inventaris Game]  

---

## 📖 Deskripsi Aplikasi
Jelaskan secara singkat mengenai tema yang Anda pilih, fungsi aplikasi, serta tujuan dibuatnya sistem CRUD ini.

Contoh:
*Aplikasi ini adalah sistem inventaris toko game sederhana untuk mencatat daftar judul game, genre, harga sewa/jual, serta sisa stok yang tersedia.*

---

## 🗄️ Struktur Tabel Database
Nama tabel utama: `items` (atau sesuaikan dengan pilihanmu)

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | `INT AUTO_INCREMENT` (PK) | Identifier unik data |
| `name` | `VARCHAR(150)` | Nama item / entitas |
| `category` | `VARCHAR(50)` | Kategori kelompok item |
| `price` | `INT` | Nilai harga dalam rupiah |
| `stock` | `INT` | Sisa kuantitas barang |
| `created_at`| `TIMESTAMP` | Waktu pencatatan data |

---

## 📸 Tangkapan Layar (Screenshots)

Sertakan tangkapan layar fitur aplikasi Anda yang sedang berjalan di browser:

### 1. Halaman Utama & Tampilan Tabel (READ)
*(Ganti gambar di bawah dengan screenshot aplikasi Anda)*
![Halaman Utama](./screenshot-index.png)

### 2. Form Tambah Data (CREATE) & Notifikasi Sukses (PRG)
![Tambah Data](./screenshot-create.png)

### 3. Form Ubah Data (UPDATE)
![Edit Data](./screenshot-edit.png)

### 4. Konfirmasi Hapus Data (DELETE)
![Hapus Data](./screenshot-delete.png)

---

## ⚙️ Petunjuk Menjalankan Proyek Secara Lokal

1. **Persiapan Database:**
   - Buka **phpMyAdmin** lokal Anda (`http://localhost/phpmyadmin`).
   - Buat database baru atau langsung import berkas [`schema.sql`](./schema.sql).
2. **Konfigurasi Koneksi:**
   - Buka berkas [`config/database.php`](./config/database.php).
   - Pastikan nama database, user, dan password sudah cocok dengan MySQL lokal Anda.
3. **Menjalankan Web Server:**
   - Salin folder proyek ini ke dalam folder `htdocs` (XAMPP) atau `www` (Laragon).
   - Buka browser dan akses: `http://localhost/project/index.php`.
   - *Alternatif:* Jalankan server built-in PHP melalui terminal di dalam folder proyek:
     ```bash
     php -S localhost:8000
     ```
     Lalu buka `http://localhost:8000` di browser.
