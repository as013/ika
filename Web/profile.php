<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if($_SESSION){
        if($_SESSION['is_login'] == true){
            if($_SESSION['aktif'] == '0'){
                header("Location: ".base_url."?p=datalengkap&id=".$_SESSION['id']);
            }else{
                include 'proses/upload.php';
                include 'proses/profile.php';
                
                
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="assets/images/logo.png">
        <title>Rumah Sakit UNHAS</title>
        
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/daterangepicker.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include 'template/header.php';
            include 'template/menu.php';
        ?>
        <div class="container container-main" >
            <div class="row padding-10bt border-bot">
                <div class="col-md-12">
                    <div class="title"><i class="fa fa-user"></i> My Profile</div>
                </div>
            </div>
            <div class="row padding-15bt">
                <div class="col-md-3 col-md-offset-1">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <img id="image-holder" src="<?php echo $data['foto']?>" class="img-thumbnail" alt="Cinque Terre" style="width: 100%">
                        <input name="imgFile" id="fileUpload" type="file" accept="image/.gif, .jpg, .png" style="visibility: hidden; height: 10px;">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <a id="cari" type="button" class="btn btn-default">Browse</a>
                            <div class="btn-group">
                                <button id="upload" name="upl" value="upload" type="submit" class="btn btn-default" disabled>Upload</button>
                            </div>
                            <div class="btn-group">
                                <button id="cancel" type="button" class="btn btn-default" disabled>Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-7">
                    <form role="form" class="form-horizontal" method="POST" action="">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Lengkap</label>
                            <div class="col-md-9">
                                <input value="<?php echo $data['nama'];?>" id="nama_lengkap" name="nama_lengkap" type="text" class="form-control input" placeholder="Nama Lengkap" required disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input value="<?php echo $data['email'];?>" name="email" type="email" class="form-control input" placeholder="Email" required disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tempat Lahir</label>
                            <div class="col-md-9">
                                <input value="<?php echo $data['tmpLahir'];?>" name="tempat_lahir" type="text" class="form-control input" placeholder="Tempat Lahir" required disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Lahir</label>
                            <div class="col-md-5 input-date">
                                <input value="<?php echo $data['tglLahir'];?>" name="tanggal_lahir" class="form-control input" id="tanggal" placeholder="Tanggal Lahir" type="text" required disabled>
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Jenis Kelamin</label>
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input <?php echo $data['jnsKelamin'] == 'L' ? 'checked':'';?> class="input" value="L" type="radio" name="jenis_kelamin" required disabled>
                                        Laki-laki
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="radio">
                                    <label>
                                        <input <?php echo $data['jnsKelamin'] == 'P' ? 'checked':'';?> class="input" value="P" type="radio" name="jenis_kelamin" required disabled>
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <textarea id="alamat" class="form-control input" rows="3" name="alamat" required disabled><?php echo $data['alamat'];?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-9">
                                <button id="btn_edit" type="reset" class="btn btn-success collapse">Edit</button>
                                <button id="btn_batal" type="reset" class="btn btn-danger collapse">Batal</button>
                                <button id="btn_simpan" name="sub" value="datalengkap" type="submit" class="btn btn-info collapse">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php
            include 'template/footer.php';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/moment.js"></script>
        <script src="assets/js/daterangepicker.js"></script>
        <script>
            $(document).ready( function () {
                var img_def = $('#image-holder').attr('src');
                
                $("#fileUpload").on('change', function () {
 
                    if (typeof (FileReader) !== "undefined") {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("#image-holder").attr('src',e.target.result);
                            $("#upload").removeAttr('disabled');
                            $("#cancel").removeAttr('disabled');
                        };
                        //image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
                
                $("#cancel").click(function(){
                    $("#image-holder").attr('src',img_def);
                    $(this).attr('disabled','true');
                    $("#upload").attr('disabled','true');
                });
                
                $("#cari").click(function(){
                    $("#fileUpload").click();
                });
                
                
                $('#btn_edit').show();
                
                $('#btn_edit').click(function(){
                    //$(":disabled").attr('enabled','true');
                    $(".input").removeAttr('disabled');
                    $(this).hide();
                    $("#btn_batal").show();
                    $("#btn_simpan").show();
                });
                
                $('#btn_batal').click(function(){
                    $(".input").attr('disabled','true');
                    $('#btn_edit').show();
                    $(this).hide();
                    $('#btn_simpan').hide();
                });
                
                $('#tanggal').daterangepicker({
                    singleDatePicker: true
                });
                
            });
        </script>
    </body>
</html>

<?php
            }
        }else{
            header('Location: '.base_url.'?p=login');
        }
    }else{
        header('Location: '.base_url.'?p=login');
    }
?>