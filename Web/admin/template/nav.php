<?php
defined('base_url') or die("Tidak Diijinkan Akses Langsung.");

$_url = base_url;
if($_SESSION){
    if($_SESSION['level'] == 3){
        $menu = array(
            array(
                'title' => 'Home',
                'page' => 'home',
                'link' => $_url.'?p=home',
                'icon' => 'fa fa-home fa-lg'
            ),/*
            array(
                'title' => 'Dokter',
                'page' => 'dokter',
                'link' => $_url.'?p=dokter',
                'icon' => 'fa fa-user-md fa-lg'
            ),*/
            array(
                'title' => 'Pasien',
                'page' => 'pasien',
                'link' => $_url.'?p=pasien',
                'icon' => 'fa fa-users fa-lg'
            ),/*
            array(
                'title' => 'Kontak',
                'page' => 'kontak',
                'link' => $_url.'?p=kontak',
                'icon' => 'fa fa-phone fa-lg'
            ),*/
            array(
                'title' => 'Dokter',
                'page' => 'dokter',
                'link' => $_url.'?p=dokter',
                'icon' => 'fa fa-user-md fa-lg'
            ),
            array(
                'title' => 'Logout',
                'page' => 'sign-out',
                'link' => $_url.'?p=sign-out',
                'icon' => 'fa fa-sign-out fa-lg'
            )
        );
    }
}
/*
else{
    $menu = array(
        array(
                'title' => 'Home',
                'link' => $_url.'?p=home',
                'icon' => 'fa fa-home '
        ),
        array(
                'title' => 'Dokter',
                'link' => $_url.'?p=dokter',
                'icon' => 'fa fa-users'
        ),
        array(
                'title' => 'About',
                'link' => $_url.'?p=about',
                'icon' => 'fa fa-book-open'
        ),
        array(
                'title' => 'Kontak',
                'link' => $_url.'?p=kontak',
                'icon' => 'fa fa-phone'
        ),
        array(
                'title' => 'Login',
                'link' => $_url.'?p=login',
                'icon' => 'fa fa-login'
        ),
        array(
                'title' => 'Signup',
                'link' => $_url.'?p=fagnup',
                'icon' => 'fa fa-user-follow'
        )
    );
}*/