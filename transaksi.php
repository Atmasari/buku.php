<?php
session_start();
if (!isset($_SESSION["id_customer"])) {
  header("location:login_customer.php");
}
include("config.php")
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">

  </head>
  <body>

    <div class="header col-12">
      <br />
      <br />

      <h4>Sumber</h4>
      <h1>ILMU</h1>

    </div>

   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Daftar Buku</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <script type="text/javascript.min.js"></script>
     <script type="text/propper.min.js"></script>
     <script type="text/bootstrap.min.js"></script>
     <script type="text/javascript">
       Detail = (item) =>{
         document.getElementById('kode_buku').value = item.kode_buku;
         document.getElementById('judul').innerHTML = item.judul;
         document.getElementById('penulis').innerHTML = item.penulis;
         document.getElementById('harga').innerHTML = item.harga;
         document.getElementById('stok').innerHTML = item.stok;
         document.getElementById('jumlah_beli').value = "1";

         document.getElementById("image").src = "image/" + item.image;
       }
     </script>
   </head>
   <body>
   <nav class="navbar navbar-expand-md bg-info navbar-dark fixed-top">


           <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
               <span class="navbar navbar-toggler-icon"></span>
           </button>


           <div class="collapse navbar-collapse" id="menu">
                   <ul class="navbar-nav">
                       <li class ="nav-item">
                       <a href="cart.php" class="nav-link">
                       Cart(<?php echo count ($_SESSION["cart"]); ?>)
                       </a>
                       </li>

                       <li class="nav-item"><a href="buku.php" class="nav-link">Buku</a></li>
                       <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
                       <li class="nav-item"><a href="list_buku.php" class="nav-link">List Buku</a></li>
                       <li class="nav-item dropdown username" style="padding-right: 50px;">
                           <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="proses_login_customer.php?logout=true" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i><?php echo $_SESSION["nama"]; ?></a>
                           <div class="dropdown-menu">
                               <a class="dropdown-item" <a class="nav-link" href="proses_login_customer.php?logout=true">Logout</a>
                           </div>
                       </li>

                   </ul>
           </div>
   </nav>
   <div class="container">
    <div class= "card-mt-3">
      <div class="card-header bg-secondary">
      <h4 class="text-white">Riwayat Transaksi</h4>
      </div>
      <div class="card-body">
      <?php
      $sql = "select * from transaksi t inner join customer c
      on t.id_customer = c.id_customer
      where t.id_customer = '".$_SESSION["id_customer"]."' order by t.tanggal desc";

      $query = mysqli_query($connect,$sql);
      // masih kosong kantransaksinya, iyaa, udah pak? coba nak
      ?>

      <ul class="list-group">
       <?php foreach ($query as $transaksi): ?>
       <li class = "list-group-item mb-4">
         <h6>ID Transaksi : <?php echo $transaksi["id_transaksi"]; ?></h6>
         <h6>Pembeli : <?php echo $transaksi["nama"];?></h6>
         <h6>Tgl.Transaksi : <?php echo $transaksi["tanggal"];?></h6>
         <h6>List Barang</h6>

         <?php
         $sql2 ="select * from detail_transaksi d inner join buku b
         on d.kode_buku = b.kode_buku
         where d.id_transaksi = '".$transaksi["id_transaksi"]."'";

         $query2 = mysqli_query($connect, $sql2);
         ?>

         <table class="table table-borrderless">
         <thead>
         <tr>
          <th>Judul</th>
          <th>Jumlah</th>
          <th>Harga</th>
          <th>Total</th>
         </tr>
         </thead>
         <tbody>
         <?php $total =0; foreach ($query2 as $detail):?>
         <tr>
         <td><?php echo $detail["judul"];?></td>
         <td><?php echo $detail["jumlah"];?></td>
         <td><?php echo number_format($detail["harga_beli"]);?></td>
         <td>
          Rp <?php echo number_format($detail["harga_beli"]*$detail["jumlah"]);?>
         </td>
         </tr>
         <?php
         $total += ($detail["harga_beli"]*$detail["jumlah"]);
         endforeach;?>
         </tbody>
         </table>
        <h6 class = "text danger" >Rp <?php echo number_format ($total);?></h6>
        </li>
       <?php endforeach;?>
      </ul>
      </div>
    </div>
   </div>
   <br>
   <div class="footer" align="center">
     &copy; Copyright by atmaaa

   </div>
   </body>
 </html>
