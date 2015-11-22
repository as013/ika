<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");

if(filter_input(INPUT_POST,'sub',FILTER_DEFAULT)){
    $nm = filter_input(INPUT_POST,'nama_lengkap');
    $email = filter_input(INPUT_POST,'email');
    $tmpLahir = filter_input(INPUT_POST,'tempat_lahir');
    $tgllahir = date("Y-m-d", strtotime(filter_input(INPUT_POST,'tanggal_lahir')));
    $jkelamin = filter_input(INPUT_POST,'jenis_kelamin');
    $alamat = filter_input(INPUT_POST,'alamat');
    
    $upDt = "UPDATE tblDokter SET 
        nama = :nama,
        tempatLahir = :tlahir,
        tanggalLahir = :tglLahir,
        alamat = :alamat,
        jenisKelamin = :jnsKelamin WHERE idTblUser = :iduser";
    $dtUpDd = array(
        'nama' => $nm,
        'tlahir' => $tmpLahir,
        'tglLahir' => $tgllahir,
        'alamat' => $alamat,
        'jnsKelamin' => $jkelamin,
        'iduser' => $_SESSION['id']
    );
    $upData = $db->query($upDt,$dtUpDd);
    
    $upEmail = "UPDATE tblUser SET email = :email WHERE idtblUser = :iduser";
    $dtUpEmail = array(
        'email' => $email,
        'iduser' => $_SESSION['id']
    );
    $upDtEmail = $db->query($upEmail,$dtUpEmail);
    
    $data = getDataDokter($db);
}else{
    $data = getDataDokter($db);
}

function getDataDokter($db){
    $data = array();
    $query = "SELECT 
        tbluser.`email`,
        tbldokter.`nama`,
        tbldokter.`tempatLahir`,
        tbldokter.`tanggalLahir`,
        tbldokter.`jenisKelamin`,
        tbldokter.`alamat`,
        tbldokter.`foto`
        FROM  
        tbldokter INNER JOIN tblUser ON tbldokter.`idTblUser` = tblUser.`idtblUser` 
        WHERE tbldokter.`idTblUser` = ".$_SESSION["id"];
    $res = $db->row($query);
    if($res > 0){
        $data['nama'] = $res['nama'];
        $data['email'] = $res['email'];
        $data['tmpLahir'] = $res['tempatLahir'];
        $data['tglLahir'] = date_format(new DateTime($res['tanggalLahir']),"m/d/Y ");
        $data['jnsKelamin'] = $res['jenisKelamin'];
        $data['alamat'] = $res['alamat'];
        if(!empty($res['foto'])){
            $data['foto'] = img_path.$res['foto'];
        }else{
            $data['foto'] = img_path.'user.png';
        }
    }
    return $data;
}