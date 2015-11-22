<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if($_SESSION){
        if($_SESSION['is_login'] == true){
            $query = "UPDATE tblUser SET status = :status WHERE idtblUser = :iduser";
            $dt = array(
                    'status' => '0',
                    'iduser' => $_SESSION['id']
            );
            $query_up = $db->query($query,$dt);

            session_destroy();
            //header("refresh:3;url=".base_url);
            header('Location: '.base_url.'?p=login');
        }
    }else{
            header('Location: '.base_url.'?p=login');
    }