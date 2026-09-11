<?php
/**
 * create.php - Form & Aksi Tambah Data (CREATE)
 * Menerapkan Validasi Server-Side, Prepared Statements, dan Pola PRG
 */

session_start();

require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

$errors   = [];
$name     = '';
$category = '';
$price    = '';
$stock    = '';

// Proses hanya jika form dikirimkan via method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitasi awal: trim whitespace
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = trim($_POST['price'] ?? '');
    $stock    = trim($_POST['stock'] ?? '');

    // 2. Validasi Server-Side (Wajib Tugas 3)
    // Validasi Kolom Teks: Tidak boleh kosong
    if ($name === '') {
        $errors[] = 'Nama item tidak boleh kosong.';
    } elseif (strlen($name) < 3) {
        $errors[] = 'Nama item minimal terdiri dari 3 karakter.';
    }

    if ($category === '') {
        $errors[] = 'Kategori tidak boleh kosong.';
    }

    // Validasi Kolom Angka: Harus berupa integer valid dan positif
    if ($price === '') {
        $errors[] = 'Harga tidak boleh kosong.';
    } elseif (filter_var($price, FILTER_VALIDATE_INT) === false || (int)$price < 0) {
        $errors[] = 'Harga harus berupa angka bulat positif (>= 0).';
    }

    if ($stock === '') {
        $errors[] = 'Stok tidak boleh kosong.';
    } elseif (filter_var($stock, FILTER_VALIDATE_INT) === false || (int)$stock < 0) {
        $errors[] = 'Stok harus berupa angka bulat positif (>= 0).';
    }

    // 3. Jika tidak ada error validasi, simpan ke database
    if (empty($errors)) {
        // TODO: Sesuaikan nama tabel dan kolom sesuai tema Anda
        $sql = "INSERT INTO items (name, category, price, stock) 
                VALUES (:name, :category, :price, :stock)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name'     => $name,
            'category' => $category,
            'price'    => (int)$price,
            'stock'    => (int)$stock,
        ]);

        // 4. Pola PRG: Pasang flash message lalu redirect ke index.php
        setFlash('Data baru berhasil ditambahkan!', 'success');
        header('Location: index.php');
        exit; // WAJIB exit setelah redirect
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Baru - Tugas 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Tambah Data Baru</h2>

    <!-- Tampilkan Pesan Error Validasi jika ada -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="create.php">
        <!-- TODO: Sesuaikan input field dengan atribut tabel Anda -->
        <div class="form-group">
            <label for="name">Nama Item:</label>
            <!-- Sticky form: value diisi variabel lama yang sudah dibungkus e() -->
            <input type="text" id="name" name="name" value="<?= e($name) ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori:</label>
            <input type="text" id="category" name="category" value="<?= e($category) ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp):</label>
            <input type="number" id="price" name="price" value="<?= e($price) ?>" min="0" required>
        </div>

        <div class="form-group">
            <label for="stock">Jumlah Stok:</label>
            <input type="number" id="stock" name="stock" value="<?= e($stock) ?>" min="0" required>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

</body>
</html>
