<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $judul = $_POST['judul'];
    $abstrak = $_POST['abstrak'];
    
    $judul_word_count = str_word_count($judul);
    $abstrak_word_count = str_word_count($abstrak);

    if ($judul_word_count > 100) {
        echo "Judul tidak boleh lebih dari 100 kata.";
    } elseif ($abstrak_word_count > 150) {
        echo "Abstrak tidak boleh lebih dari 150 kata.";
    } else {
        $stmt = $conn->prepare("INSERT INTO pengajuan_judul (user_id, judul, abstrak) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $judul, $abstrak);
        $stmt->execute();
        echo "Pengajuan judul berhasil diajukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Judul</title>
</head>
<body>
    <form method="post">
        <label for="judul">Judul (max 100 kata):</label>
        <input type="text" id="judul" name="judul" required>
        <br>
        <label for="abstrak">Abstrak (max 150 kata):</label>
        <textarea id="abstrak" name="abstrak" rows="5" cols="40" required></textarea>
        <br>
        <button type="submit">Ajukan Judul</button>
    </form>
    <li><a href="dashboard_mahasiswa.php">kembali</a></li>
</body>
</html>
