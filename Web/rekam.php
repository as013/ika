<?php
    defined('base_url') or die("Tidak Diijinkan Akses Langsung.");
    
    if($_SESSION){
        if($_SESSION['is_login'] == true){
            if($_SESSION['aktif'] == '0'){
                header("Location: ".base_url."?p=datalengkap&id=".$_SESSION['id']);
            }else{
                include 'proses/rekam.php';
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
        <link href="assets/css/morris.css" rel="stylesheet">
    </head>
    <body>
        <?php
            include 'template/header.php';
            include 'template/menu.php';
        ?>
        <div class="container container-main" >
            <div class="row padding-10bt border-bot">
                <div class="col-md-12">
                    <div class="title"><i class="fa fa-user"></i> Detail Pasien</div>
                </div>
            </div>
            <div class="row padding-15bt">
                <div class="col-md-7">
                    <h4>Data Pasien</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <img id="image-holder" src="<?php echo isset($data['foto'])? $data['foto']:'';?>" class="img-thumbnail" alt="Cinque Terre" style="width: 100%">
                        </div>
                        <div class="col-md-8">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nama Lengkap :</label>
                                    <div class="col-md-8">
                                        <label class="control-label text_left"><?php echo isset($data['nama'])? $data['nama']:'';?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Email :</label>
                                    <div class="col-md-8">
                                        <label class="control-label text_left"><?php echo isset($data['email'])? $data['email']:'';?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tempat Lahir :</label>
                                    <div class="col-md-8">
                                        <label class="control-label text_left"><?php echo isset($data['tmpLahir'])? $data['tmpLahir']:'';?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Lahir :</label>
                                    <div class="col-md-8">
                                        <label class="control-label text_left"><?php echo isset($data['tglLahir'])? $data['tglLahir']:'';?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Jenis Kelamin :</label>
                                    <div class="col-md-8">
                                        <label class="control-label text_left"><?php echo isset($data['jnsKelamin'])? $data['jnsKelamin']:'';?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Alamat :</label>
                                    <div class="col-md-8">
                                        <label class="control-label text_left"><?php echo isset($data['alamat'])? $data['alamat']:'';?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4>Rekam Medis</h4>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active">
                            <a href="#graph" aria-controls="graph" role="tab" data-toggle="tab">Graph</a>
                        </li>
                        <li><a href="#table" aria-controls="table" role="tab" data-toggle="tab">Table</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="graph">
                                    <div id="mgraph" style="height: 250px;"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="table" style="padding: 10px;">
                            <table id="table_id" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">Tanggal</th>
                                        <th>Jam</th>
                                        <th>Glukosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($hasil as $hs){
                                ?>
                                    <tr>
                                        <td><?php echo $hs['tanggal'];?></td>
                                        <td><?php echo $hs['jam'];?></td>
                                        <td><?php echo $hs['hasil'];?></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row padding-10bt border-top pos-bot">
                <div class="col-md-12">
                    <a href="<?php echo base_url;?>?p=pasien" class="btn btn-sm btn-success">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <?php
            include 'template/footer.php';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/tab.js"></script>
        <script src="assets/js/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables.bootstrap.js"></script>
        <script src="assets/js/raphael.js"></script>
        <script src="assets/js/morris.js"></script>
        <script>
            $(document).ready( function () {
                $('#table_id').DataTable();
                
                new Morris.Line({
                    // ID of the element in which to draw the chart.
                    element: 'mgraph',
                    // Chart data records -- each entry in this array corresponds to a point on
                    // the chart.
                    data: <?php echo json_encode($hasil);?>,
                    // The name of the data record attribute that contains x-values.
                    xkey: 'jam',
                    // A list of names of data record attributes that contain y-values.
                    ykeys: ['hasil'],
                    // Labels for the ykeys -- will be displayed when you hover over the
                    // chart.
                    labels: ['Hasil'],
                    hideHover: 'auto',
                    parseTime: false,
                    resize: true
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