<?php
session_start();
include_once("koneksi.php");

$id_sesion = $_SESSION['id'];

    if(isset($_GET['hal']))
    {
        //Pengujian jika edit data
        if($_GET['hal'] == 'edit')
        {
            //tampilkand data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $v_nama = $data['nama'];
                $v_email = $data['email'];
                $v_posisi = $data['posisi'];
                $v_password = $data['password'];
            }
        }
    }

    if(isset($_POST['b_edit']))
    {   
        if($_GET['hal'] == 'edit')
        {   
           //data akan di edit
            mysqli_query($koneksi, "UPDATE tb_user SET 
                nama = '$_POST[t_nama]',
                email = '$_POST[t_email]',
                posisi = '$_POST[t_posisi]',
                password = '$_POST[t_password]'
                WHERE id = '$_GET[id]'
            ");
            ?>
            <script> var edit = true;</script>
            <?php
        } 
    }

    //FUNGSI UNTUK CHANGE PASSWORD
    if(isset($_POST['b_pass']))
    {
        $pass = $_POST["password"];
        mysqli_query($koneksi, "UPDATE tb_user SET password = '$_POST[password]' WHERE id = '$id_sesion' ");
        ?>
        <script> var new_pass = true;</script>
        <?php
    } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Edit</title>
    <!--STYLING CSS DAN JQUERY BOOTSTRAP  -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fa/css/all.css">
    <link rel="stylesheet" type="text/css" href="scss/table.css">
    
    <script type="text/javascript" src="jquery/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="pooper/pooper.min.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"> </script>
    <script type="text/javascript" src="js/bootstrap.js"> </script>
    <!--TUTUP STYLING CSS DAN JQUERY BOOTSTRAP  -->

    <!-- SWALL -->
    <script src="alert/sweetalert2.all.min.js"></script>
</head>
<body>
<div class="min-vh-100 bg-info">
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
    <div class="container">

        <!-- CARD PERTAMA -->
        <div class="card bg-info" style="border-style : none;">
            <div class="card-body">
                <div class="card mt-4 w-50" style="margin-left: auto; margin-right: auto; border-style : none;">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-pen"></i> . User Edit
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                <input type="text" class="form-control" name="t_nama" value="<?=@$v_nama?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                <input type="email" class="form-control" name="t_email"  value="<?=@$v_email?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Posisi</label>
                                <div class="col-sm-9">
                                <input type="" class="form-control" name="t_posisi" value="<?=@$v_posisi?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Password </label>
                                <div class="col-sm-9">
                                <input type="password" class="form-control" name="t_password" value="<?=@$v_password?>">
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="b_edit" class="btn btn-success"> <i class="fas fa-save"></i> Simpan</button>
                        </form>
                    </div>
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
<script>
    if(edit) {
        Swal.fire({
        icon: 'success',
        title: 'Data Berhasil di Edit !',
        showConfirmButton: false,
        timer: 1500
});
    setTimeout(function(){
            window.location.href = 'user.php';
        }, 1000);

    }
</script>

<!-- //ALERT NEW PASSWORD -->
<script>
if(new_pass) {
        Swal.fire({
                icon: 'success',
                title: 'Password Berhasil di Ganti !',
                showConfirmButton: false,
                timer: 1700
            });
            setTimeout(function(){
            window.location.href = 'index.php';
        }, 1000);

    }
</script>
</html>