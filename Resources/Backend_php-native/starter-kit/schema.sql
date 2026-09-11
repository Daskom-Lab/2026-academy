-- =============================================================================
-- schema.sql
-- DDL Tabel Utama + Minimal 5 Baris Data Awal (Seed Data)
-- Pastikan berkas ini dapat di-import langsung di phpMyAdmin tanpa error.
-- =============================================================================

-- 1. Inisialisasi Database
CREATE DATABASE IF NOT EXISTS tugas3_db;
USE tugas3_db;

-- 2. Hapus tabel lama jika sudah ada (agar bisa di-import berulang kali tanpa bentrok)
DROP TABLE IF EXISTS items;

-- 3. Buat Tabel Utama
-- TODO: Sesuaikan nama tabel dan kolom sesuai tema yang Anda pilih!
-- Syarat Tugas 3: Satu tabel utama dengan MINIMAL 4 KOLOM di luar 'id'.
-- Kombinasikan antara tipe teks (VARCHAR) dan angka (INT).
CREATE TABLE items (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL, -- Kolom 1 (Teks)
    category    VARCHAR(50)  NOT NULL, -- Kolom 2 (Teks)
    price       INT          NOT NULL, -- Kolom 3 (Angka / Integer)
    stock       INT          NOT NULL, -- Kolom 4 (Angka / Integer)
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Seed Data Awal (Wajib Minimal 5 Baris Data)
INSERT INTO items (name, category, price, stock) VALUES
('Item Contoh Pertama', 'Kategori A', 50000, 10),
('Item Contoh Kedua',   'Kategori B', 75000, 5),
('Item Contoh Ketiga',  'Kategori A', 120000, 2),
('Item Contoh Keempat', 'Kategori C', 25000, 20),
('Item Contoh Kelima',  'Kategori B', 90000, 8);
