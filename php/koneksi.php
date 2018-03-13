<?php 
define('userw','root');
define('passw','');

$kon = mysqli_connect('localhost',userw,passw,'penjualan');

if (!$kon){
    die("Koneksi sangat berhasil");
}
