<?php 
ob_start(); /* Output Buffering Start */
session_start();
$pageTitle = 'Comments';

        if(isset($_SESSION['Username'])){
            include 'init.php';
             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if($do == 'Manage') {  //Manage PAge
            $stmt = $con->prepare("SELECT comments.*,items.Name AS Item_Name,users.Username 
                                   FROM comments
                                   INNER JOIN items ON items.Item_ID = comments.item_id
                                   INNER JOIN users ON  users.UserID = comments.user_id
                                   ORDER BY C_ID DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();        
        ?>
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <table class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <th style="background-color: Violet;">#ID</th>
                            <th style="background-color: Violet;">Comment</th>
                            <th style="background-color: Violet;">Item Name</th>
                            <th style="background-color: Violet;">User Name</th>
                            <th style="background-color: Violet;">Added Date</th>
                            <th style="background-color: Violet;">Control</th>
                        </tr>
                            <?php
                                foreach($rows as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['C_ID']   . "</td>";
                                    echo "<td>" . $row['Comment'] . "</td>";
                                    echo "<td>" . $row['Item_Name']    . "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Comment_Date']     . "</td>";
                                    echo "<td>" . "<a href='comments.php?do=Edit&comid=" . $row['C_ID'] ."' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>" . '  ' .
                                                  "<a href='comments.php?do=Delete&comid=" . $row['C_ID'] ."' class='confirm btn btn-danger'><i class ='fa fa-close'></i>Delete</a>";
                                                if ($row['Status']==0)  {
                                                   echo "<a
                                                    href='comments.php?do=Approve&comid=" . $row['C_ID'] ."'
                                                     class='activate btn btn-info' style='margin-left=5px'>
                                                     <i class ='fa fa-check'></i>Approve</a>";
                                                }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>                            
                        </tr>
                        </table>
                </table>
            </div>

    <?php           

    }elseif ($do == 'Edit') {   // Edit Page 
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? ");
                $stmt->execute(array($comid));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count > 0){
                    ?>
                <h1 class="text-center">Edit Comment</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="comid" value="<?php echo $comid ?>" />
                    <div class="form-group form-group-lg">
                            <label class="required">Comment:</label>
                            <div class="col-sm-10 col-md-4">
                                <textarea class="form-control" name="comment"> 
                                    <?php  echo $row['Comment']; ?>
                                </textarea>
                            </div>
                    </div>
                 
                                       
                    <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 com-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                            </div>
                    </div>

                    </form>
                </div>
            <?php    }else {
                        echo '';
                        $theMsg = "<div class='alert alert-danger'>There is No Such ID</div>";
                        redirectHome($theMsg,'back',6);
                       }

    } elseif ($do == 'Update') {
                echo "<h1 class='text-center'>Update Comment</h1>";
                echo "<div class = 'container'>";
                      if($_SERVER['REQUEST_METHOD']=='POST'){
                            $id     = $_POST['comid'];
                            $com   = $_POST['comment'];
                            // VAlidate the Form
                                $stmt = $con->prepare("UPDATE comments SET Comment = ? WHERE C_ID = ? ");
                                $stmt->execute(array($com,$id));
                                $theMsg = "<div class='alert alert-success'>" . 'This comment has been updated </div>';
                                redirectHome($theMsg,6);
                            
                            } else{
                            $theMsg = "<div class='alert alert-danger'>Sorry you cant browse this page directly</div>";
                            redirectHome($theMsg, 'back',6);
                                  }
                echo "</div>";
    } elseif ($do == 'Approve') {
                    echo "<h1 class='text-center'>Approve Member</h1>";
                    echo "<div class = 'container'>";
                    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? LIMIT 1");
                    $stmt->execute(array($comid));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID = ?");
                        $stmt->execute(array($comid));
                        $theMsg = "<div class='alert alert-success'>" .'This comment has been approved </div>';
                        redirectHome($theMsg, 'back',6);              
            
                    }else {
                                    $theMsg = "<div class='alert alert-danger'>This is Comment ID Not Exisist</div>";
                                        redirectHome($theMsg,6);              
                                        }
                echo "</div>";      
    }elseif ($do == 'Delete') {
                echo "<h1 class='text-center'>Delete Comment</h1>";
                echo "<div class = 'container'>";
                    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID = ? LIMIT 1");
                    $stmt->execute(array($comid));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zcom");
                        $stmt->bindParam(":zcom",$comid);
                        $stmt->execute();
                        $theMsg = "<div class='alert alert-success'>" . 'This comment has been deleted </div>';
                        redirectHome($theMsg,'back',6);          
                    }else {
                                       $theMsg = "<div class='alert alert-danger'>This is Comment ID Not Exisist</div>";
                                        redirectHome($theMsg,6);              
                                        }
                echo "</div>";

    }else {
        header('location: index.php');
        exit();
            }

    include $tpl .'footer.php';
}

ob_end_flush();
?>
