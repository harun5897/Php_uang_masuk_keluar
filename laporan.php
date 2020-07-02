<?php
    session_start();
    include_once("koneksi.php");

    $tgl_1 = $_SESSION['tgl_1'];
    $tgl_2 = $_SESSION['tgl_2'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        @page {
            size: A4
        }
        h1 {
            font-weight: bold;
            font-size: 20pt;
            text-align: center;
        }
        h3 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
        }
        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<section class="sheet padding-10mm">
        <h1>LAPORAN KEUANGAN</h1>
        <h3>PT. Calvindam Jaya ec</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $tampil = mysqli_query($koneksi,  "SELECT * FROM tb_transaksi WHERE tanggal BETWEEN '$tgl_1' AND '$tgl_2'");
                    while($data = mysqli_fetch_array($tampil)) :
                ?>
                <tr>
                    <td> <?=$data['id']?> </td>
                    <td> <?=$data['tanggal']?> </td>
                    <td> <?=$data['status']?> </td>
                    <td> <?=$data['jumlah']?> </td>
                    <td> <?=$data['keterangan']?> </td>
                </tr>
                <?php endwhile; ?>
                <?php
                
                ?>
            </tbody>
        </table>
    </section>
    
</body>
</html>