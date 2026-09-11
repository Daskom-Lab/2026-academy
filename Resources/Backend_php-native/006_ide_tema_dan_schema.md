# 006 - Ide Tema Bebas & Contoh Skema Database

Sesuai dengan ketentuan **Tugas 3**:
- Bebas memilih tema apa pun.
- Gunakan **satu tabel utama** saja (dilarang membuat relasi multi-tabel / foreign key agar fokus ke alur CRUD).
- Minimal memiliki **4 kolom data di luar `id`**, dengan kombinasi tipe data teks dan angka (agar bisa diuji validasi integer/numerik).
- File `schema.sql` wajib memuat perintah `CREATE TABLE` dan minimal **5 baris data awal (seed)**.

Berikut adalah 5 inspirasi skema database siap pakai yang bisa langsung kamu sesuaikan:

---

### Pilihan 1: Katalog Buku Perpustakaan
```sql
CREATE DATABASE IF NOT EXISTS perpustakaan_db;
USE perpustakaan_db;

DROP TABLE IF EXISTS books;

CREATE TABLE books (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(150) NOT NULL,
    author       VARCHAR(100) NOT NULL,
    publish_year INT          NOT NULL,
    stock        INT          NOT NULL,
    category     VARCHAR(50)  NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO books (title, author, publish_year, stock, category) VALUES
('Laskar Pelangi', 'Andrea Hirata', 2005, 12, 'Novel'),
('Bumi Manusia', 'Pramoedya Ananta Toer', 1980, 5, 'Sastra'),
('Filosofi Teras', 'Henry Manampiring', 2018, 20, 'Self Improvement'),
('Clean Code', 'Robert C. Martin', 2008, 8, 'Teknologi'),
('Atomic Habits', 'James Clear', 2018, 15, 'Self Improvement');
```

---

### Pilihan 2: Inventaris Game Toko
```sql
CREATE DATABASE IF NOT EXISTS gamestore_db;
USE gamestore_db;

DROP TABLE IF EXISTS games;

CREATE TABLE games (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    genre       VARCHAR(50)  NOT NULL,
    price       INT          NOT NULL,
    rating      INT          NOT NULL, -- skala 1-100
    platform    VARCHAR(50)  NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO games (title, genre, price, rating, platform) VALUES
('Elden Ring', 'Action RPG', 599000, 96, 'PC / Steam'),
('Cyberpunk 2077', 'RPG', 450000, 86, 'PC / Steam'),
('The Witcher 3', 'RPG', 250000, 93, 'Multi-platform'),
('Hollow Knight', 'Metroidvania', 115000, 90, 'PC / Steam'),
('Valorant Points 1000', 'Voucher', 150000, 85, 'Riot Games');
```

---

### Pilihan 3: Pencatat Pengeluaran Keuangan Pribadi
```sql
CREATE DATABASE IF NOT EXISTS expense_db;
USE expense_db;

DROP TABLE IF EXISTS expenses;

CREATE TABLE expenses (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    title          VARCHAR(150) NOT NULL,
    amount         INT          NOT NULL,
    category       VARCHAR(50)  NOT NULL,
    expense_date   DATE         NOT NULL,
    payment_method VARCHAR(50)  NOT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO expenses (title, amount, category, expense_date, payment_method) VALUES
('Makan Siang Nasi Padang', 25000, 'Makanan', '2026-09-01', 'QRIS'),
('Beli Kuota Internet', 100000, 'Utilitas', '2026-09-02', 'Transfer Bank'),
('Kopi Susu Senja', 18000, 'Minuman', '2026-09-03', 'Tunai'),
('Bensin Motor Full Tank', 35000, 'Transportasi', '2026-09-04', 'Tunai'),
('Langganan Spotify', 55000, 'Hiburan', '2026-09-05', 'Kartu Debit');
```

---

### Pilihan 4: Daftar Menu Kafe / Restoran
```sql
CREATE DATABASE IF NOT EXISTS cafe_db;
USE cafe_db;

DROP TABLE IF EXISTS menu_items;

CREATE TABLE menu_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(100) NOT NULL,
    category     VARCHAR(50)  NOT NULL,
    price        INT          NOT NULL,
    calories     INT          NOT NULL,
    is_available VARCHAR(20)  NOT NULL, -- 'Tersedia' / 'Habis'
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO menu_items (name, category, price, calories, is_available) VALUES
('Caramel Macchiato', 'Minuman', 38000, 240, 'Tersedia'),
('Croissant Almond', 'Pastry', 28000, 320, 'Tersedia'),
('Americano Ice', 'Minuman', 25000, 15, 'Tersedia'),
('Spaghetti Carbonara', 'Makanan Berat', 45000, 580, 'Tersedia'),
('Waffle Ice Cream', 'Dessert', 32000, 410, 'Habis');
```

---

### Pilihan 5: Manajemen Kamar Kost
```sql
CREATE DATABASE IF NOT EXISTS kost_db;
USE kost_db;

DROP TABLE IF EXISTS rooms;

CREATE TABLE rooms (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    room_number   VARCHAR(20)  NOT NULL,
    room_type     VARCHAR(50)  NOT NULL,
    monthly_price INT          NOT NULL,
    capacity      INT          NOT NULL,
    facility      VARCHAR(200) NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO rooms (room_number, room_type, monthly_price, capacity, facility) VALUES
('A-01', 'Deluxe AC', 1500000, 1, 'AC, Kasur Queen, Kamar Mandi Dalam, Wifi'),
('A-02', 'Standard Non-AC', 850000, 1, 'Kipas Angin, Kasur Single, Lemari, Wifi'),
('B-01', 'VIP Suite', 2200000, 2, 'AC, Water Heater, TV, Balkon Pribadi'),
('B-02', 'Deluxe AC', 1500000, 1, 'AC, Kasur Queen, Meja Belajar, Wifi'),
('C-01', 'Standard Non-AC', 800000, 1, 'Kipas Angin, Kasur Single, Kamar Mandi Luar');
```

---

### Tips Penting Saat Menyusun `schema.sql`:
1. Pastikan skrip SQL bisa di-import langsung di **phpMyAdmin** lokal tanpa error sintaks sebelum kamu mengumpulkan tugas.
2. Selalu gunakan tipe `INT` untuk kolom harga, stok, tahun, nominal, atau jumlah agar bisa kamu uji menggunakan `filter_var($val, FILTER_VALIDATE_INT)`.
