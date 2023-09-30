<?php 
    ob_start();
    session_start();
    $pageTitle = 'Show Items';
    include '../eCommerce/init.php';

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    $stmt = $con->prepare("SELECT items.* , categories.Name AS category_name, users.Username
                           FROM items
                           INNER JOIN categories ON categories.ID = items.Cat_ID
                           INNER JOIN users ON users.UserID = items.Member_ID 
                            WHERE Item_ID = ? AND Approve=1
                            ");
    $stmt->execute(array($itemid));
    $count = $stmt->rowCount();
    if($count > 0) {
    $item = $stmt->fetch();
?>
    <h1 class="text-center"> <?php echo $item['Name']  ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
           <?php echo "<img src='admin/uploads/items/" . $item['Image'] . "' width=200px height=200px alt=''/>";
           echo $item['Image'];
           ?>
            </div>
            <div class="col-md-9">
                <h2> <?php echo $item['Name'] ?> </h2>
                <p> <?php echo $item['Description'] ?> </p>
                <ul class="list-unstyled">
                    <li><span>Added Date:</span> <?php echo $item['Add_Date'] ?> </li>
                    <li><span>Price: $</span> <?php echo $item['Price'] ?> </li>
                    <li><span>Made in :</span>  <?php echo $item['Country_Made'] ?> </li>
                    <li><i class="fa fa-tags fa-fw"></i>
                        <span> Category :</span> <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"> <?php echo $item['category_name'] ?> </a></li>
                    <li> <i class="fa fa-user fa-fw"></i>
                        <span>Added By :</span>  <?php echo $item['Username'] ?> </li>
                </ul>
            </div>
        </div>
        <hr>
        
        <?php if(isset($_SESSION['user'])) { ?> 
        <div class="row">
            <div class="col-md-offset-3">
                <div class="add-comment">
                    <h3>Added Your Comments</h3>
                    <form  action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                        <textarea class="form-control" name="comment" required></textarea>
                        <input class="btn btn-primary mb-3" type="submit" value="Add Comment">
                    </form>
                    <?php
                            if($_SERVER['REQUEST_METHOD']=='POST'){
                                $comment    = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                                $userid     =$_SESSION['uid'];
                                $itemid     =$item['Item_ID'];
                                if(! empty($comment)){
                                   $stmt=$con->prepare("INSERT INTO 
                                                       comments(Comment,Status,Comment_Date,item_id,user_id)
                                                       values(?,0,NOW(),?,?)");
                                   $stmt->execute(array($comment,$itemid,$userid));
                                 if($stmt){
                                        echo '<div class="alert alert-success">Comment has been Added </div>';
                                    }
                                }
                            
                            }

                    ?>
                </div>
            </div>
        </div>
<?php   } else {
    echo ' <a href="login.php">Login or register </a> to added comments';
}  ?>
        <hr>
                <?php
                     $stmt = $con->prepare("SELECT comments.* ,users.Username AS Member
                                            FROM comments
                                            INNER JOIN users ON  users.UserID = comments.user_id
                                            WHERE item_id = ? AND Status = 1
                                            ORDER BY C_ID DESC");
                    $stmt->execute(array($item['Item_ID']));
                    $comments = $stmt->fetchAll(); 
                   
                ?>
               <?php foreach($comments as $comment){ ?>
                <div class="comment-box" style="margin-bottom: 5px;">
                    <div class="row">
                        <div class="col-sm-2 text-center">
                            <img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />
                            <?php echo $comment['Member'] ?>
                        </div>
                        <div class="col-sm-10">
                            <p class="lead" style="background-color: #eee;" ><?php echo $comment['Comment'] ?></div></p>
                        </div>
                    </div>
               </div>
            <hr class="custom-hr">
                   <?php } ?>                
            </div>

<?php 
    } else {
        $Msg = '<div class="alert alert-danger">There is not such ID OR this Item is Waiting Approval</div>';
        redirectHome($Msg, 'back' ,6);
    }
    include $tpl .'footer.php'; 
ob_end_flush();
?>