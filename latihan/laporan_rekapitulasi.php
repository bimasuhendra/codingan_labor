<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

if ($_SESSION['role'] != 'staff_prodi') {
    header("Location: login.php");
    exit();
}

$query = "
    SELECT 
        u.nama, 
        u.nim, 
        p.judul, 
        p.abstrak, 
        p.status, 
        p.alasan_penolakan,
        CASE 
            WHEN p.status = 'ditolak' THEN '-' 
            WHEN pm.user_id IS NOT NULL THEN 'Sudah Bayar' 
            ELSE 'Belum Bayar' 
        END AS pembayaran_status
    FROM 
        users u
    JOIN 
        pengajuan_judul p ON u.id = p.user_id
    LEFT JOIN 
        pembayaran pm ON u.id = pm.user_id
    WHERE 
        u.role = 'mahasiswa'
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi</title>
</head>
<body>
    <h1>Laporan Rekapitulasi</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Judul</th>
                    <th>Abstrak</th>
                    <th>Status</th>
                    <th>Alasan (Jika Ditolak)</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['nim']); ?></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['abstrak'])); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
                            <?php 
                                echo ($row['status'] == 'ditolak') ? nl2br(htmlspecialchars($row['alasan_penolakan'])) : '-';
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['pembayaran_status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data yang tersedia.</p>
    <?php endif; ?>

    <a href="dashboard_staff_prodi.php">Kembali ke Dashboard</a>
</body>
</html>
