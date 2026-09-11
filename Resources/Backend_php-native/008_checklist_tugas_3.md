# 008 - Checklist Pra-Pengumpulan Tugas 3

Sebelum kamu mengompres proyekmu menjadi `.zip` dan mengirimkannya ke Google Form, lakukan **audit mandiri** menggunakan checklist di bawah ini untuk memastikan nilaimu maksimal!

---

## 📋 Checklist Spesifikasi & Rubrik Penilaian

### 1. Struktur Berkas & Direktori
- [ ] Folder proyek bernama `project/` (atau sesuai nama temamu) dengan struktur:
  ```text
  project/
  ├── config/
  │   └── database.php    # Koneksi PDO
  ├── schema.sql          # DDL tabel + minimal 5 baris seed data
  ├── index.php           # Tampilan tabel data utama & notifikasi
  ├── create.php          # Form & aksi tambah
  ├── edit.php            # Form & aksi edit
  ├── delete.php          # Aksi hapus (POST only)
  ├── style.css           # Styling tampilan (rapi dan enak dilihat)
  └── README.md           # Deskripsi tema & tangkapan layar (screenshot)
  ```
- [ ] Berkas `schema.sql` sudah dicoba di-import ulang di database baru dan **berhasil tanpa ada error sintaks**.
- [ ] Berkas `README.md` sudah dilengkapi dengan penjelasan singkat tema aplikasi dan **tangkapan layar (screenshot)** aplikasi yang sedang berjalan.

---

### 2. Standar Arsitektur & Keamanan
- [ ] **Koneksi PDO**: Menggunakan opsi:
  - `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`
  - `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC`
- [ ] **Prepared Statements**: SEMUA query yang berurusan dengan input user (`INSERT`, `UPDATE`, `DELETE`, `SELECT ... WHERE id = :id`, atau pencarian `LIKE`) menggunakan `$pdo->prepare()` dan `$stmt->execute()`. **Tidak ada string SQL yang disambung langsung dengan variabel (`" ... " . $var`)**.
- [ ] **Pencegahan XSS**: SEMUA data teks yang dicetak ke HTML dibungkus `htmlspecialchars()` atau fungsi helper `e()`.
- [ ] **Aksi Hapus Aman**:
  - Tombol hapus menggunakan tag `<form method="POST" action="delete.php">`, **BUKAN** link `<a href="delete.php?id=...">`.
  - Berkas `delete.php` memverifikasi `$_SERVER['REQUEST_METHOD'] === 'POST'` dan menolak request GET.
  - Terdapat pop-up konfirmasi JavaScript sebelum form hapus terkirim (`onsubmit="return confirm('...');"`).
- [ ] **Pola PRG (Post-Redirect-Get)**:
  - Penambahan, pengubahan, dan penghapusan data selalu diakhiri dengan `header('Location: index.php'); exit;`.
  - Tidak ada halaman putih kosong setelah form disubmit.
  - Menampilkan notifikasi (*flash message*) hasil aksi di `index.php`.
- [ ] **Validasi Server-Side**:
  - Input teks dibersihkan dengan `trim()` dan dicek agar tidak kosong.
  - Kolom angka (harga/stok/tahun) divalidasi dengan `filter_var(..., FILTER_VALIDATE_INT)` atau `is_numeric()`.
  - Jika input tidak valid, muncul pesan error yang jelas dan input form tidak hilang (*sticky form*).
- [ ] **Empty State**:
  - Jika seluruh data di tabel dihapus, `index.php` menampilkan pesan ramah (contoh: *"Belum ada data tersedia"*), bukan tabel kosong tanpa teks.

---

## 🧪 Skenario Pengujian Mandiri (Self-PenTest)

Coba lakukan 5 skenario ini di browser sebelum mengumpulkan tugas:

1. **Uji Penolakan Hapus via URL:**  
   Ketik langsung di address bar browser: `http://localhost/.../delete.php?id=1` lalu tekan Enter.  
   👉 **Hasil yang diharapkan:** Data TIDAK terhapus, dan kamu di-redirect kembali ke `index.php` dengan pesan peringatan.
2. **Uji Serangan XSS:**  
   Buka form tambah data, isi salah satu kolom teks dengan:  
   `<script>alert('XSS Berhasil!')</script>`  
   Simpan data dan lihat di halaman `index.php`.  
   👉 **Hasil yang diharapkan:** Teks script tersebut tampil polos sebagai tulisan di tabel, **TIDAK** muncul pop-up alert JavaScript!
3. **Uji Serangan SQL Injection:**  
   Buka form pencarian atau form tambah/edit, masukkan karakter `' OR '1'='1`.  
   👉 **Hasil yang diharapkan:** Aplikasi tetap bekerja normal, tidak memunculkan fatal error query SQL atau membocorkan data lain.
4. **Uji Pola PRG (Anti Resubmission):**  
   Tambah sebuah data baru hingga kamu kembali ke `index.php`. Tekan tombol **F5 (Refresh)** di keyboard.  
   👉 **Hasil yang diharapkan:** Halaman ter-refresh secara normal tanpa muncul pop-up *"Confirm Form Resubmission"*, dan data tidak bertambah ganda.
5. **Uji Validasi Form:**  
   Kosongkan field yang wajib diisi, lalu klik Simpan.  
   👉 **Hasil yang diharapkan:** Muncul pesan error yang jelas di atas form, dan teks yang sudah terlanjur diketik di field lain tidak hilang.
