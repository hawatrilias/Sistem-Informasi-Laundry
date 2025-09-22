<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "laundry_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if(!$koneksi){
    die ("Koneksi Gagal:" . mysql_connect_error());
}

?>