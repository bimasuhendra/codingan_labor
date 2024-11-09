<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

// Cek jika user sudah login dan role adalah mahasiswa
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil semua pengajuan judul mahasiswa dari database
$stmt = $conn->prepare("SELECT judul, abstrak, status, alasan_penolakan FROM pengajuan_judul WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Status Pengajuan Judul</title>
</head>
<body>
    <h1>Status Pengajuan Judul Skripsi</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Abstrak</th>
                    <th>Status</th>
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; // Inisialisasi nomor urut
                while ($pengajuan = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                        <td><?php echo htmlspecialchars($pengajuan['judul']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($pengajuan['abstrak'])); ?></td>
                        <td><?php echo htmlspecialchars($pengajuan['status']); ?></td>
                        <td>
                            <?php 
                                if ($pengajuan['status'] == 'ditolak') {
                                    echo nl2br(htmlspecialchars($pengajuan['alasan_penolakan']));
                                } else {
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda belum mengajukan judul skripsi.</p>
    <?php endif; ?>

    <a href="dashboard_mahasiswa.php">Kembali ke Dashboard</a>
</body>
</html>
