<?php 
    session_start();
    $noNavbar = '';
    $pageTitle = 'login';

    if(isset($_SESSION['Username'])){
        header('location: dashboard.php');
    }
    include '../admin/init.php';

    // Check of user from HTTP POST Request
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashePass = sha1($password);
    
        //Check if the User exist in Database
        $stmt = $con->prepare("SELECT UserID,Username,Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
        $stmt->execute(array($username,$hashePass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){
            $_SESSION ['Username'] = $username;
            $_SESSION ['ID'] = $row['UserID'];
            header('location: dashboard.php');
            exit();
               }
    }


?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center"> Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="naw-password" />
    <input  class="btn btn-primary btn-block" type="submit" value="Login">
</form>

<?php include $tpl .'footer.php'; ?>
