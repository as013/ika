<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
$_SESSION['cek'] = '0';
if(filter_input(INPUT_POST,'sub',FILTER_DEFAULT)){
    if(filter_input(INPUT_POST,'username')){
        $user = filter_input(INPUT_POST,'username');
    }

    if(filter_input(INPUT_POST,'email')){
        $email = filter_input(INPUT_POST,'email');
    }

    if(filter_input(INPUT_POST,'password')){
        $pass = filter_input(INPUT_POST,'password');
    }

    if(filter_input(INPUT_POST,'cpassword')){
        $cpass = filter_input(INPUT_POST,'cpassword');
    }

    if($pass != $cpass){
        $err = "Password tidak sama.";
    }else{
        $qcek_user = "SELECT * FROM tblUser WHERE username = :user";
        $data_user = array('user' => $user);
        $cek_user = $db->row($qcek_user,$data_user);
        if($cek_user > 0){
            $err_usr = 1;
        }

        $qcek_email = "SELECT * FROM tblUser WHERE email = :email";
        $data_email = array('email' => $email);
        $cek_email = $db->row($qcek_email,$data_email);
        if($cek_email > 0){
            $err_usr = 2;
        }
        
        if($cek_user > 0 && $cek_email > 0){
            $err_usr = 3;
        }
        if(!isset($err_usr)){
            $query = "INSERT INTO tblUser (username,password,email,level,status,statusAktif) 
                    VALUES (:user,:pass,:email,:level,:status,:saktif)";
            $data = array(
                'user' => $user,
                'pass' => md5($pass),
                'email' => $email,
                'level' => '1',
                'status' => '0',
                'saktif' => '0'
            );
            $insert = $db->query($query,$data);
            if($insert > 0){
                $qq_id = "SELECT idtblUser FROM tblUser WHERE username = :user AND password = :pass";
                $data = array(
                        'user' => $user,
                        'pass' => md5($pass)
                );
                $q_id = $db->row($qq_id,$data);
                $_SESSION['cek'] = '1';
                header("refresh:3;url=".base_url."?p=datalengkap&id=".$q_id['idtblUser']);
            }else{
                $err = "Terjadi kesalahan pada saat penyimpanan data.";
            }
        }else{
            if($err_usr == 1){
                $err = "Username telah terdaftar";
            }elseif ($err_usr == 2) {
                $err = "Email telah terdaftar";
            }else{
                $err = "Username dan Email telah terdaftar.";
            }
        }
    }
}


