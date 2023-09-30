<?php
function lang($phrase){
    static $lang = array(
        //Dashboard Page
        'Home' => 'Home_Admin',
        'Categories'    => 'Categories',
        'Items'         => 'Items',
        'Members'       => 'Members',
        'Comments'       => 'Comments',
        'Statistics'    => 'Statistics',
        'Logs'          => 'Logs',

    );
    return $lang[$phrase];
}

?>