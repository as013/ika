<?php
	if(isset($_POST['reg'])){
		$tag = $_POST['reg'];
		
		require_once 'Db.php';
		$db = new Db;

		$response = array("tag" => $tag, "error" => FALSE);
		
		if($tag == 'reg'){
			$user = $_POST['user'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];

            $cek_user = "SELECT * FROM tbluser WHERE username = :user";
			$data = array('user' => $user);
			$cek_user = $db->row($cek_user,$data);
			if($cek_user > 0){
				$err_usr = 1;
			}

			$cek_email = "SELECT * FROM tbluser WHERE email = :email";
			$data = array('email' => $email);
			$cek_email = $db->row($cek_email,$data);
			if($cek_email > 0){
				$err_usr = 2;
			}

			if(!isset($err_usr)){
				$query = "INSERT INTO tbluser (username,password,email,level,status,statusAktif) 
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
					$get_user = "SELECT * FROM tbluser WHERE username = :user AND password = :pass";
					$dt = array(
							'user' => $user,
							'pass' => md5($pass)
					);
					$get_user = $db->row($get_user,$dt);
					if($get_user){
						$response["error"] = FALSE;
						$response["msg"] = "Data Telah Tersimpan.";
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
		}
	}
?>