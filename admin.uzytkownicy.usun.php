<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);
session_start();

require_once 'vendor/autoload.php';

use Ibd\Uzytkownicy;

if(isset($_POST)) {
    $uzytkownicy = new Uzytkownicy();
    if($uzytkownicy->usun($_GET['id']))
	echo 'ok';
}
