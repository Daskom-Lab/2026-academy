# 001 - Arsitektur & Mental Model Web

## 1. Mental Model: Dari C ke PHP

Jika sebelumnya kamu terbiasa memprogram dengan bahasa **C**, ada perbedaan fundamental dalam cara kode dieksekusi:

| Karakteristik | Bahasa C | PHP (Web Server) |
| :--- | :--- | :--- |
| **Eksekusi** | Dikompilasi jadi biner, proses hidup terus di memori sistem selama aplikasi berjalan. | Diinterpretasikan per request oleh web server (Apache/Nginx/Built-in). |
| **Siklus Hidup** | State (variabel di memori) bertahan selama program belum di-`return 0` / exit. | **Stateless**: PHP lahir saat HTTP Request datang, mengeksekusi baris kode, mengirim response, lalu **langsung mati**. Semua variabel di memori hilang. |
| **Output** | Ditulis ke konsol terminal (`printf`). | Ditulis ke dalam HTTP Response Body (biasanya berupa string HTML) yang dikirim ke browser. |

Karena PHP mati setelah mengirim respon, kita membutuhkan:
1. **Database (MySQL)**: Untuk menyimpan data secara permanen (persisten).
2. **Session (`$_SESSION`)**: Untuk mengingat data sementara antar-halaman (misalnya flash message notifikasi).

---

## 2. Alur Request-Response Lengkap

Setiap kali pengguna mengklik link, membuka URL, atau men-submit form, alur siklus kerja backend adalah sebagai berikut:

```text
[ Browser / Klien ]
        │  (1) HTTP Request (GET / POST)
        ▼
[ Web Server & PHP ]
        │  (2) Validasi input user ($_GET / $_POST)
        │  (3) Siapkan Query SQL via PDO (Prepared Statements)
        ▼
[ Database MySQL ]
        │  (4) Eksekusi query & kembalikan data baris/row
        ▼
[ Web Server & PHP ]
        │  (5) Olah data array PHP (looping foreach / render template)
        │  (6) Escape karakter berbahaya (htmlspecialchars)
        ▼
[ Browser / Klien ]
        (7) Menerima HTTP Response (HTML murni) dan me-render tampilan visual
```

> **Ingat:** Browser **tidak pernah melihat kode PHP**. Browser hanya menerima HTML hasil akhir yang sudah diproses oleh server PHP.

---

## 3. GET vs POST: Kapan Menggunakan yang Mana?

- **Gunakan method `GET`**:
  - Untuk operasi **baca data / navigasi / pencarian** (`READ`).
  - Parameter data tampak di URL (contoh: `index.php?q=laptop` atau `edit.php?id=5`).
  - Aman di-refresh, di-bookmark, dan tidak boleh mengubah isi database.
- **Gunakan method `POST`**:
  - Untuk operasi **mutasi / pengubahan data** (`CREATE`, `UPDATE`, `DELETE`).
  - Data dikirim di dalam *request body*, tidak tampak di URL bar.
  - **Wajib diakhiri dengan Pola PRG (Post-Redirect-Get)** agar user tidak sengaja mengirim ulang data ganda saat menekan tombol refresh.
