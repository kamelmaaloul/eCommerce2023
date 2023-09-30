<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo getTitle();?></title>
    <link rel="stylesheet" href="<?php echo $css?>fronted.css" />
    <link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $css?>font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $css?>jquery-ui.min.css" />
    <link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php echo $css?>docs.css" />  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">
    <div class="container text-right">
        <?php
            if(isset($_SESSION['user'])){ ?>
            <img class="my-image img-thumbnail img-circle" src="img.png" alt=""/>
            <?php echo 'Welcome' . '  ' .$sessionUser; ?>
            <div class="btn-group my-info pull-right">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $sessionUser ?>
              </a>
                <span class="caret"></span>
              </span>
                <ul class="dropdown-menu">
                  <li><a href="profile.php">My Profile</a></li>
                  <li><a href="newad.php">New Item</a></li>
                  <li><a href="profile.php#my-ads">My Items</a></li>
                  <li><a href="logout.php">Logout</a></li>

                </ul>
            </div>

            <?php
                
              } else {  
        
        ?>
      <div class="title">
        <a href="login.php">
          <span class="logs">Login/Signup</span>
        </a>
        <?php } ?>
      </div>
    </div>
    <!-- Example Code -->
    
    <nav class="navbar navbar-expand-lg navbar-expand-sm bg-info">
      <div class="container ">
        <a class="navbar-brand" href="index.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav navbar-right">
          <?php 
          $categorie = getCat();
          foreach($categorie as $cat){
              echo '<li class="nav-item">
              <a class="nav-link" href="categories.php?pageid=' . $cat['ID'] .'">
              '.$cat ['Name'] . '</a></li>';
          }
          ?>

        </ul>
      </div>
      
    </nav>
    
    <!-- End Example Code -->
  
    
