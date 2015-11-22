<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if($_SESSION){
        if($_SESSION['is_login'] == true){
            if($_SESSION['aktif'] == '0'){
                header("Location: ".base_url."?p=datalengkap&id=".$_SESSION['id']);
            }else{
                include 'proses/pasien.php';
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
            <div class="row padding-10bt border-bot">
                <div class="col-md-12">
                    <div class="title"><i class="fa fa-users"></i> Pasien</div>
                </div>
            </div>
            <div class="row padding-15bt">
                <div class="col-md-12">
                    <table id="table_id" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Tempat/Tangal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                                foreach ($data as $dt) {
                                    $no++;
                            ?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $dt['nama'];?></td>
                                <td><?php echo $dt['tempatLahir'].", ".$dt['tanggalLahir'];?></td>
                                <td><?php echo $dt['jenisKelamin'] == 'L' ? 'Laki-laki':'Perempuan';?></td>
                                <td><?php echo $dt['alamat'];?></td>
                                <td>
                                    <a href="<?php echo base_url;?>?p=pasien&id=<?php echo $dt['idTblUser'];?>" class="btn btn-sm btn-info">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
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
            }
        }else{
            header('Location: '.base_url.'?p=login');
        }
    }else{
        header('Location: '.base_url.'?p=login');
    }
?>