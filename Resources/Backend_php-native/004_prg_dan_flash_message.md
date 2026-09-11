# 004 - Pola PRG (Post-Redirect-Get) & Flash Message

## 1. Masalah: "Confirm Form Resubmission"

Pernahkah kamu mengirim form, lalu saat menekan tombol **F5 (Refresh)** di browser muncul pop-up peringatan:
> *"Confirm Form Resubmission: The page you are looking for used information you entered. Returning to that page might cause any action you took to be repeated."*

Jika user menekan tombol **Continue**, data yang sama akan tersimpan **dua kali** ke database!

Hal ini terjadi karena skrip PHP memproses form `POST` dan langsung mencetak HTML di halaman yang sama tanpa melakukan *redirect*.

---

## 2. Solusi: Pola PRG (Post-Redirect-Get)

Pola **PRG** adalah standar industri dalam arsitektur web untuk menangani pengiriman form:

```text
[ Browser ] ──(1) Form Submit (POST)──► [ create.php / edit.php / delete.php ]
                                                   │
                                                   ▼
                                         Proses Database & Simpan Flash Message
                                                   │
[ Browser ] ◄──(2) HTTP 302 Redirect (Location)───┘
     │
     ▼
(3) Otomatis Request (GET)
     │
     ▼
[ index.php ] ──(4) Render HTML + Tampilkan Flash Message (Lalu Hapus dari Session)
```

Dengan pola ini:
- Browser berakhir di request **GET** ke `index.php`.
- Jika user menekan tombol Refresh berkali-kali, yang di-refresh hanyalah halaman baca (`index.php`), bukan pengiriman data `POST`. Data di database tetap aman dari duplikasi.

---

## 3. Implementasi Flash Message Menggunakan Session

Karena redirect HTTP membuat browser membuka halaman baru, variabel biasa di PHP akan terhapus. Kita menggunakan **`$_SESSION`** untuk menitipkan pesan notifikasi antar-halaman.

### Buat Fungsi Pembantu di `helpers.php`:
```php
<?php
// helpers.php

/**
 * Simpan pesan flash ke dalam session sebelum redirect
 */
function setFlash(string $pesan, string $tipe = 'success'): void
{
    $_SESSION['flash'] = [
        'pesan' => $pesan,
        'tipe'  => $tipe,
    ];
}

/**
 * Ambil pesan flash (jika ada) dan langsung hapus agar tidak muncul lagi saat di-refresh
 */
function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']); // Hapus segera setelah dibaca
    return $flash;
}
```

---

## 4. Cara Penggunaan di Kode Nyata

### A. Saat Memproses Tambah Data (`create.php`):
```php
session_start();
require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... proses validasi & insert ke database ...

    // 1. Simpan pesan flash
    setFlash("Data buku berhasil ditambahkan!");

    // 2. Redirect ke halaman utama
    header('Location: index.php');

    // 3. WAJIB: Panggil exit untuk menghentikan eksekusi skrip seketika
    exit;
}
```

> ⚠️ **Aturan Emas:** Setelah fungsi `header('Location: ...')`, **WAJIB** menyertakan perintah `exit;` atau `die();`. Jika tidak, PHP akan terus menjalankan baris kode di bawahnya hingga tuntas!

---

### B. Saat Menampilkan di Halaman Utama (`index.php`):
```php
<?php
session_start();
require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Tampilkan Notifikasi Flash Jika Ada -->
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['tipe'] ?>">
            <?= htmlspecialchars($flash['pesan'], ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- ... tabel data ... -->
</body>
</html>
```
