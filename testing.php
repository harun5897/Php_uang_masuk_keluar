<?php
    session_start();
    if($_SESSION['posisi']!=="admin" && $_SESSION['posisi']!=="manager"){
        header("location:index.php?pesan=gagal");
    }
    include_once("koneksi.php");
    $filter = false;

    $id_sesion = $_SESSION['id'];

if(isset($_GET['login'])){
    ?>
    <script> var login = true; </script>
    <?php
}    

    
    //FUNGSI UNTUK SIMPAN
if(isset($_POST['b_simpan']))
{
    
    $data = mysqli_query($koneksi, "SELECT * FROM tb_saldo WHERE id = 1");
    $arr = mysqli_fetch_array($data);

    $temp = $_POST['t_jumlah'];

    if($_POST['t_status'] == 'masuk')
    {
        $saldo = $arr['saldo'] + $temp;
    }
    else {
        $saldo = $arr['saldo'] - $temp;
    }

    mysqli_query($koneksi, "UPDATE tb_saldo SET 
            saldo = '$saldo'

            WHERE id = 1
        ");

    //data akan di simpan baru
    $simpan = mysqli_query($koneksi, "INSERT INTO tb_transaksi (tanggal, status, jumlah, keterangan) 
        VALUES ('$_POST[t_tanggal]',
            '$_POST[t_status]', 
            '$_POST[t_jumlah]', 
            '$_POST[t_keterangan]')
        "); 

    if ($simpan) {
        ?>
        <script>
            var simpan = "simpan";
        </script>
        <?php
        
    }
    else {
        header('Location: home.php?');

    }
} 

    //FUNGSI UNTUK FILTER DATA
    if(isset($_POST['b_filter']))
    {
        $dt1 = $_POST["tgl_1"];
        $dt2 = $_POST["tgl_2"];
        $status = $_POST["status"];

        $result = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE tanggal BETWEEN '$dt1' AND '$dt2'");

        $filter = true;

    } 

    //FUNGSI UNTUK CETAK DATA
    if(isset($_POST['b_cetak']))
    {
        $dt1 = $_POST["tgl_1"];
        $dt2 = $_POST["tgl_2"];

        $_SESSION['tgl_1'] = $dt1;
        $_SESSION['tgl_2'] = $dt2;
        header('Location: laporan.php');

    } 

    //FUNGSI UNTUK CHANGE PASSWORD
    if(isset($_POST['b_pass']))
    {
        $pass = $_POST["password"];
        mysqli_query($koneksi, "UPDATE tb_user SET password = '$_POST[password]' WHERE id = '$id_sesion' ");
        
        ?>
        <script>var new_pass = true ;</script>
        <?php
    } 


    //FUNGSI UNTUK GET DATA
    if(isset($_GET['hal']))
    {
        //Pengujian jika hapus data
        if($_GET['hal'] == 'hapus')
        {
            $data = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id = '$_GET[id]' ");
            $arr = mysqli_fetch_array($data);

            $data_saldo = mysqli_query($koneksi, "SELECT * FROM tb_saldo WHERE id = 1 ");
            $arr_saldo = mysqli_fetch_array($data_saldo);

            if($arr['status'] == 'masuk') {

                $saldo = $arr_saldo['saldo'] - $arr['jumlah'];
                mysqli_query($koneksi, "UPDATE tb_saldo SET saldo = '$saldo' WHERE id = 1 ");
            }   
            else{

                $saldo = $arr_saldo['saldo'] + $arr['jumlah'];
                mysqli_query($koneksi, "UPDATE tb_saldo SET saldo = '$saldo' WHERE id = 1 ");

            }

            //hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tb_transaksi WHERE id = '$_GET[id]' " );
            ?>
            <script>var hapus = true; </script>
            <?php
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin</title>

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

<div class=" font">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark trans" style="height: 80px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <div class="mr-auto" style="width: 30%;">
                <a href="home.php"><img src="logo.jpg" style="height: 70px; widht: 70px" alt=""></a>
                <a class="navbar-brand" href="home.php?">PT. Calvindam Jaya EC</a>
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
                        <button class="dropdown-item" type="button"  data-toggle="modal" data-target="#exampleModal2"> <i class="fas fa-key"></i> Change Password</button>
                        <?php
                            if($_SESSION['posisi']!=="manager"){
                        ?>
                        <a href="user.php" class="dropdown-item"> <i class="far fa-id-card"></i> List User </a>
                        <?php } 
                        
                        ?>
                        <a href="logout.php" class="dropdown-item"> <i class="fas fa-power-off"></i> Log Out </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
<!-- NAVBAR PENUTUP -->
    <div class="container rounded" style="background-color: transparent;">

        <!-- CARD PERTAMA -->
        <div class="card" style="background-color: transparent; border-style : none;">
            <div class="card-body" >
                <div class=" row align-items-center rounded" style="width: 103%; background-color: transparent; border-style : none;">
                    <div class="col" style="width: 20%">
                        <!-- informasi saldo -->
                        <div class="brounded-pill text-center text-white" style="width: 200px; height: 70px; margin-left: auto; margin-right: auto; margin-top: auto; margin-bottom: auto">
                            <div class="">
                                <h2><i class="fas fa-money-bill"></i></h2>
                                <?php
                                    $dat = mysqli_query($koneksi, "SELECT * FROM tb_saldo WHERE id = 1");
                                    $arr = mysqli_fetch_array($dat);
                                ?>
                                <H5>Rp. <?=$arr['saldo']?></H5>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CARD KEDUA -->
        <div class="card">
            <div class="card-header bg-success text-white text-center">
                DAFTAR TRANSAKSI
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <?php
                            if($_SESSION['posisi']!=="manager"){
                        ?>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" data-toggle="modal" data-target="#exampleModal"> <i class="fas fa-plus"></i> Data</button>
                        <?php } 
                        
                        ?>
                        <?php
                            if($_SESSION['posisi']!=="admin"){
                        ?>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" data-toggle="modal" data-target="#exampleModal1"> <i class="fas fa-filter"></i> Filter</button>

                        <?php } 
                        
                        ?>
                    </div>
                    <div class="col mb-5">
                        <form class="form-inline ml-6 right">
                        <input class="form-control is-valid mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="myInput">
                        </form>
                    </div>
                </div>
                <div class="scrollable">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Jumlah</th>
                                <th>Ket.</th>
                                <?php
                                    if($_SESSION['posisi']!=="manager"){
                                ?>
                                <th></th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                                $no = 1;

                                $cek = $filter;
                                if($cek == true) {
                                    $tampil = $result;
                                } else
                                $tampil = mysqli_query($koneksi, "SELECT * from tb_transaksi");
                                while($data = mysqli_fetch_array($tampil)) :
                                    
                            ?>
                            <tr>
                                <td> <?=$data['id']?> </td>
                                <td> <?=$data['tanggal'] ?> </td>
                                <td> 
                                    <?= $data['status'] == 'masuk' ? '<span class="badge badge-pill badge-primary"> masuk </span>' :  '<span class="badge badge-pill badge-warning"> keluar </span>'
                                    ?>
                                </td>
                                <td> <?=$data['jumlah']?> </td>
                                <td> <?=$data['keterangan']?> </td>
                                <?php
                                    if($_SESSION['posisi']!=="manager"){
                                ?>
                                <td class="text-center">
                                    <a href="edit.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i></a>
                                
                                    <a href="home.php?hal=hapus&id=<?=$data['id']?>" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i></a>
                                </td>
                                <?php } 
                        
                                ?>
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
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-pen"></i> Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                            <input type="date" class="form-control" name="t_tanggal" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                            <select class="custom-select" name="t_status">
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Input Jumlah" name="t_jumlah" required onkeypress="return event.charCode >= 48 && event.charCode <=57">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Ket : </label>
                            <div class="col-sm-10">
                            <textarea class="form-control" placeholder="Input Keterangan" name="t_keterangan" required></textarea>
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
    <!-- Modal Filter Data -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-filter"></i> Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Dari Tanggal</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="tgl_1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Sampai Tanggal</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="tgl_2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                            <select class="custom-select" name="status">
                                <option value="all">All</option>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="b_filter" class="btn btn-success"> <i class="fas fa-filter"></i> Filter</button>
                    <button type="submit" name="b_cetak" class="btn btn-success"> <i class="fas fa-print"></i> Print</button>
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

// ALERT SIMPAN DATA 
<script>
    if(simpan) {
        Swal.fire({
        icon: 'success',
        title: 'Data Berhasil di Simpan !',
        showConfirmButton: false,
        timer: 1500
});
    setTimeout(function(){
            window.location.href = 'home.php';
        }, 1000);

    }
</script>

// ALERT HAPUS DATA
<script>
    if(hapus) {
        Swal.fire({
        icon: 'success',
        title: 'Data Berhasil di Hapus !',
        showConfirmButton: false,
        timer: 1500
});
    setTimeout(function(){
            window.location.href = 'home.php';
        }, 1000);

    }
</script>

// ALERT LOGIN 
<script>
    if(login) {
        Swal.fire({
                icon: 'success',
                title: 'Berhasil Login !',
                text: 'Selamat Datang di Website Kami !',
                showConfirmButton: false,
                timer: 1700
            });
            setTimeout(function(){
            window.location.href = 'home.php';
        }, 1000);

    }
</script>

//ALERT GANTI PASSWORD
<script>
if(new_pass) {
        Swal.fire({
                icon: 'success',
                text: 'Password Berhasil di Ganti !',
                showConfirmButton: false,
                timer: 1700
            });
            setTimeout(function(){
            window.location.href = 'index.php';
        }, 1000);

    }
</script>


</html>