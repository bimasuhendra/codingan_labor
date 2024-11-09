<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

if ($_SESSION['role'] != 'staff_prodi') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $file_name = $_FILES['file_surat']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);

    if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO surat_pengantar (user_id, file_surat) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $target_file);
        $stmt->execute();
        echo "Surat pengantar berhasil diunggah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Surat Pengantar</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label>Upload Surat Pengantar:</label>
        <input type="file" name="file_surat" required>
        <input type="hidden" name="user_id" value="1"> <!-- Sesuaikan user_id -->
        <br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
