<?php
	if(isset($_POST['hasil'])){
		$tag = $_POST['hasil'];

		require_once 'Db.php';
		$db = new Db;

		$response = array("tag" => $tag, "error" => FALSE);

		if($tag == 'hasil'){
			$iduser = $_POST['id'];
			$hasil = $_POST['hp'];

			$query_hasil = "INSERT INTO tblhuser(idTblUser,tanggal,jam,hasil) 
					VALUES (:iduser,DATE(NOW()),TIME(NOW()),:hasil)";
			$dt = array(
				'iduser' => $iduser,
				'hasil' => $hasil
			);
			$query_has = $db->query($query_hasil, $dt);
			
			if($query_has){
				$response["error"] = FALSE;
				$response["msg"] = "Data telah tersimpan.";
				echo json_encode($response);
			}else{
				$response["error"] = TRUE;
				$response["error_msg"] = "Terjadi Kesalahan Pada Saat Penyimpanan Data.";
				echo json_encode($response);
			}
			
		}else{
			$response["error"] = TRUE;
			$response["error_msg"] = "User Atau Password yang Anda Input Salah.";
			echo json_encode($response);
		}
	}
?>