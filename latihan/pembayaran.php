<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $file_name = $_FILES['bukti_pembayaran']['name'];
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); // Mengambil ekstensi file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);

    // Daftar ekstensi file yang diizinkan
    $allowed_types = ["pdf", "jpg", "jpeg", "png"];

    if (in_array($file_type, $allowed_types)) { // Memeriksa apakah tipe file diperbolehkan
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO pembayaran (user_id, bukti_pembayaran) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $target_file);
            $stmt->execute();
            echo "Bukti pembayaran berhasil diunggah.";
        } else {
            echo "Gagal mengunggah file.";
        }
    } else {
        echo "Jenis file tidak diizinkan. Hanya PDF, JPG, JPEG, dan PNG yang diperbolehkan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label>Upload Bukti Pembayaran:</label>
        <input type="file" name="bukti_pembayaran" required>
        <br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
