<?php
/**
 * index.php - Halaman Utama (READ)
 * Menampilkan daftar seluruh data dan pesan notifikasi (Flash Message)
 */

session_start();

require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

// Ambil pesan flash jika ada (otomatis terhapus setelah diambil)
$flash = getFlash();

// TODO: Sesuaikan query SELECT dengan nama tabel dan kolom Anda
// Tips: Jika ingin menambahkan fitur nilai tambah Search, gunakan $_GET['q'] dan klausa WHERE LIKE
$q = trim($_GET['q'] ?? '');

if ($q !== '') {
    // Versi Search (Nilai Tambah): Prepared Statement AMAN dengan LIKE
    $stmt = $pdo->prepare("SELECT * FROM items WHERE name LIKE :q ORDER BY id DESC");
    $stmt->execute(['q' => '%' . $q . '%']);
} else {
    // Versi Standar: Ambil seluruh data
    $stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
}

$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Data - Tugas 3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Daftar Data</h1>

    <!-- Tampilkan Notifikasi Flash Message jika ada -->
    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['tipe']) ?>">
            <?= e($flash['pesan']) ?>
        </div>
    <?php endif; ?>

    <div class="header-actions">
        <a href="create.php" class="btn btn-primary">+ Tambah Data Baru</a>
        
        <!-- Form Pencarian Sederhana (Opsional / Nilai Tambah) -->
        <form method="GET" action="index.php" style="display: flex; gap: 6px;">
            <input type="text" name="q" placeholder="Cari nama..." value="<?= e($q) ?>">
            <button type="submit" class="btn btn-secondary">Cari</button>
            <?php if ($q !== ''): ?>
                <a href="index.php" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Cek apakah data kosong (Empty State) -->
    <?php if (empty($items)): ?>
        <div class="empty-state">
            <p>Belum ada data tersedia<?= $q !== '' ? ' untuk pencarian tersebut.' : '.' ?></p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <!-- TODO: Sesuaikan kolom header dengan skema database Anda -->
                    <th>No</th>
                    <th>Nama Item</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <!-- Wajib: Semua teks dinamis di-escape dengan e() untuk mencegah XSS -->
                        <td><?= e($item['name']) ?></td>
                        <td><?= e($item['category']) ?></td>
                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td><?= e((string)$item['stock']) ?></td>
                        <td class="actions">
                            <!-- Tombol Edit: Navigasi GET dengan parameter ID -->
                            <a href="edit.php?id=<?= (int)$item['id'] ?>" class="btn btn-secondary">Edit</a>

                            <!-- Tombol Hapus: WAJIB METHOD POST (Tidak boleh link <a href>) -->
                            <form method="POST" action="delete.php" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                                  style="display: inline;">
                                <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
