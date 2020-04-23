<?php
session_start();
include("config.php");

if (isset($_POST["add_to_cart"])) {
  // tampung kode buku dan jumlah Beli
  $kode_buku = $_POST["kode_buku"];
  $jumlah_beli = $_POST["jumlah_beli"];

  // kita ambil data buku dari database
  $sql = "select * from buku where kode_buku = '$kode_buku'";
  $query = mysqli_query($connect, $sql);
  $buku = mysqli_fetch_array($query);

  $item = [
    "kode_buku" => $buku["kode_buku"],
    "judul" => $buku["judul"],
    "image" => $buku["image"],
    "harga" => $buku["harga"],
    "jumlah_beli" => $jumlah_beli
  ];

  // Masukkan item ke keranjang (cart)
  array_push($_SESSION["cart"], $item);

  header("location:tampilan_customer.php");
}
if (isset($_GET["hapus"])) {
  // tampung data kode_buku yg dihapus
  $kode_buku = $_GET["kode_buku"];

  // cari index cart sesuai dengan kode buku
  $index = array_search(
    $kode_buku, array_column(
      $_SESSION["cart"],"kode_buku"
      )
    );

    // hapus item pada CART
    array_splice($_SESSION["cart"], $index, 1);
    header("location: cart.php");
}

// checkout
if (isset($_GET["checkout"])) {
  // memasukkan data pada cart ke database (table transaksi dan detail)


  $id_transaksi = "ID".rand(1.1000);
  $tanggal = date("Y-m-d H:i:s");
  // Y = year, m = Month
  $id_customer = $_SESSION["id_customer"];

  //  make Query
  $sql = "insert into transaksi values('$id_transaksi', '$tanggal', '$id_customer')";
  mysqli_query($connect, $sql);


  foreach ($_SESSION["cart"] as $cart) {
    $kode_buku = $cart["kode_buku"];
    $jumlah = $cart["jumlah_beli"];
    $harga = $cart["harga"];

    // Make querry insert ke tabel detail
    $sql = " insert into detail_transaksi values
    ('$id_transaksi', '$kode_buku', '$jumlah', '$harga')";

    mysqli_query($connect, $sql);
  }
  header("location:transaksi.php");
}
 ?>
