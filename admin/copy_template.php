<?php 
ob_start(); /* Output Buffering Start */
session_start();
$pageTitle = 'members';

        if(isset($_SESSION['Username'])){
            include 'init.php';
             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if($do == 'Manage') {  //Manage PAge
        echo 'Welcome';
 }elseif ($do == 'Add') {  
                
}elseif ($do == 'Insert'){  
                           
 }elseif ($do == 'Edit') {  

} elseif ($do == 'Update') {

} elseif ($do == 'Activate') { 

}elseif ($do == 'Delete') {

}else {
        header('location: index.php');
        exit();
            }

    include $tpl .'footer.php';
}

ob_end_flush();
?>
