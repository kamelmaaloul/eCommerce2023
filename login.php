<?php 
    ob_start(); /* Output Buffering Start */
    session_start();
    $pageTitle = 'login';
    if(isset($_SESSION['user'])){
        header('location: index.php');
    }  

    include '../eCommerce/init.php';

    if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['login'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashePass = sha1($pass);
    
        //Check if the User exist in Database
        $stmt = $con->prepare("SELECT UserID,Username,Password 
                               FROM users 
                               WHERE Username = ? AND Password = ?");
        $stmt->execute(array($user,$hashePass));
        $get = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){
            $_SESSION ['user'] = $user;
            $_SESSION['uid']   = $get['UserID']; //register UserID
            print_r($_SESSION);
            header('location: index.php');
            exit();
               }
              } else {
                $formErrors = array();
                $username  = $_POST['username'];
                $password  = $_POST['password'];
                $password2 = $_POST['password2'];
                $email     = $_POST['email'];
                if(isset($username)){
                  $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
                  if(strlen($filterdUser) < 4 ) {
                      $formErrors[] = 'Username must be larger than 4 characters';
                  }
                }

                if(isset($password)&& isset($password2)){
                  if(empty($password)){
                    $formErrors[] = 'Sorry Password can be Empty';
                  }
                  $pass1 = sha1($password);
                  $pass2 = sha1($password2);
                  if($pass1 !== $pass2){
                    $formErrors[] = 'Sorry the Password is not Match';
                  }
                }

                if(isset($email)){
                  $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                  if(filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true ) {
                      $formErrors[] = 'This Email is not Valid';
                  }
                }
                if (empty($formErrors)){
                  $check = checkItem("Username","users",$username);
                  if($check == 1){                      
                    $formErrors[] = 'Sorry this user is Exist';
                  }else {
                      $stmt = $con->prepare("INSERT INTO 
                      users(Username, Password, Email, RegStatus, Date)
                      VALUES(:zuser, :zpass, :zmail, 0,now()) ");
                      $stmt->execute(array(
                          'zuser'   => $username,
                          'zpass'   => sha1($password),
                          'zmail'   => $email
                      ));
                      $succesMsg = 'You have been registered successfully';
                  }                      

          }
              }
    }

?>
    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" data-class="login">Login</span> | 
            <span class="z-selected" data-class="signup">Signup</span>
        </h1>
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="input-container">    
              <input class="form-control" type="text"
               name="username" placeholder="Username"
                autocomplete="off" required />
            </div>
            <div class="input-container">
              <input class="form-control" type="password"
               name="password" placeholder="Password" 
               autocomplete="new-password" required />
            </div>
              <button class="btn btn-info w-100" name="login" type="submit">Login</button>
        </form>

        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="input-container">      
             <input  pattern=".{4,}" title="Username must be larger than 4 characters"
              class="form-control" type="text" name="username"
              placeholder="Username" autocomplete="off" required />
            </div>
            <div class="input-container">
              <input minlength="8" class="form-control" type="password" 
              name="password" placeholder="Password" 
              autocomplete="new-password" required />
            </div>
            <div class="input-container">    
              <input minlength="8" class="form-control" type="password"
               name="password2" placeholder="Password Again"
                autocomplete="new-password" required />
            </div>
            <div class="input-container">    
              <input class="form-control" type="email" 
              name="email" placeholder="Your Valid Email" required />
            </div>
              <button class="btn btn-success w-100" name="signup" type="submit">Sinup</button>
        </form>
        <div class="the-errors text-center">
          <?php 
          if(!empty($formErrors)){
            foreach($formErrors as $error){
              echo '<div class="msg error">' . $error . '</div>';
            }
          }
          if(isset ($succesMsg)){
            echo '<div class="msg succes">' . $succesMsg . '</div>';
          }
          ?>

        </div>


    </div>

<?php
    include $tpl .'footer.php'; 
ob_end_flush();
?>