<?php


include 'koneksi.php';
$nama_barang  = $_POST['nama_bar'];
$harga_barang = $_POST['harga_bar'];
$sql = "INSERT INTO barang (nama_barang, harga_barang) VALUES ('$nama_barang', '$harga_barang')";
$exec = mysqli_query($kon, $sql);
if ($exec){
  echo "Berhasil memasukkan data";
}else{
  echo "Tidak berhasil memasukkan data";
}
