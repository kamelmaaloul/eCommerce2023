<?php
include 'connect.php';
$tpl   = 'includes/templates/';  //Template directory
$lang  = 'includes/languages/';  //language directory
$func  = 'includes/functions/';    //functions directory
$css   = '../admin/layout/css/';  //css directory
$js    = '../admin/layout/js/';  //js directory

// Includ Import Files
include $lang .  'english.php';
include $func .  'function.php';
include $tpl  .  'header.php';
include $tpl  .  'footer.php';


// Include Navbar in all pages expect one with  $noNavbar  Variable
if(!isset($noNavbar)){include $tpl  .  'navbar.php';}


?>