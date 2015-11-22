<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");

if(filter_input(INPUT_POST,'upl',FILTER_DEFAULT)){
    if(isset($_FILES['imgFile']['name'])){
        
        $tFile = img_path.$_FILES['imgFile']['name'];
        $imageFileType = strtolower(pathinfo($tFile,PATHINFO_EXTENSION));
        $nmFoto = md5($_SESSION['id']) . '.' . $imageFileType;
        $targetFile = img_path . $nmFoto;
        $check = getimagesize($_FILES["imgFile"]["tmp_name"]);
        
        $uploadOk = 1;
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            //echo "File is not an image.";
            $uploadOk = 0;
        }
         
        if (file_exists($targetFile)) {
            unlink($targetFile);
            $uploadOk = 1;
        }
        
        if ($_FILES["imgFile"]["size"] > 1100000) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["imgFile"]["tmp_name"], $targetFile)) {
                if($_SESSION['level'] == '1'){
                    $query = "UPDATE tblPasien SET foto = :foto WHERE idTblUser = :iduser";
                }else{
                    $query = "UPDATE tblDokter SET foto = :foto WHERE idTblUser = :iduser";
                }
                $dtup = array(
                    'foto' => $nmFoto,
                    'iduser' => $_SESSION['id']
                );
                $update = $db->query($query,$dtup);
                if($update > 0){
                    //$data['foto'] = img_path. $nmFoto;
                    //echo "The file ". basename( $_FILES["imgFile"]["name"]). " has been uploaded.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

