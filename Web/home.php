<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if($_SESSION){
        if($_SESSION['is_login'] == true){
            if($_SESSION['aktif'] == '0'){
                header("Location: ".base_url."?p=datalengkap&id=".$_SESSION['id']);
            }else{
                include 'proses/home.php';
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
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include 'template/header.php';
            include 'template/menu.php';
        ?>
        <div class="container container-main" >
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
        
        <?php
            include 'template/footer.php';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        
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