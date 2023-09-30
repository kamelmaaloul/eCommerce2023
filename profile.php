<?php 
    ob_start();
    session_start();
    $pageTitle = 'Profile';
    include '../eCommerce/init.php';
    if(isset($_SESSION['user'])){
        $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
        $getUser->execute(array($sessionUser));
        $info = $getUser->fetch();
?>

    <h1 class="text-center">My Profile</h1>
        <div class="information block" style="margin: 20px 0 0;">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="background-color: #81ecec;">My Information</div>
                    <div class="panel-body" style="background-color: #EEE;">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name: </span>           <?php echo $info['Username'] ?>
                         </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Email: </span>          <?php echo $info['Email'] ?>
                         </li>
                        <li>
                           <i class="fa fa-user fa-fw"></i>
                           <span>Fullname: </span>       <?php echo $info['Fullname'] ?>
                         </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Regdate: </span>        <?php echo $info['Date'] ?>
                         </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favourite Category:</span>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit Information</a>
                    </div>
                </div>

            </div>
        </div>

        <div id="my-ads"  class="my-ads block" style="margin: 20px 0 0;">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="background-color: #81ecec;">My Ads</div>
                    <div class="panel-body" style="background-color: #EEE;">
                    <?php
                        if(!empty(getItems('Member_ID',$info['UserID']))){
                            echo '<div class="row">';
                            foreach(getItems('Member_ID',$info['UserID'],1) as $item){
                                echo '<div class="col-sm-6 col-md-3">';
                                    echo '<div id="first" class="thumbnail item-box">';
                                    if($item['Approve']==0){echo '<span id="first1" class="approve-status">Waiting Approval</span>';}
                                    echo '<span class = "price-tag">'. '$'. $item['Price'] . '</span>';
                                        echo'<img class = "img-responsive" src="img.png" alt="" />';
                                        echo '<div class="caption">';
                                            echo '<h3><a href = "items.php?itemid='. $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
                                            echo '<p>' . $item['Description'] . '</p>';
                                            echo '<div class = "date">' . $item['Add_Date'] . '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                                }
                                echo '</div>';
                            }else {
                                echo 'Sorry is not Ads to show , Create <a href="newad.php">New Ad</a>';

                                }
                            ?>
                        
                    </div>
                </div>

            </div>
        </div>

        <div class="my-comments block" style="margin: 20px 0 0;">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="background-color: #81ecec;">My Comments</div>
                    <div class="panel-body" style="background-color: #EEE;">
                        <?php 
                            $stmt = $con->prepare("SELECT Comment FROM comments WHERE user_id = ?");
                            $stmt->execute(array($info['UserID']));
                            $comments = $stmt->fetchAll(); 
                            if(! empty($comments)) {
                                foreach($comments as $comment){
                                    echo '<p>' . $comment['Comment'].'</p>';
                                }

                            } else {
                                echo 'Ther is Not Comments';
                            }
                        ?>
                    </div>
                </div>

            </div>
        </div>
  
<?php 
    }else {
        header('location:login.php');
        exit();
    }
    include $tpl .'footer.php'; 
ob_end_flush();
?>