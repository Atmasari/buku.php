<?php
  session_start();
  if (!isset($_SESSION["id_customer"])) {
    header("location:login_customer.php");
  }

  // mengambil file config.php
  // agar tidak perlu membuat koneksi baru
  include("config.php");
  // include("counter/counter.php");
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Toko Buku</title>
    <!-- css-bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- js-bootstrap -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <!-- navbar -->
    <link href="" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dc8a681ba8.js" crossorigin="anonymous"></script>
  </head>
  <style media="screen">
  /* vertical-center */
  .vertical-center {
    min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
    min-height: 100vh; /* These two lines are counted as one :-)       */

    display: flex;
    align-items: center;
  }
  </style>
  <body>
    <!-- Card -->
    <?php
      // Perintah SQL untuk Menampilkan Data buku
      if (isset($_GET["find"])) {
        // Query jika Melakukan Pencarian
        $find = $_GET["find"];
        $sql = "select * from buku
                where kode_buku like '%$find%'
                or judul like '%$find%'
                or penulis like '%$find%'
                or tahun like '%$find%'
                or harga like '%$find%'
                or stok like '%$find%'";
      } else {
        // Query Jika tidak mencari
        $sql = "select * from buku";
      }
      // eksekusi perintah sql
      // $connect -> mengambil dari config.php
      $query = mysqli_query($connect, $sql);
     ?>

    <!-- header-menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                </li>
            </ul>
            <div class="input-group mb-3">
              <div class="collapse navbar-collapse" id="navbarCollapse">
                  <div class="navbar-nav">
                      <a href="list_buku.php?logout=true" class="nav-item nav-link ">List Buku</a>

                      <a href="transaksi.php?logout=true" class="nav-item nav-link ">Transaksi</a>

                </div>
            </div>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: white;"><i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: white;"><i class="fas fa-shopping-cart"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: white"><i class="fas fa-envelope"></i></a>
                </li>
                <li class="nav-item dropdown username" style="padding-right: 50px;">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i><?php echo $_SESSION["nama"]; ?></a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="proses_login_customer.php?logout=true"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- end header-menu -->

    <div class="container">
      <div class="card">
        <div class="card-header bg-light">
          <h4>Keranjang belanja Anda</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($_SESSION["cart"] as $cart): ?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $cart["judul"] ?></td>
                  <td>Rp. <?php echo $cart["harga"] ?></td>
                  <td><?php echo $cart["jumlah_beli"] ?></td>
                  <td>Rp. <?php echo $cart["jumlah_beli"]*$cart["harga"] ?></td>
                  <td>
                    <a href="proses_cart.php?hapus=true&kode_buku=<?php echo $cart["kode_buku"] ?>">
                      <i class="fa fa-trash" style="cursor:pointer;color:#66b0ff;">
                      </i>
                    </a>
                  </td>
                </tr>
              <?php $no++; endforeach; ?>
            </tbody>
            <tfoot>
              <a href="proses_cart.php?checkout=true">
                <button type="button" class="btn btn-success">
                  Checkout
                </button>
              </a>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

  </body>
</html>
