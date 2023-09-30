<?php 
    ob_start();
    session_start();
    $pageTitle = 'Create New Item';
    include '../eCommerce/init.php';
    if(isset($_SESSION['user'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $formErrors = array();

            $name      = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $desc      =filter_var( $_POST['description'],FILTER_SANITIZE_STRING);
            $price     = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country   = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $status    = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
            $category  = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);

            if(strlen($name) < 4 ) {
                $formErrors[] = 'Title must be larger than 4 characters';
            }
            if(strlen($desc) < 10 ) {
                $formErrors[] = 'Description must be larger than 10 characters';
            }
            if(strlen($country) < 2 ) {
                $formErrors[] = 'Country must be larger than 2 characters';
            }
            if(empty($price)) {
                $formErrors[] = 'Price must be not empty';
            }
            if(empty($status)) {
                $formErrors[] = 'Status must be not empty';
            }
            if(empty($category)) {
                $formErrors[] = 'Category must be not empty';
            }
        
            if (empty($formErrors)){                                                 
                $stmt = $con->prepare("INSERT INTO 
                items(Name, Description, Price, Country_Made, Status, Add_Date,Cat_ID,Member_ID)
                VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus , now(),:zcat,:zmember)");
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zprice'    => $price,
                    'zcountry'  => $country,
                    'zstatus'   => $status,
                    'zcat'      => $category,
                    'zmember'   => $_SESSION['uid']
                ));
                if($stmt){
                $theMsg = "<div class='alert alert-success'>" . 'You have been registered successfully </div>';
                redirectHome($theMsg, 'back' ,7);
                } else {
                    $theMsg = "<div class='alert alert-danger'>" . 'You have been Not registered </div>';
                redirectHome($theMsg, 'back' ,7);

                }                                             
            }
        }
?>

    <h1 class="text-center">Create New Item</h1>
        <div class="create-ad block" style="margin: 20px 0 0;">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="background-color: #81ecec;">Create New Item</div>
                    <div class="panel-body" style="background-color: #EEE;">
                        <div class="row">
                            <div class="col-md-8">

                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="form-group form-group-lg">
                            <label class="required">Name:</label>
                            <div class="col-sm-10 col-md-9">
                                <input pattern=".{4,}" title="Name must be larger than 4 characters"
                                 type="text" name="name" class="form-control live"
                                 autocomplete="off" data-class=".live-title" required />
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Description:</label>
                            <div class="col-sm-10 col-md-9">
                                <input pattern=".{10,}" title="Description must be larger than 10 characters"
                                type="text" name="description" class="form-control live"
                                 autocomplete="off" data-class=".live-desc" required />
                            </div>
                    </div>
                           
                    <div class="form-group form-group-lg">
                            <label class="required">Price:</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="price" class="form-control live"
                                 autocomplete="off" data-class=".live-price" required />
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Country of Made:</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="country" class="form-control" autocomplete="off" required/>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <label class="required">Status:</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="status" required>
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>

                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group form-group-lg">
                            <label class="required">Category:</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="category" required>
                                    <option value="0">...</option>
                                    <?php
                                    $cats = getAllFrom('*','categories','','','ID');
                                    foreach($cats as $cat){
                                        echo "<option value='" .$cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                    }

                                    ?>

                                </select>
                            </div>
                    </div>

                    <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 com-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary btn-sm w-100" style="margin-top: 10px;" />
                            </div>
                    </div>

            </form>
                            </div>
                            <dic class="col-md-4">
                                <div class="thumbnail item-box live-preview">
                                    <span class = "price-tag">
                                        $<span class="live-price"></span>
                                    </span>
                                    <img class = "img-responsive" src="img.png" alt="" />
                                    <div class="caption">
                                         <h3 class="live-title">Title</h3>
                                         <p class="live-desc">Description</p>
                                    </div>
                                 </div>
                            </div>
                        </div>

                        <?php
                            if(!empty($formErrors)){
                                foreach($formErrors as $error){
                                  echo '<div class="alert alert-danger">' . $error . '</div>';
                                }
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