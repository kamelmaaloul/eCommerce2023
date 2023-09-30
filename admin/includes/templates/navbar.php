
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <!-- Example Code -->
    
    <nav class="navbar navbar-expand-lg navbar-expand-sm bg-info">
      <div class="container">
        <a class="navbar-brand" href="dashboard.php"><?php echo lang('Home'); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item">
            <a class="nav-link" href="categories.php"><?php echo lang('Categories'); ?></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="items.php"><?php echo lang('Items'); ?></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="members.php"><?php echo lang('Members'); ?></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="comments.php"><?php echo lang('Comments'); ?></a>
            </ul>
            <div class="topnav-right nav navbar-nav navbar-right">
            
            <div class="topnav-right">
            <li class="nav-item dropdown nav navbar-nav ">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Kamel
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
                <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
              </ul>
            </li>
           </div>
        </div> 
                    
        </div>
      </div>
    </nav>
    
    <!-- End Example Code -->
  