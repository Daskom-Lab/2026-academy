# Academy Backend - Tugas 3: Web CRUD PHP & MySQL

Tugas mandiri ini menguji pemahaman alur backend yang sudah dibahas di sesi materi. Kalian diminta membuat aplikasi web CRUD dengan **tema bebas** menggunakan **PHP native** dan database **MySQL** via PDO.

Bebas pilih topik apa pun mau itu katalog buku, inventaris game, pencatat pengeluaran, daftar menu cafe, atau lainnya. Syaratnya: gunakan **satu tabel utama** dengan minimal 4 kolom data yang relevan di luar `id`. Jangan buat relasi multi-tabel dulu agar fokus kalian tetap pada penguasaan alur CRUD dan keamanan dasarnya.

---

## Spesifikasi Fitur

Aplikasi minimal memiliki 4 operasi berikut:

1. **READ (`index.php`)**
   - Menampilkan seluruh isi tabel dari database.
   - Jika tabel masih kosong, tampilkan teks pemberitahuan sederhana (jangan biarkan halaman kosong tanpa keterangan).
2. **CREATE (`create.php`)**
   - Form input data baru menggunakan method `POST`.
   - Wajib menerapkan pola **PRG (Post-Redirect-Get)**: setelah data tersimpan, redirect ke halaman utama dan kirimkan flash message.
3. **UPDATE (`edit.php`)**
   - Halaman form edit yang otomatis terisi data lama berdasarkan query parameter `id`.
   - Proses update dikirim via method `POST`.
4. **DELETE (`delete.php`)**
   - Hapus data **wajib via method `POST`** (tidak boleh memakai link `<a href="delete.php?id=...">`).
   - Berikan konfirmasi sederhana (`confirm()` JS) sebelum aksi hapus dijalankan.

---

## Standar Arsitektur & Keamanan

- [ ] **Koneksi PDO**: Menggunakan `PDO` dengan opsi `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` dan `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC`.
- [ ] **Prepared Statements**: Semua query yang menerima input user (`INSERT`, `UPDATE`, `DELETE`, `SELECT ... WHERE id = ?`) wajib pakai `prepare()` dan `execute()`. Dilarang menyambung string query langsung dengan variabel.
- [ ] **XSS Escaping**: Semua output teks dinamis yang dicetak ke HTML wajib dibungkus `htmlspecialchars()`.
- [ ] **Validasi Server-side**:
  - Kolom teks wajib di-`trim()` dan tidak boleh kosong.
  - Kolom angka wajib divalidasi dengan `filter_var(..., FILTER_VALIDATE_INT)` atau `is_numeric()`.
  - Jika input bermasalah, tampilkan pesan error yang jelas tanpa membuat skrip error fatal atau blank putih.
- [ ] **PRG & Flash Message**: Operasi mutasi data (tambah, edit, hapus) tidak boleh berhenti di halaman kosong. Harus redirect (`header('Location: ...')`) lalu menampilkan notifikasi hasil aksi.

---

## Nilai Tambah (Opsional)

- Fitur pencarian data dengan query `LIKE` via prepared statement.
- Opsi pengurutan data (sorting).
- Tampilan antarmuka yang rapi dengan CSS.

---

## Struktur Berkas & Pengumpulan

Kumpulkan proyek dengan struktur direktori berikut:

```text
project/
├── config/
│   └── database.php    # Koneksi PDO
├── schema.sql          # DDL tabel + minimal 5 baris seed data awal (INSERT)
├── index.php           # Halaman utama & daftar data
├── create.php          # Form & aksi tambah data
├── edit.php            # Form & aksi ubah data
├── delete.php          # Aksi hapus data (POST only)
├── style.css           # Styling tampilan (opsional)
└── README.md           # Deskripsi singkat tema aplikasi & tangkapan layar
```

> **Penting:** Pastikan berkas `schema.sql` bisa di-import langsung di phpMyAdmin atau terminal MySQL lokal tanpa error sebelum dikumpulkan.

> Silakan kompres folder proyek ke dalam format .zip dan kumpulkan melalui link berikut:
https://forms.gle/bBgavMJERnLwYNaDA