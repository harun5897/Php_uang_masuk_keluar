<?php
session_start();
if($_SESSION['posisi']!=="admin"){
    header("location:index.php?pesan=gagal");
}
include_once("koneksi.php");


$id_sesion = $_SESSION['id'];

if(isset($_POST['b_simpan']))
    {
         //data akan di simpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO tb_user (nama, email, posisi, password) 
        VALUES ('$_POST[t_nama]',
            '$_POST[t_email]', 
            '$_POST[t_posisi]', 
            '$_POST[t_password]')
        "); 
        header('Location: user.php');

        if($simpan) {
            echo "berhasil";
        } else {
            echo "gagal";
        }

    }

    if(isset($_GET['hal']))
    {
        //Pengujian jika hapus data
        if($_GET['hal'] == 'hapus')
        {
            //hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tb_user WHERE id = '$_GET[id]' " );
            header('Location: user.php');
        }
    }

    //FUNGSI UNTUK CHANGE PASSWORD
    if(isset($_POST['b_pass']))
    {
        $pass = $_POST["password"];
        mysqli_query($koneksi, "UPDATE tb_user SET password = '$_POST[password]' WHERE id = '$id_sesion' ");
        
        header("location:index.php");
    } 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>

    <!--STYLING CSS DAN JQUERY BOOTSTRAP  -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fa/css/all.css">
    <link rel="stylesheet" type="text/css" href="scss/table.css">
    
    <script type="text/javascript" src="jquery/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="pooper/pooper.min.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"> </script>
    <script type="text/javascript" src="js/bootstrap.js"> </script>
    <!--TUTUP STYLING CSS DAN JQUERY BOOTSTRAP  -->

</head>
<body>

<div class="">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark trans" style="height: 80px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <div class="mr-auto" style="width: 30%;">
                <a href="home.php"><img src="logo.jpg" style="height: 70px; widht: 70px" alt=""></a>
                <a class="navbar-brand" href="home.php">PT. Calvindam Jaya EC</a>
            </div>
            <div class="mr-auto ml-auto text-center text-white" style="width: 40%;">
                <h3>~ SISTEM INFORMASI KEUANGAN ~</h3>
            </div>
            <div class="ml-auto text-right" style="width: 30%;">
                <div class="btn-group dropleft">
                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-cog"></i> Admin
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#exampleModal2"> <i class="fas fa-key"></i> Change Password</button>
                        <a href="user.php" class="dropdown-item"> <i class="far fa-id-card"></i> List User </a>
                        <a href="logout.php" class="dropdown-item"> <i class="fas fa-power-off"></i> Log Out </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<!-- NAVBAR PENUTUP -->
    <div class="container bg-light rounded" style="">
        <!-- CARD PERTAMA -->
        <div class="card">
            <div class="card-header bg-success text-white text-center">
                DAFTAR USER
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-plus"></i> <strong> User </strong> </button>
                    </div>
                    <div class="col mb-5">
                        <form class="form-inline ml-6 right">
                        <input class="form-control is-valid mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="myInput">
                        </form>
                    </div>
                </div>
                <div class="scrollable_user">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Posisi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                                $no = 1;
                                $tampil = mysqli_query($koneksi, "SELECT * from tb_user");
                                while($data = mysqli_fetch_array($tampil)) :
                            ?>
                            <tr>
                                <td> <?=$data['id']?> </td>
                                <td> <?=$data['nama']?> </td>
                                <td> <?=$data['email']?> </td>
                                <td> <?=$data['posisi']?> </td>
                                <td class="text-center">
                                    <a href="user_edit.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i></a>
                                
                                    <a href="user.php?hal=hapus&id=<?=$data['id']?>" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                                <?php
                                
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>

    <!-- Modal tambah data -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-pen"></i> Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Input Nama" name="t_nama" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Input Email" name="t_email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                            <select class="custom-select" name="t_posisi" required>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Password </label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Input Password" name="t_password" required>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="b_simpan"> <i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal GANTI PASSWORD -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-key"></i> Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="password" placeholder="Password baru anda">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="b_pass" class="btn btn-warning"> <i class="fas fa-key"></i> Ok</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Penutup DIV Awal -->
</div>

</body>

<!-- FITUR FILTER KEYUP -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
</html>