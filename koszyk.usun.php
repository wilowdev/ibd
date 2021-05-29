<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
session_start();
require_once 'vendor/autoload.php';

use Ibd\Koszyk;

$koszyk = new Koszyk();

if(isset($_POST['id_koszyka'])) {
    $koszyk->zmienLiczbeSztuk([$_POST['id_koszyka'] => 0]);
    echo 'ok';
}