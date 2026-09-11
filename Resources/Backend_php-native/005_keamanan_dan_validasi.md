# 005 - Keamanan XSS, Validasi Server-Side, & Aksi Delete Aman

## 1. Pencegahan Serangan XSS (Cross-Site Scripting)

### Apa itu XSS?
Jika ada pengguna yang mengisi form dengan nama:
`<script>alert('Akun Anda Dihack!');</script>`
Dan kamu mencetaknya langsung menggunakan:
`<td><?= $row['nama'] ?></td>`
Maka browser akan mengeksekusi tag `<script>` tersebut sebagai kode JavaScript hidup! Ini bisa digunakan penyerang untuk mencuri cookie session atau membajak akun.

### Solusi Wajib: `htmlspecialchars()`
Semua teks dinamis yang berasal dari database atau input user **wajib** disanitasi sebelum dicetak ke layar HTML:

```php
// helpers.php
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
```

**Contoh Penggunaan:**
```html
<!-- Aman dari XSS: -->
<h1><?= e($buku['judul']) ?></h1>
<input type="text" name="judul" value="<?= e($judul_lama) ?>">
```

---

## 2. Aksi DELETE Wajib Menggunakan Method `POST`

### Mengapa Link `<a href="delete.php?id=1">` DILARANG KERAS?
1. **Web Crawler & Pre-fetching Browser:** Fitur browser modern sering kali mengunduh link di halaman secara otomatis (*pre-fetch*) untuk mempercepat navigasi. Akibatnya, data bisa terhapus tanpa disengaja oleh user!
2. **CSRF (Cross-Site Request Forgery):** Penyerang cukup mengirim gambar `<img src="http://toko.test/delete.php?id=1">` di website lain untuk menghapus datamu.

### Cara Pembuatan Tombol Delete yang Benar (Sesuai Tugas 3):

Di `index.php`:
```html
<!-- Tombol hapus menggunakan FORM dengan method POST + konfirmasi JavaScript -->
<form method="POST" action="delete.php" style="display: inline;" 
      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
    <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
    <button type="submit" class="btn-danger">Hapus</button>
</form>
```

Di `delete.php`:
```php
<?php
session_start();
require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

// TOLAK request jika bukan dikirim via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash("Aksi hapus tidak diizinkan via method GET!", "danger");
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
    setFlash("Data berhasil dihapus!", "success");
}

header('Location: index.php');
exit;
```

---

## 3. Validasi Server-Side & Repopulate Form

Validasi JavaScript di browser (`required` pada HTML) sangat mudah ditembus dengan *Inspect Element* atau Postman. Validasi di sisi server (PHP) adalah benteng pertahanan utama.

### Kriteria Validasi yang Diuji:
1. Kolom teks wajib di-`trim()` dan tidak boleh kosong.
2. Kolom angka (harga/stok/tahun) wajib divalidasi dengan `filter_var(..., FILTER_VALIDATE_INT)`.
3. Jika ada input yang salah, **tampilkan pesan error yang jelas** dan **jangan hilangkan ketikan user yang sudah benar** (*sticky form*).

### Pola Validasi & Sticky Form di `create.php`:

```php
<?php
session_start();
require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

$errors = [];
$judul  = '';
$stok   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitasi awal dengan trim
    $judul = trim($_POST['judul'] ?? '');
    $stok  = trim($_POST['stok'] ?? '');

    // 2. Cek apakah kolom teks kosong
    if ($judul === '') {
        $errors[] = "Judul buku tidak boleh kosong.";
    } elseif (strlen($judul) < 3) {
        $errors[] = "Judul minimal 3 karakter.";
    }

    // 3. Validasi angka
    if ($stok === '') {
        $errors[] = "Stok wajib diisi.";
    } elseif (filter_var($stok, FILTER_VALIDATE_INT) === false || (int)$stok < 0) {
        $errors[] = "Stok harus berupa angka bulat positif (0 atau lebih).";
    }

    // 4. Jika lolos validasi, simpan ke database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO buku (judul, stok) VALUES (:judul, :stok)");
        $stmt->execute([
            'judul' => $judul,
            'stok'  => (int) $stok,
        ]);

        setFlash("Buku berhasil disimpan!");
        header('Location: index.php');
        exit;
    }
}
?>

<!-- Form HTML -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= e($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="create.php">
    <!-- Repopulate data lama dengan atribut value="<?= e($judul) ?>" agar user tidak perlu mengetik ulang jika error -->
    <div>
        <label>Judul Buku:</label>
        <input type="text" name="judul" value="<?= e($judul) ?>">
    </div>
    <div>
        <label>Stok:</label>
        <input type="number" name="stok" value="<?= e($stok) ?>">
    </div>
    <button type="submit">Simpan</button>
</form>
```
