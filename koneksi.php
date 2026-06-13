<?php
$host = "localhost";
$user = "root"; // sesuaikan dengan user database Anda
$pass = "";     // sesuaikan dengan password database Anda
$db   = "db_manajemen_drone";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>