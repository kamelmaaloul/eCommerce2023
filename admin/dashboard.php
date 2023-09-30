<?php
ob_start(); /* Output Buffering Start */
session_start();
if(isset($_SESSION['Username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    /*   Start  Dashboard Page    */
?>
    <div class="container home-stats text-center">

    <h1 class='text-center'>Dashboard</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="stat st-members">
                <i class="fa fa-users"></i>
                    <div class="info">
                        Total Members
                        <span><a href="members.php" style="text-decoration: none;"><?php echo countItems('UserID','users')?></a></span>
                    </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-pending">
            <i class="fa fa-user-plus"></i>
                <div class="info">
                Pending Members
                <span><a href="members.php?do=Manage&page=Pending" style="text-decoration: none;">
                <?php echo checkItem("RegStatus","users",0);?></a>
                </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-items">
            <i class="fa fa-tag"></i>
               <div class="info">
                Total Items
                <span><a href="items.php" style="text-decoration: none;"><?php echo countItems('Item_ID','items')?></a></span>
               </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-comments">
            <i class="fa fa-comments"></i>
                <div class="info">
                Total comments
                <span><a href="comments.php" style="text-decoration: none;"><?php echo countItems('C_ID','comments')?></a></span>
                </div>
            </div>
        </div>
    </div>
    </div>
        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <?php $numUsers = 4 ?>
                        <div class="panel-heading">
                            <i class="fa fa-users"></i>Latest <?php echo $numUsers ?> Registerd Users
                        </div>
                        <div class="panel-body" style="background-color: #EEE;">
                            <ul class="list-unstyled latest-users"
                            <?php
                            $theLatest = getLatest("*","users","UserID",$numUsers);
                            if (!empty($theLatest)){
                            foreach($theLatest as $user){
                                echo '<li>';
                                echo $user['Username'];
                                echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                echo '<span class="btn btn-success pull-right">';
                                echo '<i class="fa fa-edit"></i>Edit</span>';
                                if ($user['RegStatus']==0)  {
                                    echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] ."' class='activate btn btn-info pull-right' style='margin-left=5px'><i class ='fa fa-close'></i>Activate</a>";
                                 }
                                echo '</a>';
                                echo  '</li>';
                            }
                        }else{
                            echo 'This is not record';
                        }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                    <?php $numItems = 4 ?>
                        <div class="panel-heading">
                        <i class="fa fa-users"></i>Latest <?php echo $numItems ?> Registerd Items
                        </div>
                        <div class="panel-body" style="background-color: #EEE;">
                        <ul class="list-unstyled latest-users"
                            <?php
                               $latestItems = getLatest("*","items","Item_ID","$numItems");
                               if (!empty($latestItems)){
                                foreach($latestItems as $item){
                                echo '<li>';
                                echo $item['Name'];
                                echo '<a href="items.php?do=Edit&userid=' . $item['Item_ID'] . '">';
                                echo '<span class="btn btn-success pull-right">';
                                echo '<i class="fa fa-edit"></i>Edit</span>';
                                if ($item['Approve']==0)  {
                                    echo "<a href='items.php?do=Approve&userid=" . $item['Item_ID'] ."' class='activate btn btn-info pull-right' style='margin-left=5px'><i class ='fa fa-check'></i>Approve</a>";
                                 }
                                echo '</a>';
                                echo  '</li>';
                            }
                        }else{
                            echo 'This is not record';
                        }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php



    /*   End Dashboard Page    */
    include $tpl .'footer.php';
} else {
header('location: index.php');
exit();
}
ob_end_flush();
?>
