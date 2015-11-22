<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
/*
$query_hasil = "INSERT INTO tblhuser(idTblUser,tanggal,jam,hasil) 
                VALUES (:iduser,DATE(NOW()),TIME(NOW()),:hasil)";
        $dt = array(
            'iduser' => 2,
            'hasil' => 200
        );
        $query_h = $db->query($query_hasil, $dt);*/
$data = array();
$query = "SELECT * FROM tblhuser WHERE idTblUser = ".$_SESSION['id']." ORDER BY tanggal DESC, jam DESC";

$res = $db->query($query);

if($res > 0){
    $data = $res;
}