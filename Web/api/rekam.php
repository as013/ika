<?php
	if(isset($_GET['idu'])){
		$tag = 'rekam';
		
		require_once 'Db.php';
		$db = new Db;

		$response = array("tag" => $tag, "error" => FALSE);
		
		//if($tag == 'rekam'){
			$id = $_GET['idu'];
			
			$sqlData = "SELECT * FROM tblhuser WHERE idTblUser = ".$id." ORDER BY tanggal DESC, jam DESC";
			$has = $db->query($sqlData);
			if($has > 0){
				foreach ($has as $hs){
					$hasil[] = array(
						'tanggal' => $hs['tanggal'],
						'jam' => $hs['jam'],
						'hasil' => $hs['hasil']
					);
				}
				$response["error"] = FALSE;
				$response["hasil"] = $hasil;
				echo json_encode($response);
			}else{
				
			}
		//}
	}
?>