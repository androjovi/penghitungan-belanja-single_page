<?php
include 'koneksi.php';
$sql  = "SELECT * FROM barang";
$exec = mysqli_query($kon, $sql);

while ($get = mysqli_fetch_object($exec)) {
  //echo "<tr><td> $get->kode_barang</td><td>$get->nama_barang</td><td>$get->harga_barang</td></tr>";

  $arr[] = array(
    "kode_barang"   => $get->kode_barang,
    "nama_barang"   => $get->nama_barang,
    "harga_barang"  => $get->harga_barang,
  );

}

echo json_encode($arr);
