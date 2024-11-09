<?php
session_start();
if ($_SESSION['role'] != 'staff_prodi') {
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
    <title>Dashboard Staff Prodi</title>
</head>
<body>
<h1>Selamat datang di Dashboard Staff Prodi, <?php echo $nama; ?>(<?php echo $username; ?>)!</h1>
    <h1>Dashboard Staff Prodi</h1>
    <nav>
        <ul>
            <li><a href="upload_surat.php">Upload Surat Pengantar</a></li>
            <!-- <li><a href="rekap_pembayaran.php">Rekapitulasi Pembayaran</a></li> -->
            <li><a href="laporan_rekapitulasi.php">Laporan Rekapitulasi Pengajuan dan Pembayaran</a></li>
            <li><a href="login.php">Logout</a>
        </ul>
    </nav>
</body>
</html>
