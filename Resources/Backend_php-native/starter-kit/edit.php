<?php
/**
 * edit.php - Halaman Form & Aksi Ubah Data (UPDATE)
 * Mengambil data lama via GET ?id=..., memproses update via POST, dan menerapkan PRG
 */

session_start();

require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

// 1. Ambil ID dari URL (?id=...)
$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    setFlash('ID data tidak valid.', 'danger');
    header('Location: index.php');
    exit;
}

// 2. Ambil data lama dari database menggunakan Prepared Statement
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = :id");
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();

// Jika data dengan ID tersebut tidak ditemukan di database:
if (!$item) {
    setFlash('Data yang ingin diedit tidak ditemukan.', 'danger');
    header('Location: index.php');
    exit;
}

$errors = [];
// Inisialisasi awal form dengan data lama dari database
$name     = $item['name'];
$category = $item['category'];
$price    = (string)$item['price'];
$stock    = (string)$item['stock'];

// 3. Proses jika form disubmit via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price    = trim($_POST['price'] ?? '');
    $stock    = trim($_POST['stock'] ?? '');

    // Validasi Server-Side
    if ($name === '') {
        $errors[] = 'Nama item tidak boleh kosong.';
    } elseif (strlen($name) < 3) {
        $errors[] = 'Nama item minimal terdiri dari 3 karakter.';
    }

    if ($category === '') {
        $errors[] = 'Kategori tidak boleh kosong.';
    }

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

    // Jika validasi lolos, jalankan UPDATE
    if (empty($errors)) {
        // TODO: Sesuaikan nama tabel dan kolom sesuai tema Anda
        $sql = "UPDATE items 
                SET name = :name, category = :category, price = :price, stock = :stock 
                WHERE id = :id";

        $updateStmt = $pdo->prepare($sql);
        $updateStmt->execute([
            'name'     => $name,
            'category' => $category,
            'price'    => (int)$price,
            'stock'    => (int)$stock,
            'id'       => $id,
        ]);

        // Pola PRG: Flash message dan redirect
        setFlash('Data berhasil diperbarui!', 'success');
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - Tugas 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Edit Data</h2>

    <!-- Tampilkan Error Validasi jika ada -->
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

    <form method="POST" action="edit.php?id=<?= $id ?>">
        <!-- TODO: Sesuaikan form input dengan skema tabel Anda -->
        <div class="form-group">
            <label for="name">Nama Item:</label>
            <!-- Tampilkan data lama / data yang baru diketik jika ada error -->
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
            <button type="submit" class="btn btn-primary">Perbarui Data</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
