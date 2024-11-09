<?php
session_start();
if ($_SESSION['role'] != 'prodi') {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['nim']; // Mendapatkan username dari session
$nama = $_SESSION['nama']; // Mendapatkan username dari session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Prodi</title>
</head>
<body>
<h1>Selamat datang di Dashboard Prodi, <?php echo $nama; ?>(<?php echo $username; ?>)!</h1>
    <h1>Dashboard Prodi</h1>
    <nav>
        <ul>
            <li><a href="seleksi_judul.php">Seleksi Judul</a></li>
            <!-- <li><a href="rekap_pengajuan.php">Rekapitulasi Pengajuan Judul</a></li>
            <li><a href="status_pembayaran.php">Lihat Status Pembayaran Mahasiswa</a></li> -->
            <li><a href="login.php">Logout</a>
        </ul>
    </nav>
</body>
</html>
