<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    include 'proses/next.php';
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
        
    </head>
    <body>
        <?php
            include 'template/header.php';
        ?>
        
        <div class="container container-login bg-none">
            <div class="row margin-bot-20 ">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login-pnl">
                        <div class="login-pnl-title bg-pnl-title-signup">
                            <h3><i class="glyphicon glyphicon-th"></i> Data Lengkap</h3>
                        </div>
                        <div class="login-pnl-body">
                            <form role="form" class="form-horizontal" method="POST" action="">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nama Lengkap</label>
                                    <div class="col-md-9">
                                        <input name="nama_lengkap" type="text" class="form-control" placeholder="Nama Lengkap" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Tempat Lahir</label>
                                    <div class="col-md-9">
                                        <input name="tempat_lahir" type="text" class="form-control" placeholder="Tempat Lahir" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Tanggal Lahir</label>
                                    <div class="col-md-5 input-date">
                                        <input name="tanggal_lahir" class="form-control" id="tanggal" placeholder="Tanggal Lahir" type="text" required>
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Jenis Kelamin</label>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label><input value="L" type="radio" name="jenis_kelamin" required>Laki-laki</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label><input value="P" type="radio" name="jenis_kelamin" required>Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Alamat</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" rows="3" name="alamat" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-4">
                                        <a href="<?php echo base_url;?>?p=sign-out" class="btn btn-danger">Batal</a>
                                        <button name="sub" value="datalengkap" type="submit" class="btn btn-info">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="login-pnl-footer">
                        </div>
                    </div>
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
            $(document).ready(function() {
                $('#tanggal').daterangepicker({
                    singleDatePicker: true
                });
                $('#tanggal').val('');
                $('.input-date i').click(function() {
                    $(this).parent().find('input').click();
                });
            });
        </script>
    </body>
</html>