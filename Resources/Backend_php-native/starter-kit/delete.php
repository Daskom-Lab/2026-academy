<?php
/**
 * delete.php - Aksi Hapus Data (DELETE)
 * WAJIB HANYA MENERIMA METHOD POST (Tidak boleh GET / diakses langsung via URL)
 */

session_start();

require __DIR__ . '/config/database.php';
require __DIR__ . '/helpers.php';

// 1. Validasi Method HTTP: Tolak keras jika ada yang mengakses via GET / Address Bar
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('Operasi hapus data hanya diperbolehkan melalui method POST!', 'danger');
    header('Location: index.php');
    exit;
}

// 2. Ambil parameter ID yang dikirim dari form POST (atau dari query param form POST)
$id = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);

if ($id > 0) {
    // TODO: Sesuaikan nama tabel Anda
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = :id");
    $stmt->execute(['id' => $id]);

    setFlash('Data berhasil dihapus dari sistem.', 'success');
} else {
    setFlash('ID data yang ingin dihapus tidak valid.', 'danger');
}

// 3. Pola PRG: Selalu akhiri dengan redirect kembali ke halaman utama
header('Location: index.php');
exit;
