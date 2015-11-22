<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");

$data = array();
$query = "SELECT * FROM tblhuser WHERE idTblUser = ".$_SESSION['id'];

$res = $db->query($query);

if($res > 0){
    $data = $res;
}