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
            $tampil = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                $v_tanggal = $data['tanggal'];
                $v_status = $data['status'];
                $v_jumlah = $data['jumlah'];
                $v_keterangan = $data['keterangan'];
            }
        }
    }

    if(isset($_POST['b_edit']))
    {   
        if($_GET['hal'] == 'edit')
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

           //data akan di edit
            mysqli_query($koneksi, "UPDATE tb_transaksi SET 
                tanggal = '$_POST[t_tanggal]',
                status = '$_POST[t_status]',
                jumlah = '$_POST[t_jumlah]',
                keterangan = '$_POST[t_keterangan]'
    
                WHERE id = '$_GET[id]'
            ");
            header("location:home.php");
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
    <title>Admin Edit</title>

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
                <a class="navbar-brand" href="#">PT. Calvindam Jaya EC</a>
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
        <div class="card" style="border-style : none; background-color: transparent; ">
            <div class="card-body">
                <div class="card mt-4 w-50" style="margin-left: auto; margin-right: auto; border-style : none;">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-pen"></i> . Edit Data
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-10">
                                <input type="date" class="form-control" name="t_tanggal" value="<?=@$v_tanggal?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                <select class="custom-select" name="t_status">
                                    <option value="<?=@$v_status?>"> <?=@$v_status?> </option>
                                    <option value="masuk">Masuk</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Jumlah</label>
                                <div class="col-sm-10">
                                <input type="" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <=57" placeholder="Input Jumlah" name="t_jumlah" value="<?=@$v_jumlah?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Ket : </label>
                                <div class="col-sm-10">
                                <textarea class="form-control" name="t_keterangan" placeholder="Input Keterangan" required> <?=@$v_keterangan?> </textarea>
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
</html>