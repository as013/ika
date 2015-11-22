<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");

if(filter_input(INPUT_POST,'sub',FILTER_DEFAULT)){
    if(filter_input(INPUT_POST,'username')){
        $user = filter_input(INPUT_POST,'username');
    }

    if (filter_input(INPUT_POST,'password')) {
        $pass = filter_input(INPUT_POST,'password');
    }
    
    $query = "SELECT * FROM tblUser WHERE username = :user AND password = :pass AND level = :level";
    $data = array(
        'user' => $user,
        'pass' => md5($pass),
        'level' => 3
    );

    $res = $db->row($query,$data);

    if($res > 0){

        $query = "UPDATE tblUser SET status = :status WHERE idtblUser = :iduser";
        $dt = array(
            'status' => '1',
            'iduser' => $res['idtblUser']
        );
        $query_up = $db->query($query,$dt);
        $_SESSION['is_login'] = true;
        $_SESSION['cek'] = '1';
        $_SESSION["id"] = $res['idtblUser'];
        $_SESSION["level"] = $res['level'];
        $_SESSION["aktif"] = $res['statusAktif'];
        header('Location: '.base_url.'?p=home');
    }else{
        $_SESSION['is_login'] = false;
        $msg = "Username atau Password tidak ditemukan.";
    }
}

