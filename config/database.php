<?php

$host = "localhost";
$database = "dani-toko";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
mysqli_close($conn);
?>