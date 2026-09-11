<?php
/**
 * config/database.php
 * Konfigurasi koneksi database menggunakan PDO
 */

// Tampilkan error selama pengembangan
error_reporting(E_ALL);
ini_set('display_errors', 1);

// TODO: Sesuaikan nama database dengan yang Anda buat di schema.sql / phpMyAdmin
$host    = '127.0.0.1';
$db      = 'tugas3_db'; 
$user    = 'root';
$pass    = ''; // Sesuaikan jika MySQL lokal Anda memiliki password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Wajib Tugas 3
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Wajib Tugas 3
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
