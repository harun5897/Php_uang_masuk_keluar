<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "kp_2020";

$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
    // $koneksi = mysqli_connect($server, $user, $pass, $database);

    // if (!$koneksi) {
    //     die("Connection failed: " . mysqli_connect_error());
    // }
    // echo "Connected successfully";
    // mysqli_close($koneksi);

    

?>
