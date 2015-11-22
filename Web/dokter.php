<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if($_SESSION){
        if($_SESSION['is_login'] == true){
            include 'proses/dokter.php';
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
        
        <link href="assets/css/dataTables.bootstrap.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include 'template/header.php';
            include 'template/menu.php';
        ?>
        <div class="container container-main" >
            <div class="row">
                <div class="col-md-12 bg-green margin-bot-15">
                    <h4 class="judul">Data Dokter</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="table_id" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>2</td>
        </tr>
        <tr>
            <td>3</td>
            <td>4</td>
        </tr>
    </tbody>
</table>
                </div>
            </div>
        </div>
        
        <?php
            include 'template/footer.php';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready( function () {
                $('#table_id').DataTable();
            } );
        </script>
        
    </body>
</html>

<?php
        }else{
            header('Location: '.base_url.'index.php?p=login');
        }
    }else{
        header('Location: '.base_url.'index.php?p=login');
    }
?>

