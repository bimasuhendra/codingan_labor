<?php
session_start();
if ($_SESSION['role'] != 'mahasiswa') {
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
    <title>Dashboard Mahasiswa</title>
</head>
<body>
<h1>Selamat datang di Dashboard Mahasiswa, <?php echo $nama; ?>(<?php echo $username; ?>)!</h1>
    <nav>
        <ul>
            <li><a href="pengajuan_judul.php">Pengajuan Judul</a></li>
            <li><a href="pembayaran.php">Pembayaran</a></li>
            <li><a href="status_pengajuan.php">Lihat Status Pengajuan Judul</a></li>
            <li><a href="login.php">Logout</a>
        </ul>
    </nav>
</body>
</html>