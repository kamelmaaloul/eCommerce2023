<?php

function getTitle (){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else {
        echo 'Default';
    }


}

/*    Redirect Function     */
function redirectHome($theMsg,$url=null, $seconds =3) {
    if($url===null) {$url = 'index.php';
                    }else {
                        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){
                        $url = $_SERVER['HTTP_REFERER'];
                    } else { $url = 'index.php';
                    }
                }
    echo $theMsg;
    echo"<div class='alert alert-info'> You will be redirected to Previous Page after $seconds seconds.</div>";
    header("refresh:$seconds;url= $url");
    exit();
}

/*   Function to check Database */
 function checkItem($select,$from,$value){
    global $con;
    $statement = $con->prepare("SELECT $select  FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}

/*   Count of Items in the Table */
function countItems($item , $table) {
    global $con;
    $statement2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $statement2->execute();
    return $statement2->fetchColumn();
}

/*     Latest Record  Function     */
function getLatest($select,$table,$order,$limit=5){
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchALL();
    return $rows;
}
