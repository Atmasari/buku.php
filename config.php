<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$db = "toko_buku";
$connect = mysqli_connect($host,$username,$password,$db);

// Cek Koneksi database
if (mysqli_connect_errno()) {
  // Menampilkan pesan ERROR ketika koneksi gagal
  echo mysqli_connect_error();
}
else {
  echo "Koneksi Berhasil";
}

 ?>
