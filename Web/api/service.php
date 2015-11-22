<?php
    if (filter_input(INPUT_POST,'tag',FILTER_DEFAULT)) {
        /*
        if(filter_input(INPUT_POST,'tag') != ''){
            $tag = filter_input(INPUT_POST,'tag');
            require_once 'config/Db.php';
            $db = new Db;
            
            $response = array("tag" => $tag, "error" => FALSE);
            
            if($tag == 'login'){
                $user = filter_input(INPUT_POST,'user');
                $pass = filter_input(INPUT_POST,'pass');
                
                $cek_user = "SELECT * FROM tblUser 
                        WHERE username = :user AND password = :pass AND statusAktif = :saktif AND level = :level";
                $dt = array(
                    'user' => $user,
                    'pass' => $pass,
                    'saktif' => '1',
                    'level' => '1'
                );
                
                $res = $db->row($cek_user,$dt);
                if($res > 0){
                    $id_user = $res['idtblUser'];
                    $level = $res['level'];

                    $q_up = "UPDATE tblUser SET status = :status WHERE idtblUser = :iduser";
                    $dt = array(
                        'status' => '1',
                        'iduser' => $id_user
                    );
                    $query_up = $db->query($q_up,$dt);
                    
                    $response["error"] = FALSE;
                    $response["id"] = $res['idtblUser'];
                    $response["user"]["name"] = $data["nama"];
                    $response["user"]["email"] = $res["email"];
                    $response["user"]["statusAktif"] = $res["statusAktif"];
                    
                    echo json_encode($response);
                }else {
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Invalid username or password.";
                    echo json_encode($response);
                }
            }elseif($tag == 'register'){
                $user = filter_input(INPUT_POST,'user');
                $email = filter_input(INPUT_POST,'email');
                $pass = filter_input(INPUT_POST,'pass');
                
                $c_user = "SELECT * FROM tblUser WHERE username = :user";
                $data = array('user' => $user);
                $cek_user = $db->row($c_user,$data);
                if($cek_user > 0){
                        $err_usr = 1;
                }
                
                $c_email = "SELECT * FROM tblUser WHERE email = :email";
                $dtemail = array('email' => $email);
                $cek_email = $db->row($c_email,$dtemail);
                if($cek_email > 0){
                        $err_usr = 2;
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
                        
                    }
                }
            }
        }*/
        
        
    $tag = $_POST['tag'];
    require_once 'config/Db.php';
    $db = new Db;

    $response = array("tag" => $tag, "error" => FALSE);

    if ($tag == 'login') {

            $user = filter_input(INPUT_POST,'user');
            $pass = filter_input(INPUT_POST,'pass');

            $cek_user = "SELECT * FROM tblUser WHERE username = :user AND password = :pass";
                    $dt = array(
                            'user' => $user,
                            'pass' => md5($pass)
                    );

                    $res = $db->row($cek_user,$dt);
                    if($res > 0){

                            $id_user = $res['idtblUser'];
                            $level = $res['level'];

                            $query_up = "UPDATE tblUser SET status = :status WHERE idtblUser = :iduser";
                            $dt = array(
                                    'status' => '1',
                                    'iduser' => $id_user
                            );
                            $query_up = $db->query($query_up,$dt);

                            if($level == '1'){

                                    $data = "SELECT * FROM tblPasien WHERE idTblUser = :iduser";
                                    $dt = array(
                                            'iduser' => $id_user
                                    );

                                    $data = $db->row($data,$dt);

                                    if($data > 0){
                                            $par_cek = 1;
                                    }else{
                                            $par_cek = 0;
                                    }

                            }elseif ($level == '2') {

                                    $data = "SELECT * FROM tblDokter WHERE idTblUser = :iduser";
                                    $dt = array(
                                            'iduser' => $id_user
                                    );

                                    $data = $db->row($data,$dt);

                                    if($data > 0){
                                            $par_cek = 1;
                                    }else{
                                            $par_cek = 0;
                                    }

                            }

                            if(isset($par_cek)){

                                    if($par_cek == 1){
                                            $response["error"] = FALSE;
                                $response["uid"] = $res['idtblUser'];
                                $response["user"]["name"] = $data["nama"];
                                $response["user"]["email"] = $res["email"];
                                $response["user"]["statusAktif"] = $res["statusAktif"];
                                echo json_encode($response);
                                    }else{
                                            $response["error"] = TRUE;
                                $response["error_msg"] = "Data Tidak Dapat Ditemukan.";
                                echo json_encode($response);
                                    }

                            }
                    }else{
                            $response["error"] = TRUE;
                $response["error_msg"] = "User Atau Password yang Anda Input Salah.";
                echo json_encode($response);
                    }

    }elseif($tag == 'register'){

            $user = $_POST['user'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];

            $cek_user = "SELECT * FROM tblUser WHERE username = :user";
                    $data = array('user' => $user);
                    $cek_user = $db->row($cek_user,$data);
                    if($cek_user > 0){
                            $err_usr = 1;
                    }

                    $cek_email = "SELECT * FROM tblUser WHERE email = :email";
                    $data = array('email' => $email);
                    $cek_email = $db->row($cek_email,$data);
                    if($cek_email > 0){
                            $err_usr = 2;
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
                                    $get_user = "SELECT * FROM tblUser WHERE username = :user AND password = :pass";
                                    $dt = array(
                                            'user' => $user,
                                            'pass' => md5($pass)
                                    );
                                    $get_user = $db->row($get_user,$dt);
                                    if($get_user > 0){
                                            $response["error"] = FALSE;
                                            $response["uid"] = $get_user["idtblUser"];
                                            $response["user"]["user"] = $get_user["username"];
                                            $response["user"]["email"] = $get_user["email"];
                                            $response["user"]["statusAktif"] = $get_user["statusAktif"];
                                            echo json_encode($response);
                                    }
                            }else{
                                    $response["error"] = TRUE;
                    $response["error_msg"] = "Terjadi Kesalahan Pada Saat Penyimpanan Data.";
                    echo json_encode($response);
                            }
                    }else{
                            if($err_usr == 1){
                                    $response["error"] = TRUE;
                        $response["error_msg"] = "User telah terdaftar.";
                        echo json_encode($response);
                            }elseif ($err_usr == 2) {
                                    $response["error"] = TRUE;
                        $response["error_msg"] = "Email telah terdaftar.";
                        echo json_encode($response);
                            }
                    }

    }elseif($tag == 'reg_next'){

            $nama = $_POST['nama'];
            $tmplahir = $_POST['tmplahir'];
            $tgllahir = $_POST['tgllahir'];
            $jnskel = $_POST['jnskel'];
            $alamat = $_POST['alamat'];
            $iduser = $_POST['iduser'];

            $query_save = "INSERT INTO tblPasien(idTblUser,nama,tempatLahir,tanggalLahir,alamat,jenisKelamin) 
                            VALUES(:iduser,:nama,:tmplahir,:tgllahir,:alamat,:jnskel)";
                    $data = array(
                            'iduser' => $iduser,
                            'nama' => $nama,
                            'tmplahir' => $tmplahir,
                            'tgllahir' => $tgllahir,
                            'alamat' => $alamat,
                            'jnskel' => $jnskel
                    );
                    $query_save = $db->query($query_save,$data);

                    if($query_save > 0){
                            $query_up = "UPDATE tblUser SET statusAktif = :saktif WHERE idtblUser = :iduser";
                            $data = array(
                                    'saktif' => '1',
                                    'iduser' => $iduser
                            );
                            $query_up = $db->query($query_up,$data);
                            if($query_up > 0){
                                    $response["error"] = FALSE;
                                    $response["msg"] = "Data Telah Tersimpan.";
                                    echo json_encode($response);
                            }else{
                                    $response["error"] = TRUE;
                    $response["error_msg"] = "Terjadi Kesalahan Pada Saat Penyimpanan Data.";
                    echo json_encode($response);
                            }
                    }else{
                            $response["error"] = TRUE;
            $response["error_msg"] = "Terjadi Kesalahan Pada Saat Penyimpanan Data.";
            echo json_encode($response);
                    }

    }elseif($tag == 'hasil') {

            $iduser = $_POST['iduser'];
            $hasil = $_POST['hasil'];

            $query_hasil = "INSERT INTO tblHUser(idTblUser,tanggal,jam,hasil) 
                    VALUES (:iduser,DATE(NOW()),TIME(NOW()),:hasil)";
            $dt = array(
                    'iduser' => $iduser,
                    'hasil' => $hasil
            );
            $query_hasil = $db->query($query_hasil, $dt);

            if($query_hasil > 1){
                    $response["error"] = FALSE;
            $response["msg"] = "Data telah tersimpan.";
            echo json_encode($response);
            }else{
                    $response["error"] = TRUE;
            $response["msg"] = "Terjadi Kesalahan Pada Saat Penyimpanan Data.";
            echo json_encode($response);
            }

    }elseif($tag == 'logout'){

            $iduser = $_POST['iduser'];

            $query_up = "UPDATE tblUser SET status = :status WHERE idtblUser = :iduser";
            $dt = array(
                    'status' => '0',
                    'iduser' => $iduser
            );
            $query_up = $db->query($query_up,$dt);
            if($query_up > 0){
                    $response["error"] = FALSE;
            $response["msg"] = "Logout Sukses.";
            echo json_encode($response);
            }else{
                    $response["error"] = TRUE;
            $response["msg"] = "Logout Gagal.";
            echo json_encode($response);
            }

    }

    }else{
            $response["error"] = TRUE;
    $response["error_msg"] = "Tag Tidak Ditemukan.";
    echo json_encode($response);
    }
?>