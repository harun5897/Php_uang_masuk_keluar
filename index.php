<?php
session_start();

include_once("koneksi.php");

    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $data_user = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE email = '$_POST[email]' AND password = '$_POST[password]'");
        $akun = mysqli_fetch_array($data_user);

        $email = $akun['email'];
        $password = $akun['password'];
        $level = $akun['posisi'];
        $id = $akun['id'];

        

        if($email == $email && $pass == $password) {
            $_SESSION['posisi'] = $level;
            $_SESSION['id'] = $id;
            header('location:home.php');
        }else
        {
            echo " gagal login";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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

    <div>
    <div class="">
        <div class="container">
            <div class="card tengah" style="width : 45%">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img style="height: 341px;" src="gambar1.jpg" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body bg-light rounded">
                        <form method="post" action="">
                            <div class="text-center">
                                <H3> <strong> PT. Calvindam Jaya EC </strong> </H3>
                                <HR></HR>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input  name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <button type="submit" class="btn btn-success" name="login">Login</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    
</body>
</html>