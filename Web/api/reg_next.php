<?php
	if(isset($_POST['next'])){
		$tag = $_POST['next'];
		
		require_once 'Db.php';
		$db = new Db;

		$response = array("tag" => $tag, "error" => FALSE);
		
		if($tag == 'next'){
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
		}
	}
?>