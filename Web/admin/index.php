<?php
    
    ob_start();
    session_start();
    require_once 'config/config.php';
    
    require_once 'config/Db.php';
    $db = new Db;
    
    if(filter_input(INPUT_GET,'p')){
        $page = filter_input(INPUT_GET,'p');
        if($page === 'home'){
            include 'home.php';
        }elseif ($page === 'login') {
            include 'login.php';
        }elseif ($page === 'signup') {
            include 'signup.php';
        }elseif ($page === 'sign-out'){
            include 'logout.php';
        }elseif ($page === 'dokter'){
            include 'dokter.php';
        }elseif ($page === 'histori'){
            include 'histori.php';
        }elseif ($page === 'pasien'){
            if(filter_input(INPUT_GET,'id')){
                include 'rekam.php';
            }else{
                include 'pasien.php';
            }
        }elseif ($page === 'profiled'){
            include 'profiled.php';
        }elseif ($page === 'up'){
            include 'proses/upload.php';
        }elseif ($page === 'datalengkap') {
            if(filter_input(INPUT_GET,'id')){
                include 'next.php';
            }
        }elseif ($page === 'profile'){
            include 'profile.php';
        }else{
            if(isset($_SESSION['is_login'])){
                header('Location: '.base_url.'?p=home');
            }else{
                header('Location: '.base_url.'?p=login');
            }
        }
    }  else {
        $page = 'home';
        include 'home.php';
    }
