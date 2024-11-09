<?php
session_start();
$conn = new mysqli("localhost", "root", "", "latihan");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    // Validasi NIM dan password
    if (!is_numeric($nim) || strlen($nim) != 10) {
        echo "NIM harus berupa angka dan terdiri dari 10 digit.";
    } elseif (strlen($password) < 5 || strlen($password) > 10) {
        echo "Password harus antara 5 hingga 10 karakter.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE nim = ? AND password = ?");
        $stmt->bind_param("ss", $nim, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nim'] = $user['nim'];
            $_SESSION['nama'] = $user['nama'];

            if ($user['role'] == 'mahasiswa') {
                header("Location: dashboard_mahasiswa.php");
            } elseif ($user['role'] == 'prodi') {
                header("Location: dashboard_prodi.php");
            } else {
                header("Location: dashboard_staff_prodi.php");
            }
            exit();
        } else {
            echo "NIM atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <body>
        <h2>Login</h2>
        <form method="POST">
            <label for="nim">Akun Pengguna:</label><br>
            <input type="text" id="username" name="nim" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <label>belum punya akun?<a href="register.html">Register</a></label>
    </body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="post">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html> -->
