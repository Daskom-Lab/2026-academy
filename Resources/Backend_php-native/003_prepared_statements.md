# 003 - CRUD dengan Prepared Statements

## 1. Bahaya Menggabungkan String SQL (SQL Injection)

❌ **KODE BERBAHAYA (DILARANG KERAS DI TUGAS 3):**
```php
// JANGAN PERNAH LAKUKAN INI!
$id = $_GET['id'];
$sql = "SELECT * FROM buku WHERE id = " . $id;
$pdo->query($sql);
```
Jika pengguna memasukkan `1 OR 1=1`, penyerang bisa membaca seluruh isi database Anda atau bahkan menghapus tabel (`1; DROP TABLE buku;`).

✅ **SOLUSI STANDAR INDUSTRI: Prepared Statements**
```php
// AMAN: Pisahkan struktur SQL dari data input user
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch();
```
Pada prepared statement:
1. Server database mengompilasi **struktur query** terlebih dahulu menggunakan placeholder (`:id` atau `?`).
2. Nilai input dari pengguna dikirim terpisah murni sebagai **data teks**, sehingga karakter spesial SQL seperti `'` atau `--` tidak akan dieksekusi sebagai perintah program.

---

## 2. Resep 4 Operasi CRUD Wajib

### A. READ: Ambil Semua Data (`index.php`)
```php
// Jika tanpa parameter input, bisa langsung query()
$stmt = $pdo->query("SELECT id, judul, penulis, tahun, stok FROM buku ORDER BY id DESC");
$daftar_buku = $stmt->fetchAll(); // Mengembalikan array 2 dimensi

// Cek apakah data kosong:
if (empty($daftar_buku)) {
    // Tampilkan pesan kosong
}
```

### B. READ ONE: Ambil 1 Data Berdasarkan ID (`edit.php`)
```php
$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT id, judul, penulis, tahun, stok FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(); // Mengembalikan 1 baris array asosiatif (atau false jika tidak ketemu)

if (!$buku) {
    // Jika ID tidak ada di database, jangan biarkan halaman kosong atau error fatal!
    // Redirect kembali ke index dengan notifikasi error
    header('Location: index.php');
    exit;
}
```

### C. CREATE: Tambah Data Baru (`create.php`)
```php
$sql = "INSERT INTO buku (judul, penulis, tahun, stok) 
        VALUES (:judul, :penulis, :tahun, :stok)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'judul'   => $judul,
    'penulis' => $penulis,
    'tahun'   => $tahun,
    'stok'    => $stok,
]);
```

### D. UPDATE: Ubah Data Berdasarkan ID (`edit.php`)
```php
$sql = "UPDATE buku 
        SET judul = :judul, penulis = :penulis, tahun = :tahun, stok = :stok 
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'judul'   => $judul,
    'penulis' => $penulis,
    'tahun'   => $tahun,
    'stok'    => $stok,
    'id'      => $id,
]);
```

### E. DELETE: Hapus Data Berdasarkan ID (`delete.php`)
```php
$id = (int) ($_GET['id'] ?? 0); // Atau dari $_POST['id']

$stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
```

---

## 3. Fitur Nilai Tambah: Pencarian Aman dengan `LIKE`

Jika ingin mengambil nilai tambah fitur pencarian kata kunci:

```php
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul LIKE :q OR penulis LIKE :q");
    // Masukkan tanda wildcard (%) di dalam array parameter, BUKAN di dalam string SQL
    $stmt->execute(['q' => '%' . $keyword . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM buku");
}

$hasil = $stmt->fetchAll();
```

> ⚠️ **Catatan Penting:** Jangan pernah menulis `LIKE '%:q%'` di dalam string SQL karena database akan menganggapnya sebagai teks literal `":q"`.
