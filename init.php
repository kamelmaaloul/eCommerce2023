<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

include '../eCommerce/admin/connect.php';

$sessionUser = '';
if(isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}


$tpl   = '../eCommerce/includes/templates/';  //Template directory
$lang  = '../eCommerce/admin/includes/languages/';  //language directory
$func  = '../eCommerce/includes/functions/';    //functions directory
$css   = '../eCommerce/layout/css/';  //css directory
$js    = '../eCommerce/layout/js/';  //js directory

// Includ Import Files
include $lang .  'english.php';
include $func .  'function.php';
include $tpl  .  'header.php';

?>