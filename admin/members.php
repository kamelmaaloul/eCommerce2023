<?php 
ob_start(); /* Output Buffering Start */
session_start();
$pageTitle = 'members';

        if(isset($_SESSION['Username'])){
            include 'init.php';
             $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if($do == 'Manage') {  //Manage PAge
        $query = '';
        if(isset($_GET['page']) && $_GET['page']=='Pending') {
            $query = 'AND RegStatus = 0';
        }
            $stmt = $con->prepare("SELECT * 
                                   FROM users 
                                   WHERE  GroupID != 1 $query
                                   ORDER BY UserID DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();        
        ?>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <table class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <th style="background-color: Violet;">#ID</th>
                            <th style="background-color: Violet;">Avatar</th>
                            <th style="background-color: Violet;">Username</th>
                            <th style="background-color: Violet;">Email</th>
                            <th style="background-color: Violet;">Full Name</th>
                            <th style="background-color: Violet;">Registerd Date</th>
                            <th style="background-color: Violet;">Control</th>
                        </tr>
                            <?php
                                foreach($rows as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['UserID']   . "</td>";
                                    echo "<td>";
                                    if(empty($row['Avatar'])){
                                        echo "<img src='uploads/avatars/default_image.PNG' width=50px height=50px alt=''/>";
                                    }else {
                                        echo "<img src='uploads/avatars/" . $row['Avatar'] . "' width=50px height=50px alt=''/>";
                                    }
                                    echo "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Email']    . "</td>";
                                    echo "<td>" . $row['Fullname'] . "</td>";
                                    echo "<td>" . $row['Date']     . "</td>";
                                    echo "<td>" . "<a href='members.php?do=Edit&userid=" . $row['UserID'] ."' class='btn btn-success'><i class ='fa fa-edit'></i>Edit</a>" . '  ' .
                                                  "<a href='members.php?do=Delete&userid=" . $row['UserID'] ."' class='confirm btn btn-danger'><i class ='fa fa-close'></i>Delete</a>";
                                                if ($row['RegStatus']==0)  {
                                                   echo "<a
                                                    href='members.php?do=Activate&userid=" . $row['UserID'] ."'
                                                     class='activate btn btn-info' style='margin-left=5px'>
                                                     <i class ='fa fa-check'></i>Activate</a>";

                                                }
                                    echo "</td>";
                                    echo "</tr>";

                                }

                            ?>
                            
                        </tr>
                        </table>
                </table>
            <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
            </div>

    <?php }elseif ($do == 'Add') { // Add Page   ?> 
                <h1 class="text-center">Add New Member</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <div class="form-group form-group-lg">
                            <label class="required">Username:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" class="form-control" autocomplete="off" required="required"/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Password:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="password" name="password" class="form-control" autocomplete="new-password" required="required"/>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Email:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email"  class="form-control" required="required" />
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Full Name:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full" class="form-control" required/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">User Avatar:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="file" name="avatar" class="form-control" required/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 com-sm-10">
                                <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                            </div>
                    </div>

                    </form>
                </div>        
       <?php 
       
    }elseif ($do == 'Insert'){  // Insert Page
                echo "<h1 class='text-center'>Insert Member</h1>";
                echo "<div class = 'container'>";
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    // upload file or image
                    $avatar = $_FILES['avatar'];
                    $avatarName = $_FILES['avatar']['name'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp = $_FILES['avatar']['tmp_name'];
                    $avatarType = $_FILES['avatar']['type'];
                    $avatarAllowedExtension = array("jpeg","png","jpg","gif");
                    //get avatar extension
                    $avatarexplod = explode('.',$avatarName);
                    $avatarExtension = strtolower(end($avatarexplod)); // strtolower: change small caracters
                    

                    // get variable from form
                    $user   = $_POST['username'];
                    $pass   = $_POST['password'];
                    $email  = $_POST['email'];
                    $name   = $_POST['full'];
                    $hashPass = sha1($_POST['password']);
                    // VAlidate the Form
                    $formErrors = array();
                        if(strlen($user) < 3)  { $formErrors[] = 'Username can be less than <strong>3 characters</strong>';}
                        if(strlen($name) < 3)  { $formErrors[] = 'Fullname can be less than <strong>3 characters</strong>';}
                        if(strlen($user) > 20) { $formErrors[] = 'Username can be more than <strong>20 characters</strong>';}
                        if(strlen($name) > 20) { $formErrors[] = 'Fullname can be more than <strong>20 characters</strong>';}
                        if (empty($user))     { $formErrors[] =  'User can be <strong>empty</strong>';}
                        if (empty($pass))     { $formErrors[] =  'Password can be <strong>empty</strong>';}
                        if (empty($email))     { $formErrors[] = 'Email can be <strong>empty</strong>';}
                        if (empty($name))      { $formErrors[] = 'Fullname can be <strong>empty</strong>';}
                        if(! empty($avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)){ $formErrors[] = 'This extension file not <strong>Allowed</strong>';}
                        if(empty($avatarName)){ $formErrors[] = 'Avatar is <strong>Required</strong>';}
                        if($avatarSize>4190304){ $formErrors[] = 'Avatar Size can be larger than <strong>4MB</strong>';}
                   
                    foreach($formErrors as $error) {
                         echo '<div class= "alert alert-danger">' . $error . '</div>';
                        }

                    if (empty($formErrors)){
                            $avatar = rand(0,100000) . '_' . $avatarName;
                            move_uploaded_file($avatarTmp,"uploads\avatars\\" . $avatar);

                            $check = checkItem("Username","users",$user);
                            if($check == 1){                                
                                $theMsg = '<div class= "alert alert-danger">' . "Sorry this User name exist!" . '</div>';
                                redirectHome($theMsg, 'back' ,6);
                            }else {
                                $stmt = $con->prepare("INSERT INTO 
                                users(Username, Password, Email, Fullname, RegStatus, Date,Avatar)
                                VALUES(:zuser, :zpass, :zmail, :zname, 1,now(),:zavatar) ");
                                $stmt->execute(array(
                                    'zuser'   => $user,
                                    'zpass'   => $hashPass,
                                    'zmail'   => $email,
                                    'zname'   => $name,
                                    'zavatar'   => $avatar
                                ));
                                $theMsg = "<div class='alert alert-success'>" . 'You have been registered successfully </div>';
                                redirectHome($theMsg, 'back' ,7);

                            }                      

                    }
                
                }else{
                    $theMsg = "<div class='alert alert-danger'>Sorry you cant browse this page directly</div>";
                    redirectHome($theMsg,6);
                }
                echo "</div>";               

    }elseif ($do == 'Edit') {   // Edit Page 
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
                $stmt->execute(array($userid));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count > 0){
                    ?>
                <h1 class="text-center">Edit Member</h1>
                 <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                    <div class="form-group form-group-lg">
                            <label class="required">Username:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required"/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>"/>
                                <input type="text" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave blank if you dont want to change"/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Email:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Full Name:</label>
                            <div class="col-sm-10 col-md-4">
                                <input type="text" name="full" value="<?php echo $row['Fullname'] ?>" class="form-control" required/>
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
                echo "<h1 class='text-center'>Update Member</h1>";
                echo "<div class = 'container'>";
                      if($_SERVER['REQUEST_METHOD']=='POST'){
                            $id     = $_POST['userid'];
                            $user   = $_POST['username'];
                            $email  = $_POST['email'];
                            $name   = $_POST['full'];
                            $pass   = '';
                            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;
                            // VAlidate the Form
                            $formErrors = array();
                                if(strlen($user) < 3)  { $formErrors[] = '<div class= "alert alert-danger">Username can be less than <strong>3 characters</strong></div>';}
                                if(strlen($name) < 3)  { $formErrors[] = '<div class= "alert alert-danger">Fullname can be less than <strong>3 characters</strong></div>';}
                                if(strlen($user) > 20) { $formErrors[] = '<div class= "alert alert-danger">Username can be more than <strong>20 characters</strong></div>';}
                                if(strlen($name) > 20) { $formErrors[] = '<div class= "alert alert-danger">Fullname can be more than <strong>20 characters</strong></div>';}
                                if (empty($user))     { $formErrors[] = '<div class= "alert alert-danger">User can be <strong>empty</strong></div>';}
                                if (empty($email))     { $formErrors[] = '<div class= "alert alert-danger">Email can be <strong>empty</strong></div>';}
                                if (empty($name))      { $formErrors[] = '<div class= "alert alert-danger">Fullname can be <strong>empty</strong></div>';}
                            foreach($formErrors as $error) { echo $error . '</br>';}

                            if (empty($formErrors)){
                                $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                                $stmt2->execute(array($user, $id));
                                $count = $stmt2->rowCount();
                                if($count == 1){
                                    $theMsg = "<div class='alert alert-danger'>Soory this User is exist</div>";
                                    redirectHome($theMsg, 'back',6);
                                }else{
                                $stmt = $con->prepare("UPDATE users SET Username = ? ,Email = ? , Fullname = ? , Password = ?  WHERE UserID = ? ");
                                $stmt->execute(array($user,$email,$name,$pass,$id));
                                $theMsg = "<div class='alert alert-success'>" . 'This member has been updated </div>';
                                redirectHome($theMsg, 'back' ,6);
                                 }
                            }
                          
                        }else{
                            $theMsg = "<div class='alert alert-danger'>Sorry you cant browse this page directly</div>";
                            redirectHome($theMsg, 'back',6);
                        }
                        echo "</div>";
    } elseif ($do == 'Activate') {
                    echo "<h1 class='text-center'>Activate Member</h1>";
                    echo "<div class = 'container'>";
                    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
                    $stmt->execute(array($userid));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
                        $stmt->execute(array($userid));
                        $theMsg = "<div class='alert alert-success'>" .'This member has been activated </div>';
                        redirectHome($theMsg, 'back',6);              
            
                    }else {
                                    $theMsg = "<div class='alert alert-danger'>This is UserID Not Exisist</div>";
                                        redirectHome($theMsg,6);              
                                        }
                echo "</div>";      
    }elseif ($do == 'Delete') {
                echo "<h1 class='text-center'>Delete Member</h1>";
                echo "<div class = 'container'>";
                    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
                    $stmt->execute(array($userid));
                    $count = $stmt->rowCount();
                    if($count > 0){
                        $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
                        $stmt->bindParam(":zuser",$userid);
                        $stmt->execute();
                        $theMsg = "<div class='alert alert-success'>" . 'This member has been deleted </div>';
                        redirectHome($theMsg,'back',6);          
                    }else {
                                       $theMsg = "<div class='alert alert-danger'>This is UserID Not Exisist</div>";
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
