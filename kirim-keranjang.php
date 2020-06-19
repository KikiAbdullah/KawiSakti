<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: admin/login.php");
}
include "koneksi/koneksi.php"; // ambil koneksi;

$masaSewa = $_GET['masa_sewa'];
date_default_timezone_set('Asia/Jakarta'); //MENGUBAH TIMEZONE
$time = date("Y-m-d");

//GET IDUSER dari USERNAME (yg lagi login)
$username = $_SESSION['username'];
$queryIdUser = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$username'") or die("data salah: " . mysqli_error($mysqli));
while ($show = mysqli_fetch_array($queryIdUser)) {
    $idUser = $show['id_user'];
}

if (isset($_GET['submit'])) {
    $idPaket = $_GET['id_paket'];
    $jamPesan = $time;
    $total = NULL;

    $selectPaket = mysqli_query($mysqli, "SELECT JUMLAH_SET , HARGA FROM paket WHERE ID_PAKET='$idPaket'") or die("data salah: " . mysqli_error($mysqli));
    while ($show = mysqli_fetch_array($selectPaket)) {
        $jumlahSet = $show['JUMLAH_SET'];
        $harga = $show['HARGA'];
        $total = $jumlahSet * $harga;
    }
    
//INSERT transaksi_item 
    $insertTransaksiItem = mysqli_query($mysqli, "INSERT INTO transaksi_item SET ID_PAKET='$idPaket', TOTAL='$total'") or die("data salah: " . mysqli_error($mysqli));

    if ($insertTransaksiItem) {
        // header("Location: profilBar.php"); //go to page profilbar
    }
}
