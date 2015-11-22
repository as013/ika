<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    include 'proses/signup.php';
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
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include 'template/header.php';
        ?>
        
        <div class="container container-login margin-top-10 bg-none">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-pnl">
                        <div class="login-pnl-title bg-pnl-title-signup">
                            <h3><i class="glyphicon glyphicon-th"></i> Signup</h3>
                        </div>
                        <div class="login-pnl-body">
                            <div class="alert alert-danger collapse" id="alert_msg">
                                <strong>Error!</strong> 
                                <p id="msg"></p>
                            </div>
                            <form role="form" method="POST" action="">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo isset($user) ? $user : '';?>" name="username" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input value="<?php echo isset($email) ? $email : '';?>" name="email" type="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input name="password" type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input name="cpassword" type="password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group pull-right">
                                    <a href="<?php echo base_url;?>?p=login" class="btn btn-danger">Batal</a>
                                    <button name="sub" value="signup" type="submit" class="btn btn-info">Simpan</button>
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
        <script>
            $(document).ready( function () {
                var msg = "<?php echo isset($err) ? $err : 0;?>";
                if(msg !== "0"){
                    $('#msg').append(msg);
                    $('#alert_msg').show();
                    $('#msg').val(msg);
                    window.setTimeout(function() { 
                        $('#alert_msg').hide(); 
                    }, 5000);
                }
            });
        </script>
        
    </body>
</html>