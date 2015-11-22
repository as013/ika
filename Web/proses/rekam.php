<?php

defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if(filter_input(INPUT_GET,'id')){
        
        $id = filter_input(INPUT_GET,'id');
        $data = array();
        $query = "SELECT 
            tbluser.`email`,
            tblpasien.`nama`,
            tblpasien.`tempatLahir`,
            tblpasien.`tanggalLahir`,
            tblpasien.`jenisKelamin`,
            tblpasien.`alamat`,
            tblpasien.`foto`
            FROM  
            tblpasien INNER JOIN tbluser ON tblpasien.`idTblUser` = tbluser.`idtblUser` 
            WHERE tblpasien.`idTblUser` = ".$id." AND tbluser.`statusAktif` = 1";
        $res = $db->row($query);
        if($res > 0){
            $data['nama'] = $res['nama'];
            $data['email'] = $res['email'];
            $data['tmpLahir'] = $res['tempatLahir'];
            $data['tglLahir'] = date_format(new DateTime($res['tanggalLahir']),"d/m/Y ");
            $data['jnsKelamin'] = $res['jenisKelamin'] == 'L' ? 'Laki-laki':'Perempuan';
            $data['alamat'] = $res['alamat'];
            if(!empty($res['foto'])){
                $data['foto'] = img_path.$res['foto'];
            }else{
                $data['foto'] = img_path.'user.png';
            }
        }
        
        $hasil = array();
        $qHasil = "SELECT * FROM tblhuser WHERE idTblUser = ".$id." ORDER BY tanggal DESC, jam DESC";
        $has = $db->query($qHasil);
        if($has > 0){
            foreach ($has as $hs){
                $hasil[] = array(
                    'tanggal' => $hs['tanggal'],
                    'jam' => $hs['jam'],
                    'hasil' => $hs['hasil']
                );
            }
        }
    }

