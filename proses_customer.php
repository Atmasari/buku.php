<?php
    include("config.php");
    if (isset($_POST["save_customer"])) {
        $action = $_POST["action"];
        $id_customer = $_POST["id_customer"];
        $nama = $_POST["nama"];
        $alamat = $_POST["alamat"];
        $kontak = $_POST["kontak"];
        $username = $_POST["username"];
        $password = $_POST["password"];
 // gimana?
 // tida bisa pak editnya? iya pak, hapus juga
        if ($action == "insert") {
            $sql = "insert into customer values ('$id_customer','$nama','$alamat', '$kontak', '$username', '$password')";
            mysqli_query($connect, $sql);

        }elseif ($action == "update") {
            $sql = "update customer set nama='$nama', alamat = '$alamat', kontak='$kontak',
                    username='$username', password='$password' where id_customer='$id_customer'";
// ini pak yg tampil
            $query = mysqli_query($connect, $sql);
        }

        header("location:customer.php");
    }

    if (isset($_GET["hapus"])) {
        include("config.php");
        $id_customer = $_GET["id_customer"];


        $sql = "delete from customer where id_customer='$id_customer'";
        $query = mysqli_query($connect, $sql);

        header("location:customer.php");
    }
 ?>