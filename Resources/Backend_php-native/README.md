# Modul Belajar Mandiri: Backend PHP Native & MySQL (CRUD)

Selamat datang di modul sumber belajar mandiri **Backend PHP Native** untuk Academy 2026! 

Direktori ini dirancang khusus untuk mendampingi kamu dalam memahami materi backend dasar serta menjadi panduan praktis dan terstruktur saat mengerjakan **[Tugas 3: Web CRUD PHP & MySQL](../../Assignment/Backend/Assignment%203.md)**.

---

## 🌐 Slide Presentasi Online (Vercel)

Slide materi lengkap yang dipresentasikan saat workshop dapat kamu akses secara langsung melalui browser:

> **🔗 Link Slide Materi (Vercel):**  
> `https://learn-php-neon.vercel.app/phpdeck.html`

### 💡 Tips Penting Membaca Slide:
1. **Panah Kanan / Kiri (`→` / `←`)**: Navigasi slide utama (*Core Track*).
2. **Panah Bawah (`↓`)**: Membuka materi mendalam (**Self-Study Slide** bertanda kuning). Di dalamnya terdapat studi kasus, checkpoint logic, dan pembahasan mendalam.
3. **Tombol `S` pada Keyboard**: Membuka **Speaker Notes**. Di layar presenter ini terdapat transkrip penjelasan mentor seolah-olah kamu sedang didampingi langsung saat belajar!

---

## 📹 Rekaman Pertemuan / Workshop

Bagi yang ingin mengulang penjelasan saat sesi workshop dan live coding:

> **🎬 Tautan Rekaman:**  
> [ACADEMY BACKEND 2026 - Materi 3-20260911_200456-Meeting Recording.mp4](https://telkomuniversityofficial-my.sharepoint.com/:v:/g/personal/rizalkhairulhashfi_student_telkomuniversity_ac_id/IQC_A7BroZSuQqax4IuYehw0AQnfqDi3P7e8onxGvcMrj4Q)

---

## 📚 Daftar Modul Belajar Mandiri

Setiap dokumen di bawah ini disusun ringkas (*to the point*) agar kamu bisa menjadikannya contekan cepat saat *ngoding*:

1. **[001 - Arsitektur & Mental Model Web](./001_arsitektur_mental_model.md)**  
   Memahami siklus hidup request-response: *Browser $\rightarrow$ HTTP $\rightarrow$ PHP $\rightarrow$ PDO $\rightarrow$ MySQL $\rightarrow$ PRG $\rightarrow$ HTML Response*.
2. **[002 - Konfigurasi Koneksi PDO](./002_koneksi_pdo.md)**  
   Standar koneksi PDO yang aman, penanganan error (`ERRMODE_EXCEPTION`), dan opsi fetch default.
3. **[003 - CRUD dengan Prepared Statements](./003_prepared_statements.md)**  
   Resep query aman untuk operasi `SELECT`, `INSERT`, `UPDATE`, dan `DELETE` guna mencegah serangan SQL Injection.
4. **[004 - Pola PRG (Post-Redirect-Get) & Flash Message](./004_prg_dan_flash_message.md)**  
   Mengapa data mutasi wajib di-redirect dan cara membuat notifikasi user yang elegan menggunakan session.
5. **[005 - Keamanan XSS & Validasi Form](./005_keamanan_dan_validasi.md)**  
   Pencegahan XSS dengan `htmlspecialchars()`, validasi string & angka di server, serta teknik agar input tidak hilang saat form error.
6. **[006 - Ide Tema Bebas & Contoh Skema Database](./006_ide_tema_dan_schema.md)**  
   5 inspirasi skema 1 tabel (minimal 4 kolom) siap pakai untuk Tugas 3.
7. **[007 - Kamus Troubleshooting & Solusi Error Umum](./007_troubleshooting_faq.md)**  
   Solusi cepat untuk error *Headers already sent*, *PDO Connection Refused*, isu konfirmasi hapus, dll.
8. **[008 - Checklist Pra-Pengumpulan Tugas 3](./008_checklist_tugas_3.md)**  
   Lembar audit mandiri untuk memastikan aplikasimu memenuhi 100% kriteria penilaian tugas sebelum di-zip.

---

## 🛠️ Starter Kit Proyek Tugas 3

Untuk memudahkan kamu memulai proyek dengan struktur folder yang benar sesuai spesifikasi tugas, kami menyediakan **Starter Kit** di folder:

📁 **[`starter-kit/`](./starter-kit/)**

Struktur di dalamnya sudah disesuaikan dengan ketentuan pengumpulan:
```text
starter-kit/
├── config/
│   └── database.php    # Template koneksi PDO
├── helpers.php         # Fungsi pembantu e(), setFlash(), getFlash()
├── schema.sql          # Template skema database & seed data awal
├── index.php           # Halaman READ + notifikasi
├── create.php          # Form CREATE + validasi + PRG
├── edit.php            # Form UPDATE + data prefill
├── delete.php          # Handler DELETE (POST only)
├── style.css           # Styling tampilan minimalis modern
└── README.md           # Template laporan tugas
```
Kamu cukup menyalin isi folder `starter-kit/` ke folder proyekmu, membaca komentar instruksi `// TODO:` di setiap file, dan mengembangkannya sesuai tema pilihanmu!
