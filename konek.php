<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_kelas_c";

$conn = mysqli_connect($hostname, $username, $password, $database);

if($conn) {
    echo "Koneksi Berhasil <br>";
} else {
    echo "Koneksi Gagal <br>";
}


?>