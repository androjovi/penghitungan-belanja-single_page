<?php
if (!isset($_POST['kod_barang'])) {
    exit("Created by: Joviandro");
}
include 'koneksi.php';
$kod_barang = $_POST['kod_barang'];
$exec = mysqli_query($kon, "SELECT * FROM barang WHERE kode_barang = '$kod_barang' ");

while ($get = mysqli_fetch_object($exec)) {
    $arr[] = array(
          'kode_barang'   => $get->kode_barang,
          'nama_barang'   => $get->nama_barang,
          'harga_barang'  => $get->harga_barang,
      );

    echo json_encode($arr);
}
