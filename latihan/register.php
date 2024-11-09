<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Mahasiswa, prodi, atau staff_prodi

    // Validasi input
    if (empty($nama) || empty($nim) || empty($password) || empty($role)) {
        echo "Semua field harus diisi.";
    } elseif (!is_numeric($nim) || strlen($nim) != 10) {
        echo "NIM harus berupa 10 digit angka.";
    } elseif (strlen($password) < 5 || strlen($password) > 10) {
        echo "Password harus memiliki 5-10 karakter.";
    } elseif (!in_array($role, ['mahasiswa', 'prodi', 'staff_prodi'])) {
        echo "Role tidak valid.";
    } else {

        // Insert ke database
        $stmt = $conn->prepare("INSERT INTO users (nama, nim, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $nim, $password, $role);

        if ($stmt->execute()) {
            echo "Registrasi berhasil.";
            header("Location: login.php");
            exit();
        } else {
            echo "Gagal mendaftar. Pastikan NIM belum digunakan.";
        }
    }
}
?>
