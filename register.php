<?php
session_start();
require 'koneksi.php';

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password' AND status='$status'");

    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['username'] = $data['username'];
        $_SESSION['status'] = $data['status'];
        header("Location: dashboard.php");
    }

    else{
        $error = "Username, Password Salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sistem Manajemen Drone</title>
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container d-flex justify-content-center">
        <div class="card p-4 shadow-sm" style="width: 400px;">
        <div class="text-center mb-4">
            <h3><b>Register</b></h3>
            <p class="text-muted"> Sistem Manajemen Drone</p>
             <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        </div>
        <form action="" method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="">Status</label>
                <select name="status" class="form-select" id="">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>

            <button type="submit" name="" class="btn btn-dark w-100 mb-2"> Register </button>
             <div class="text-center small">Sudah punya akun? <a href="login.php">Masuk disini</a></div>
        </form>
        </div>
    </div>
    
</body>
</html>