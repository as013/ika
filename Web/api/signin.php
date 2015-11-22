<?php
	if(isset($_POST['tag'])){
		$tag = $_POST['tag'];
		require_once 'Db.php';
		$db = new Db;
		
		$response = array("tag" => $tag, "error" => FALSE);
		
		if ($tag == 'login') {
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			
			$cek_user = "SELECT * FROM tbluser WHERE username = :user AND password = :pass";
			
			$dt = array(
				'user' => $user,
				'pass' => md5($pass)
			);
			
			$res = $db->row($cek_user,$dt);
			
			if($res > 0){
				$id_user = $res['idtblUser'];
				$level = $res['level'];

				$query_up = "UPDATE tbluser SET status = :status WHERE idtblUser = :iduser";
				$dt = array(
					'status' => '1',
					'iduser' => $id_user
				);
				$query_up = $db->query($query_up,$dt);

				if($level == '1'){

					$data = "SELECT * FROM tblpasien WHERE idTblUser = :iduser";
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

						$data = "SELECT * FROM tbldokter WHERE idTblUser = :iduser";
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
						$response["nama"] = $data["nama"];
						$response["email"] = $res["email"];
						$response["foto"] = "http://eng.unhas.ac.id/ikas2/assets/images/".$data["foto"];
						$response["user"]["nama"] = $data["nama"];
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
		}
	}
?>