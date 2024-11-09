<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

if ($_SESSION['role'] != 'prodi') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $alasan_penolakan = $_POST['alasan_penolakan'];

    $stmt = $conn->prepare("UPDATE pengajuan_judul SET status = ?, alasan_penolakan = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $alasan_penolakan, $id);
    $stmt->execute();
    echo "Status pengajuan diperbarui.";
}

$result = $conn->query("SELECT * FROM pengajuan_judul WHERE status = 'diajukan'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seleksi Judul</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        textarea {
            width: 100%;
            height: 60px;
        }
        .btn-back {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Seleksi Judul</h1>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>Abstrak</th>
                    <th>Status</th>
                    <th>Alasan Penolakan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['abstrak']; ?></td>
                        <td>
                            <form method="post" style="margin: 0;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <select name="status">
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                        </td>
                        <td>
                            <textarea name="alasan_penolakan"></textarea>
                        </td>
                        <td>
                            <button type="submit">Simpan</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Tidak ada judul yang diajukan.</p>
    <?php } ?>

    <button class="btn-back" onclick="window.history.back();">Kembali ke Halaman Sebelumnya</button>
</body>
</html>
