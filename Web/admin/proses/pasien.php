<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");

$data = array();
$query = "SELECT * FROM tblpasien";

$res = $db->query($query);

if($res > 0){
    $data = $res;
}