<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if(filter_input(INPUT_GET,'id')){
        if(filter_input(INPUT_POST,'sub',FILTER_DEFAULT)){
            $cek_post = 1;
            
            if(filter_input(INPUT_POST,'nama_lengkap')){
                $nm = filter_input(INPUT_POST,'nama_lengkap');
            }

            if(filter_input(INPUT_POST,'tempat_lahir')){
                $tlahir = filter_input(INPUT_POST,'tempat_lahir');
            }

            if(filter_input(INPUT_POST,'tanggal_lahir')){
                $tgllahir = date("Y-m-d", strtotime(filter_input(INPUT_POST,'tanggal_lahir')));
            }

            if(filter_input(INPUT_POST,'jenis_kelamin')){
                $jkelamin = filter_input(INPUT_POST,'jenis_kelamin');
            }

            if(filter_input(INPUT_POST,'alamat')){
                $alamat = filter_input(INPUT_POST,'alamat');
            }
        }

        $id = filter_input(INPUT_GET,'id');
        $qcek_pasien = "SELECT * FROM tblPasien WHERE idTblUser = :id";
        $dt_id  = array('id' => $id);
        $cek_pasien = $db->row($qcek_pasien,$dt_id);

        if($cek_pasien > 0){
            header('Location : '.base_url);
            if(!isset($cek_post)){
                $nm = $cek_pasien['nama'];
                $tlahir = $cek_pasien['tempatLahir'];
                $tgllahir = $cek_pasien['tanggalLahir'];
                $jkelamin = $cek_pasien['jenisKelamin'];
                $alamat = $cek_pasien['alamat'];
            }

        }else{
            if(isset($cek_post)){
                $query = "INSERT INTO tblPasien(idTblUser,nama,tempatLahir,tanggalLahir,alamat,jenisKelamin) 
                        VALUES(:idUser,:nama,:tlahir,:tgllahir,:alamat,:jkelamin)";
                $data = array(
                    'idUser' => $id,
                    'nama' => $nm,
                    'tlahir' => $tlahir,
                    'tgllahir' => $tgllahir,
                    'alamat' => $alamat,
                    'jkelamin' => $jkelamin
                );
                $insert = $db->query($query,$data);
                if($insert > 0){
                    
                    $qquery_up = "UPDATE tblUser SET statusAktif = :saktif WHERE idtblUser = :iduser";
                    $dt = array(
                            'saktif' => '1',
                            'iduser' => $id
                    );
                    $query_up = $db->query($qquery_up,$dt);
                    if($query_up > 0){
                        $_SESSION['aktif'] = '1';
                        if(isset($_SESSION['is_login'])){
                            if($_SESSION['is_login'] === true){
                                header('Location: '.base_url.'?p=home');
                            }else{
                               header('Location: '.base_url.'p=login');
                            }
                        }
                    }
                    //$msg = "Data telah tersimpan.";

                }else{
                    $err = "Terjadi kesalahan pada saat penyimpanan data.";
                }
            }

        }
    }
