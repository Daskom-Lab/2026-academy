<?php
/**
 * helpers.php
 * Kumpulan fungsi bantuan untuk sanitasi XSS dan penanganan notifikasi Flash Message
 */

/**
 * Sanitasi output HTML untuk mencegah serangan Cross-Site Scripting (XSS)
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Simpan pesan flash ke dalam session sebelum melakukan redirect
 */
function setFlash(string $pesan, string $tipe = 'success'): void
{
    $_SESSION['flash'] = [
        'pesan' => $pesan,
        'tipe'  => $tipe,
    ];
}

/**
 * Ambil pesan flash dan langsung hapus agar tidak muncul lagi saat di-refresh
 */
function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}
